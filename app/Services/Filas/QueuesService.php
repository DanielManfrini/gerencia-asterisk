<?php

namespace App\Services\Filas;

use App\Repositories\Filas\QueueMembersRepository;
use App\Repositories\Filas\QueueRulesRepository;
use App\Repositories\Filas\QueuesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueuesService
{
  protected $queuesRepository;
  protected $queueMembersRepository;
  protected $queueRulesRepository;

  public function __construct(
    QueuesRepository $queuesRepository,
    QueueMembersRepository $queueMembersRepository,
    QueueRulesRepository $queueRulesRepository
  ) {
    $this->queuesRepository = $queuesRepository;
    $this->queueMembersRepository = $queueMembersRepository;
    $this->queueRulesRepository = $queueRulesRepository;
  }

  private function compareMembers($a, $b)
  {
    if ($a['membername'] === $b['membername']) {
      return 0;
    }
    return ($a['membername'] < $b['membername']) ? -1 : 1;
  }

  private function validateRules(object $request)
  {
    if (is_array($request->rule)) {

      if ($request->rulesName) {

        $rulesData = [
          'rule_name' => $request->rulesName,
          'time' => $request->rulesTime,
          'min_penalty' => $request->rulesMinPenalty,
          'max_penalty' => $request->rulesMaxPenalty,
        ];

        try {
          $this->queueRulesRepository->create($rulesData);
        } catch (\Exception $erro) {
          throw $erro;
        }

        return $request->rulesName;
      }
    } else {
      return $request->rule;
    }
  }

  private function createValidateMembers(object $request)
  {
    $membersList = [];

    foreach ($request->membros as $membro) {
      $membersList[] = [
        'queue_name' => $request->name,
        'interface' => 'PJSIP/' . $membro,
        'membername' => $membro,
        'state_interface' => 'PJSIP/' . $membro,
        'ringinuse' => '0',
      ];
    }

    if (!empty($membersList)) {
      $createQuery = $this->queueMembersRepository->create($membersList);

      if (!$createQuery['success']) {
        throw new \Exception($createQuery['exception']);
      }
    }
  }

  private function editValidateMembers(object $request)
  {
    $getRequest = new Request(['queue_name' => $request->name]);

    $requestMembers = [];

    foreach ($request->membros as $membro) {
      $requestMembers[]['membername'] = $membro;
    }

    $membersList = $this->queueMembersRepository->get($getRequest);

    $membersAdd = array_udiff($requestMembers, $membersList, [$this, 'compareMembers']);

    if (!empty($membersAdd)) {
      $membersAddList = [];

      foreach ($membersAdd as $membro) {

        $membersAddList[] = [
          'queue_name' => $request->name,
          'interface' => 'PJSIP/' . $membro['membername'],
          'membername' => $membro['membername'],
          'state_interface' => 'PJSIP/' . $membro['membername'],
          'riginuse' => '0',
        ];
      }

      if (!empty($membersAddList)) {
        $createQuery = $this->queueMembersRepository->create($membersAddList);

        if (!$createQuery['sucess']) {
          throw new \Exception($createQuery['exception']);
        }
      }
    }

    $membersDell = array_udiff($membersList, $requestMembers, [$this, 'compareMembers']);

    if (!empty($membersDell)) {

      $membersDellList = [];

      foreach ($membersDell as $membro) {
        $membersDellList[] = $membro['membername'];
      }

      if (!empty($membersDellList)) {
        $deleteQuery = $this->queueMembersRepository->delete(['membername' => $membersDellList, 'queue_name' => $request->name]);

        if (!$deleteQuery['sucess']) {
          throw new \Exception($deleteQuery['exception']);
        }
      }
    }
  }

  public function get(?object $request)
  {

    $queueList =  $this->queuesRepository->get($request);
    $queueMembersList =  $this->queueMembersRepository->get($request);

    $queueListFormated = [];

    foreach ($queueList as $queue) {

      $newMembers = array_filter($queueMembersList, function ($members) use ($queue) {
        return $members['queue_name'] === $queue['name'];
      });

      $queueListFormated[] = array_merge($queue, ['members' => $newMembers]);
    }

    return response()->json($queueListFormated);
  }

  public function create(Request $request)
  {
    try {
      $queueData = [
        'name' => $request->name,
        'musiconhold' => 'default',
        'retry' => 5,
        'strategy' => $request->strategy,
      ];

      if (isset($request->rule)) {
        $queueData['defaultrule'] = $this->validateRules($request);
      }

      $this->queuesRepository->create($queueData);

      if (isset($request->membros)) {
        $this->createValidateMembers($request);
      }

      return response()->json(['success' => true, 'message' => 'Fila criado com sucesso'], 200);
    } catch (\Exception $erro) {
      return response()->json(['success' => false, 'error' => 'Erro ao criar Fila', 'exception' => $erro->getMessage()], 500);
    }
  }

  public function edit(Request $request)
  {
    try {
      DB::beginTransaction();

      $queueData = [
        'id' => $request->id,
        'name' => $request->name,
        'musiconhold' => 'default',
        'retry' => 5,
        'strategy' => $request->strategy,
      ];

      if (isset($request->rule)) {
        $queueData['defaultrule'] = $this->validateRules($request);
      }

      $this->queuesRepository->edit($queueData);

      if (isset($request->membros)) {
        $this->editValidateMembers($request);
      }

      DB::commit();
      return response()->json(['success' => true, 'message' => 'Fila editada com sucesso'], 200);
    } catch (\Exception $erro) {
      DB::rollback();
      return response()->json(['success' => false, 'error' => 'Erro ao editar fila', 'exception' => $erro->getMessage()], 500);
    }
  }

  public function delete(Request $request)
  {
    try {
      $this->queuesRepository->delete($request->all());

      $deleteQuery = $this->queueMembersRepository->delete($request->members);

      if (!$deleteQuery['sucess']) {
        throw new \Exception($deleteQuery['exception']);
      }

      return response()->json(['success' => true, 'message' => 'Fila excluida com sucesso'], 200);
    } catch (\Exception $erro) {
      return response()->json(['success' => false, 'error' => 'Erro ao excluir fila', 'exception' => $erro->getMessage()], 500);
    }
  }
}
