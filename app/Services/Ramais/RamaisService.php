<?php

namespace App\Services\Ramais;

use App\Repositories\Ramais\AorsRepository;
use App\Repositories\Ramais\AuthsRepository;
use App\Repositories\Ramais\EndpointsRepository;
use App\Repositories\Filas\QueueMembersRepository;
use App\Services\Adm\AsteriskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RamaisService
{
  protected $authsRepository;
  protected $aorsRepository;
  protected $endpointsRepository;
  protected $queueMembersRepository;
  protected $asteriskService;

  public function __construct(
    AuthsRepository $authsRepository,
    AorsRepository $aorsRepository,
    EndpointsRepository $endpointsRepository,
    QueueMembersRepository $queueMembersRepository,
    AsteriskService $asteriskService
  ) {
    $this->authsRepository = $authsRepository;
    $this->aorsRepository = $aorsRepository;
    $this->endpointsRepository = $endpointsRepository;
    $this->queueMembersRepository = $queueMembersRepository;
    $this->asteriskService = $asteriskService;
  }

  private function createValidateMembers(object $request)
  {
    $queueList = [];

    foreach ($request->filas as $fila) {
      $queueList[] = [
        'queue_name' => $fila,
        'interface' => 'PJSIP/' . $request->login,
        'membername' => $request->login,
        'state_interface' => 'PJSIP/' . $request->login,
      ];
    }

    if (!empty($queueList)) {
      $createQuery = $this->queueMembersRepository->create($queueList);
      if (!$createQuery['success']) {
        throw new \Exception($createQuery['exception']);
      }
    }
  }

  private function editValidateMembers(array $QueueMembersList, array $filas, string $member)
  {
    $keepData = [];
    $deleteData = ['membername' => $member, 'queue_name' => []];
    $insertData = [];

    foreach ($QueueMembersList as $queue) {

      if (!in_array($queue['queue_name'], $filas)) {
        $deleteData['queue_name'][] = $queue['queue_name'];
      } else {
        $keepData[] = $queue['queue_name'];
      }
    }

    if (!empty($deleteData['queue_name'])) {
      $deleteQuery = $this->queueMembersRepository->delete($deleteData);
      if (!$deleteQuery['success']) {
        throw new \Exception($deleteQuery['exception']);
      }
    }

    foreach ($filas as $fila) {
      if (!in_array($fila, $keepData, false)) {
        $insertData[] = [
          'queue_name' => $fila,
          'interface' => 'PJSIP/' . $member,
          'membername' => $member,
          'state_interface' => 'PJSIP/' . $member,
        ];
      }
    }

    if (!empty($insertData)) {
      $createQuery = $this->queueMembersRepository->create($insertData);
      if (!$createQuery['success']) {
        throw new \Exception($createQuery['exception']);
      }
    }
  }

  public function create(Request $request)
  {
    DB::beginTransaction();

    try {

      $this->authsRepository->create($request->all());
      $this->aorsRepository->create($request->all());
      $this->endpointsRepository->create($request->all());

      if (isset($request->filas)) {
        $this->createValidateMembers($request->filas);
      }

      DB::commit();

      $this->asteriskService->pjsipReload();

      return response()->json(['success' => true, 'message' => 'Ramal criado com sucesso'], 200);
    } catch (\Exception $erro) {
      DB::rollBack();
      return response()->json(['success' => false, 'error' => 'Erro ao criar ramal', 'exception' => $erro->getMessage()], 500);
    }
  }

  public function edit(Request $request)
  {
    DB::beginTransaction();

    try {

      $this->authsRepository->edit($request->all());
      $this->aorsRepository->edit($request->all());
      $this->endpointsRepository->edit($request->all());

      $getRequest = new Request(['membername' => $request->id]);

      $QueueMembersList = $this->queueMembersRepository->get($getRequest);

      if (!empty($QueueMembersList)) {

        $this->editValidateMembers($QueueMembersList, isset($request->filas) ? $request->filas : [], $request->id);
      } else if (empty($QueueMembersList) && isset($request->filas)) {

        $this->createValidateMembers($request);
      }

      DB::commit();

      $this->asteriskService->pjsipReload();

      return response()->json(['success' => true, 'message' => 'Ramal editado com sucesso'], 200);
    } catch (\Exception $erro) {
      DB::rollBack();
      return response()->json(['success' => false, 'error' => 'Erro ao editar ramal', 'exception' => $erro->getMessage()], 500);
    }
  }

  public function delete(Request $request)
  {

    DB::beginTransaction();

    try {

      $this->authsRepository->delete($request->id);
      $this->aorsRepository->delete($request->id);
      $this->endpointsRepository->delete($request->id);
      $this->queueMembersRepository->delete($request->all());

      DB::commit();

      $this->asteriskService->pjsipReload();

      return response()->json(['success' => true, 'message' => 'Ramal excluido com sucesso'], 200);
    } catch (\Exception $erro) {

      DB::rollBack();
      return response()->json(['success' => false, 'error' => 'Erro ao excluir ', 'exception' => $erro->getMessage()], 500);
    }
  }
}
