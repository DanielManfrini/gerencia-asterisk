<?php

namespace App\Repositories\Ramais;

use App\Models\Ramais\ViewRamaisModel;

class ViewRamaisRepository
{

  protected $viewRamaisModel;

  public function __construct(ViewRamaisModel $viewRamaisModel)
  {
    $this->viewRamaisModel = $viewRamaisModel;
  }

  public function get(?string $id)
  {

    $ViewRamais = $this->viewRamaisModel::select();

    if ($id) {
      $ViewRamais = $ViewRamais->where('id', $id);
    }

    $ViewRamaisList = $ViewRamais->get()->toArray();

    return $ViewRamaisList;
  }
}
