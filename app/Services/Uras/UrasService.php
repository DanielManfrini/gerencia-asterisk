<?php

namespace App\Services\Uras;

use App\Repositories\Uras\UrasRepository;
use Hamcrest\Arrays\IsArray;
use Illuminate\Http\Request;

class UrasService
{
  protected $urasRepository;

  public function __construct(UrasRepository $urasRepository)
  {
    $this->urasRepository = $urasRepository;
  }

  public function get(?int $exten)
  {
    $extensionsList = $this->urasRepository->get($exten);

    $extensionsListFormated = [];

    foreach ($extensionsList as $extension) {

      $exists = array_filter($extensionsListFormated, function ($formatted) use ($extension) {
        return $formatted['context'] === $extension['context'] &&
          $formatted['exten'] === $extension['exten'];
      });

      if (empty($exists)) {

        $newExtension = [
          'id' => $extension['id'],
          'context' => $extension['context'],
          'exten' => $extension['exten'],
          'steps' => []
        ];

        foreach ($extensionsList as $extensionSteps) {

          if (
            $extensionSteps['context'] ==  $extension['context'] &&
            $extensionSteps['exten'] ==  $extension['exten']
          ) {

            $newExtension['steps'][] = [
              'priority' => $extensionSteps['priority'],
              'app' => $extensionSteps['app'],
              'appdata' => $extensionSteps['appdata']
            ];
          }
        }
        $extensionsListFormated[] = $newExtension;
      }
    }
    return response()->json($extensionsListFormated);
  }

  public function create(Request $request)
  {
    try {

      $uraSteps = [];

      foreach ($request->steps as $step) {

        $uraSteps[] = [
          'context' => $request->context,
          'exten' => $request->exten,
          'priority' => $step['item'],
          'app' => $step['app'],
          'appdata' => isset($step['appdata']) ? $step['appdata'] : ''
        ];
      }

      $this->urasRepository->create($uraSteps);

      return response()->json(['success' => true, 'message' => 'Ura criada com sucesso'], 200);
    } catch (\Exception $erro) {
      return response()->json(['success' => false, 'error' => 'Erro ao criar ura', 'exception' => $erro->getMessage()], 500);
    }
  }

  public function edit(Request $request)
  {
    try {

      $dados = $request->all();

      if (is_array($dados['context'])) {
        $createContext = $dados['context']['newValue'];
        $deletecontext = $dados['context']['oldValue'];
      } else {
        $createContext = $dados['context'];
        $deletecontext = $dados['context'];
      }

      if (is_array($dados['exten'])) {
        $createExten = $dados['exten']['newValue'];
        $deleteExten = $dados['exten']['oldValue'];
      } else {
        $createExten = $dados['exten'];
        $deleteExten = $dados['exten'];
      }

      $createRequest = new Request(
        [
          'context' => $createContext,
          'exten' => $createExten,
          'steps' => $dados['steps']
        ]
      );

      $deleteRequest = new Request(
        [
          'context' => $deletecontext,
          'exten' => $deleteExten,
        ]
      );

      $this->delete($deleteRequest);

      $this->create($createRequest);

      return response()->json(['success' => true, 'message' => 'ura editada com sucesso'], 200);
    } catch (\Exception $erro) {
      return response()->json(['success' => false, 'error' => 'Erro ao editar ura', 'exception' => $erro->getMessage()], 500);
    }
  }

  public function delete(Request $request)
  {
    try {
      $this->urasRepository->delete($request);
      return response()->json(['success' => true, 'message' => 'Ura excluida com sucesso'], 200);
    } catch (\Exception $erro) {
      return response()->json(['success' => false, 'error' => 'Erro ao excluir ura', 'exception' => $erro->getMessage()], 500);
    }
  }
}
