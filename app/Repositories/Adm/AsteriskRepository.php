<?php

namespace App\Repositories\Adm;

use App\Models\Adm\CdrModel;

class AsteriskRepository
{

  protected $cdrModel;

  public function __construct(CdrModel $cdrModel)
  {
    $this->cdrModel = $cdrModel;
  }

  public function getCDR(object $request): array
  {
    return $this->cdrModel::where('sequence' > $request->sequence)->get()->toArray();
  }
}
