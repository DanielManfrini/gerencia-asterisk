<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Services\Adm\AsteriskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AsteriskController extends Controller
{

  protected $asteriskService;

  public function __construct(
    AsteriskService $asteriskService
  ) {
    $this->asteriskService = $asteriskService;
  }

  public function pjsipReload() : void
  {
    $this->asteriskService->pjsipReload();
  }

  public function getCDR(Request $request) : JsonResponse {
    return $this->asteriskService->getCDR($request);
  }
}
