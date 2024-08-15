<?php

namespace App\Http\Controllers\Ramais;

use App\Repositories\Ramais\ContextRepository;
use App\Services\Ramais\ContextService;
use Illuminate\Http\Request;

class ContextController extends RamaisController
{

    protected $contextService;
    protected $contextRepository;

    public function __construct(ContextService $contextService, ContextRepository $contextRepository)
    {
        $this->contextRepository= $contextRepository;
        $this->contextService = $contextService;
    }

    /**
     * @OA\Get(
     *     path="/api/ramais/context/get",
     *     summary="Coleta os contextos ou o contexto com base no ID.",
     *     tags={"Contexto"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ContextGetResponse")
     *     ),
     * )
     */
    public function get(Request $request)
    {
        return response()->json($this->contextRepository->get($request->id), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/ramais/context/create",
     *     summary="Cria um novo contexto no arquivo extentions.conf.",
     *     tags={"Contexto"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ContextCreateRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     * )
     */
    public function create(Request $request)
    {
        return $this->contextService->create($request);
    }

    /**
     * @OA\put(
     *     path="/api/ramais/context/edit",
     *     summary="Edita o contexto.",
     *     tags={"Contexto"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ContextEditRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     * )
     */
    public function edit(Request $request)
    {
        return $this->contextService->edit($request);
    }

    /**
     * @OA\delete(
     *     path="/api/ramais/context/edit",
     *     summary="Remove o contexto no arquivo extentions.conf.",
     *     tags={"Contexto"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="ContextId", type="integer", example="1"),
     *             @OA\Property(property="name", type="string", example="contexto-teste"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     * )
     */
    public function delete(Request $request)
    {
        return $this->contextService->delete($request);
    }
}
