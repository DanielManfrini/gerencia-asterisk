<?php

namespace App\Repositories\Ramais;

use App\Models\Ramais\EndpointsModel;
use Exception;

class EndpointsRepository
{
  protected $endpointsModel;

  public function __construct(EndpointsModel $endpointsModel)
  {
    $this->endpointsModel = $endpointsModel;
  }

  public function create(array $request)
  {
    try {

      $this->endpointsModel->id = $request['login'];
      $this->endpointsModel->transport = $request['transport'];
      $this->endpointsModel->aors = $request['login'];
      $this->endpointsModel->auth = $request['login'];
      $this->endpointsModel->context = $request['context'];
      $this->endpointsModel->disallow = 'all';
      $this->endpointsModel->allow = $request['allow'];

      if ($request['transport'] === 'transport-wss') {
        $this->endpointsModel->webrtc = 'yes';
        $this->endpointsModel->dtls_auto_generate_cert = 'yes';
      }

      $this->endpointsModel->save();
    } catch (Exception $erro) {

      throw $erro;
    }
  }

  public function edit(array $request)
  {
    try {
      $endpointsData = $this->endpointsModel::where('id', $request['id'])->first();

      $endpointsData->transport = $request['transport'];
      $endpointsData->context = $request['context'];
      $endpointsData->allow = $request['allow'];

      $endpointsData->save();
    } catch (Exception $erro) {

      throw $erro;
    }
  }

  public function delete(string $id)
  {
    try {

      $this->endpointsModel::where('id', $id)->delete();
    } catch (Exception $erro) {

      throw $erro;
    }
  }
}
