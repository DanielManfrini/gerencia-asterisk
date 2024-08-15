<?php

namespace App\Http\Controllers\Filas;

use App\Http\Controllers\Controller;
use App\Repositories\Filas\QueueRulesRepository;
use App\Services\Filas\QueueRulesService;
use Illuminate\Http\Request;

class RegrasController extends Controller
{
  protected $queueRulesService;
  protected $queueRulesRepository;

  public function __construct(
    QueueRulesService $queueRulesService,
    QueueRulesRepository $queueRulesRepository
  ) {
    $this->queueRulesService = $queueRulesService;
    $this->queueRulesRepository = $queueRulesRepository;
  }

  public function get(Request $request)
  {
    return response()->json($this->queueRulesRepository->get($request->rule_name));
  }

  public function create(Request $request)
  {
    return $this->queueRulesService->create($request);
  }

  public function save(Request $request)
  {
    return $this->queueRulesService->save($request);
  }

  public function delete(Request $request)
  {
    return $this->queueRulesService->delete($request);
  }
}
