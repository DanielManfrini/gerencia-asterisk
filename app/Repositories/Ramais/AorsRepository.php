<?php

namespace App\Repositories\Ramais;

use App\Models\Ramais\AorsModel;
use Exception;

class AorsRepository
{
  protected $aorsModel;

  public function __construct(AorsModel $aorsModel)
  {
    $this->aorsModel = $aorsModel;
  }

  public function create(array $request)
  {
    try {

      $this->aorsModel->id = $request['login'];
      $this->aorsModel->max_contacts = $request['max_contacts'];
      $this->aorsModel->remove_existing = 'yes';

      $this->aorsModel->save();
    } catch (Exception $erro) {

      throw $erro;
    }
  }

  public function edit(array $request)
  {
    try {
      $aorsData = $this->aorsModel::where('id', $request['id'])->first();

      $aorsData->max_contacts = $request['max_contacts'];

      $aorsData->save();
    } catch (Exception $erro) {

      throw $erro;
    }
  }

  public function delete(string $id)
  {
    try {

      $this->aorsModel::where('id', $id)->delete();
    } catch (Exception $erro) {

      throw $erro;
    }
  }
}
