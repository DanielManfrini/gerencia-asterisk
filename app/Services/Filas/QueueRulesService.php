<?php

namespace App\Services\Filas;

use App\Repositories\Filas\QueueRulesRepository;

class QueueRulesService
{

  protected $queueRulesRepository;

  public function __construct(
    QueueRulesRepository $queueRulesRepository
  ) {
    $this->queueRulesRepository = $queueRulesRepository;
  }

  public function create(object $request)
  {
    try {

      $this->queueRulesRepository->create($request->all());

      return response()->json(['success' => true, 'message' => 'Regra criada com sucesso'], 200);
    } catch (\Exception $erro) {
      return response()->json(['success' => false, 'error' => 'Erro ao criar regra', 'exception' => $erro->getMessage()], 500);
    }
  }
  public function save(object $request)
  {
    try {

      $this->queueRulesRepository->edit($request->all());

      return response()->json(['success' => true, 'message' => 'Regra editada com sucesso'], 200);
    } catch (\Exception $erro) {
      return response()->json(['success' => false, 'error' => 'Erro ao editar regra', 'exception' => $erro->getMessage()], 500);
    }
  }
  public function delete(object $request)
  {
    try {

      return response()->json(['success' => true, 'message' => 'Regra excluída com sucesso'], 200);
    } catch (\Exception $erro) {
      return response()->json(['success' => false, 'error' => 'Erro ao excluir regra', 'exception' => $erro->getMessage()], 500);
    }
  }
}
