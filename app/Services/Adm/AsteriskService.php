<?php

namespace App\Services\Adm;

use App\Repositories\Adm\AsteriskRepository;
use App\Services\Mensageiro\RabbitMQService;
use Illuminate\Http\JsonResponse;

class AsteriskService
{

  protected $rabbitMQService;
  protected $asteriskRepository;

  public function __construct(RabbitMQService $rabbitMQService, AsteriskRepository $asteriskRepository)
  {
    $this->rabbitMQService = $rabbitMQService;
    $this->asteriskRepository = $asteriskRepository;
  }

  public function pjsipReload()
  {

    $queue = 'servico-asterisk';

    $mensage = json_encode([
      'callBack' => 'comando',
      'data' => 'sudo asterisk -rx "pjsip reload"'
    ]);

    $this->rabbitMQService->send($queue, $mensage);
  }

  public function getCDR(object $request): JsonResponse
  {
    return response()->json($this->asteriskRepository->getCDR($request));
  }
}
