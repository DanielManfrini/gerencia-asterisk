<?php

namespace App\Services\Ramais;

use App\Repositories\Ramais\ContextRepository;
use App\Services\Adm\AsteriskService;
use App\Services\Mensageiro\RabbitMQService;
use Illuminate\Http\Request;

class ContextService
{

  protected $rabbitMQService;
  protected $contextRepository;
  protected $asteriskService;

  public function __construct(RabbitMQService $rabbitMQService, ContextRepository $contextRepository, AsteriskService $asteriskService)
  {
    $this->rabbitMQService = $rabbitMQService;
    $this->contextRepository = $contextRepository;
    $this->asteriskService = $asteriskService;
  }

  public function create(Request $request)
  {
    try {
      $this->contextRepository->create(['name' => $request->input('context')]);
    } catch (\Exception $erro) {
      throw $erro;
    }

    try {
      $queue = 'servico-asterisk';
      $message = json_encode([
        'callBack' => 'contexto',
        'data' => [
          'type' => 'create',
          'command' => $request->input('context')
        ]
      ]);

      $this->rabbitMQService->send($queue, $message);

      $this->asteriskService->pjsipReload();

      return response()->json(['success' => true, 'message' => 'Contexto cadastrado com sucesso'], 200);
    } catch (\Exception $erro) {

      return response()->json(['success' => false, 'error' => 'Erro ao cadastrar contexto', 'exception' => $erro->getMessage()], 500);
    }
  }

  public function edit(Request $request)
  {

    $data = ['ContextId' => $request->input('ContextId'), 'name' => $request->input('new')];

    try {
      $this->contextRepository->edit($data);
    } catch (\Exception $erro) {
      throw $erro;
    }

    try {
      $queue = 'servico-asterisk';

      $param = $request->input('old') . " " . $request->input('new');

      $message = json_encode([
        'callBack' => 'contexto',
        'data' => [
          'type' => 'edit',
          'command' => $param
        ]
      ]);

      $this->rabbitMQService->send($queue, $message);

      $this->asteriskService->pjsipReload();

      return response()->json(['success' => true, 'message' => 'Contexto excluido com sucesso'], 200);
    } catch (\Exception $erro) {

      return response()->json(['success' => false, 'error' => 'Erro ao excluir contexto', 'exception' => $erro->getMessage()], 500);
    }
  }

  public function delete(Request $request)
  {
    try {
      $this->contextRepository->delete($request->input('ContextId'));
    } catch (\Exception $erro) {
      throw $erro;
    }
    try {
      $queue = 'servico-asterisk';
      $message = json_encode([
        'callBack' => 'contexto',
        'data' => [
          'type' => 'delete',
          'command' => $request->input('context')
        ]
      ]);

      $this->rabbitMQService->send($queue, $message);

      $this->asteriskService->pjsipReload();

      return response()->json(['success' => true, 'message' => 'Contexto excluido com sucesso'], 200);
    } catch (\Exception $erro) {

      return response()->json(['success' => false, 'error' => 'Erro ao excluir contexto', 'exception' => $erro->getMessage()], 500);
    }
  }
}
