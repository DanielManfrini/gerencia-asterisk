<?php

namespace App\Repositories\Filas;

use App\Models\Filas\QueuesModel;
use Exception;
use Illuminate\Support\Facades\DB;

class QueuesRepository
{
  protected $queuesModel;

  public function __construct(QueuesModel $queuesModel)
  {
    $this->queuesModel = $queuesModel;
  }

  public function get(?object $request)
  {
    return $this->queuesModel->get()->toArray();

    $queuesList = $this->queuesModel->select();

    if (isset($request->id)) {
      $queuesList = $queuesList->where('id', $request->id);
    }

    $queuesList = $queuesList->get()
      ->toArray();

    return $queuesList;
  }

  public function create(array $data)
  {
    DB::beginTransaction();

    try {
      $this->queuesModel->insert($data);

      DB::commit();
    } catch (Exception $erro) {

      DB::rollBack();

      throw $erro;
    }
  }

  public function edit(array $request)
  {
    DB::beginTransaction();

    try {
      $queueModel = $this->queuesModel::where('id', $request['id'])->first();

      $queueModel->name = $request['name'];
      $queueModel->musiconhold = $request['musiconhold'];
      $queueModel->retry = $request['retry'];
      $queueModel->strategy = $request['strategy'];
      $queueModel->defaultrule = $request['defaultrule'];

      $queueModel->save();

      DB::commit();
    } catch (Exception $erro) {

      DB::rollBack();

      throw $erro;
    }
  }

  public function delete(array $request)
  {
    try {

      $this->queuesModel::where('id', $request['id'])->delete();
    } catch (Exception $erro) {

      throw $erro;
    }
  }
}
