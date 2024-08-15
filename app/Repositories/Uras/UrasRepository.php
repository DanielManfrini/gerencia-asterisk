<?php

namespace App\Repositories\Uras;

use App\Models\Uras\ExtensionsModel;
use Exception;

class UrasRepository
{
  protected $extensionsModel;

  public function __construct(ExtensionsModel $extensionsModel)
  {
    $this->extensionsModel = $extensionsModel;
  }

  public function get($exten)
  {
    $extensionsList = $this->extensionsModel->select();

    if ($exten) {
      $extensionsList = $extensionsList->where('exten', $exten);
    }

    $extensionsList = $extensionsList->orderBy(
      'context',
      'asc',
      'exten',
      'asc',
      'priority',
      'asc'
    )->get()
      ->toArray();

    return $extensionsList;
  }

  public function create(array $request)
  {
    try {

      $this->extensionsModel->insert($request);
    } catch (Exception $erro) {

      throw $erro;
    }
  }

  /**
   * Realiza a edição da ura por id.
   * @author Daniel Lopes manfrini
   * @deprecated
   */
  public function edit(array $request)
  {
    try {
      $extensionsData = $this->extensionsModel::where('id', $request['id'])->first();

      $extensionsData->context = $request['context'];
      $extensionsData->exten = $request['exten'];
      $extensionsData->priority = $request['priority'];
      $extensionsData->app = $request['app'];
      $extensionsData->appdata = $request['appdata'];

      $extensionsData->save();
    } catch (Exception $erro) {

      throw $erro;
    }
  }

  public function delete($request)
  {
    try {
      if (isset($request->id)) {
        $this->extensionsModel::where('id', $request->id)->delete();
      } else if (isset($request->context) && isset($request->exten)) {
        $this->extensionsModel::where('context', $request->context)
          ->where('exten', $request->exten)
          ->delete();
      } else {
        throw new \Exception('Uso incorreto, use "$request->id" para exclusão por id ou "$request->context && $request->exten" para exclusão de toda a ura');
      }
    } catch (Exception $erro) {
      throw $erro;
    }
  }
}
