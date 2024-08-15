<?php

namespace App\Repositories\Filas;

use App\Models\Filas\QueueRulesModel;
use Exception;
use Illuminate\Support\Facades\DB;

class QueueRulesRepository
{

  protected $queueRulesModel;

  public function __construct(
    QueueRulesModel $queueRulesModel
  ) {
    $this->queueRulesModel = $queueRulesModel;
  }

  public function get(?string $rule_name)
  {

    $rulesData = $this->queueRulesModel->select();

    if ($rule_name) {
      $rulesData = $rulesData->where('rule_name', $rule_name);
    }

    return $rulesData->get()->toArray();
  }

  public function create(array $data)
  {
    DB::beginTransaction();

    try {
      $this->queueRulesModel->insert($data);

      DB::commit();
    } catch (Exception $erro) {

      DB::rollBack();

      throw $erro;
    }
  }

  public function edit(array $data)
  {
    DB::beginTransaction();

    try {
      $queueRulesModel = $this->queueRulesModel::where('id', $data['id']);

      $queueRulesModel->name = $data['rule_name'];
      $queueRulesModel->musiconhold = $data['time'];
      $queueRulesModel->retry = $data['min_penalty'];
      $queueRulesModel->strategy = $data['max_penalty'];

      $queueRulesModel->save();

      DB::commit();
    } catch (Exception $erro) {

      DB::rollBack();

      throw $erro;
    }
  }

  public function delete(array $data)
  {
    try {

      $this->queueRulesModel::where('rule_name', $data['rule_name'])->delete();
    } catch (Exception $erro) {

      throw $erro;
    }
  }
}
