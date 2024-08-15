<?php

namespace App\Repositories\Ramais;

use App\Models\Ramais\ContextModel;
use Exception;
use Illuminate\Support\Facades\DB;

class ContextRepository
{
  protected $contextModel;

  public function __construct(ContextModel $contextModel)
  {
    $this->contextModel = $contextModel;
  }

  public function get($id)
  {

    $contextData = $this->contextModel->select($id);

    if ($id) {

      $contextData = $this->contextModel->where('contextID', $id);
    }

    $contextData = $this->contextModel->get()->toArray();

    return $contextData;
  }

  public function create(array $request)
  {
    DB::beginTransaction();

    try {
      $this->contextModel->insert($request);

      DB::commit();
    } catch (Exception $erro) {

      DB::rollBack();

      throw $erro;
    }
  }

  public function edit(array $request)
  {
    try {
      $contextData = $this->contextModel::where('ContextId', $request['ContextId'])->first();

      $contextData->name = $request['name'];

      $contextData->save();
    } catch (Exception $erro) {

      throw $erro;
    }
  }

  public function delete(string $id)
  {
    try {

      $this->contextModel::where('ContextId', $id)->delete();
    } catch (Exception $erro) {

      throw $erro;
    }
  }
}
