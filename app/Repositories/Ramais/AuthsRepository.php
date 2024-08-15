<?php

namespace App\Repositories\Ramais;

use App\Models\Ramais\AuthsModel;
use Exception;
use Illuminate\Support\Facades\DB;

class AuthsRepository
{
  protected $authsModel;

  public function __construct(AuthsModel $authsModel)
  {
    $this->authsModel = $authsModel;
  }

  public function create(array $request)
  {
    try {
      $this->authsModel->id = $request['login'];
      $this->authsModel->auth_type = 'userpass';
      $this->authsModel->password = $request['password'] !== null ? $request['password'] : $request['login'];
      $this->authsModel->username = $request['login'];

      $this->authsModel->save();
    } catch (Exception $erro) {

      throw $erro;
    }
  }

  public function edit(array $request)
  {
    try {
      $authsData = $this->authsModel::where('id', $request['id'])->first();
      $authsData->password = $request['password'] !== null ? $request['password'] : $request['login'];
      $authsData->username = $request['login'];

      $authsData->save();
    } catch (Exception $erro) {

      throw $erro;
    }
  }

  public function delete(string $id)
  {
    try {

      $this->authsModel::where('id', $id)->delete();
    } catch (Exception $erro) {

      throw $erro;
    }
  }
}
