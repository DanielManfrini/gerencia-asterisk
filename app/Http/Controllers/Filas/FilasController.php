<?php

namespace App\Http\Controllers\Filas;

use App\Http\Controllers\Controller;
use App\Repositories\Filas\QueuesRepository;
use App\Services\Filas\QueuesService;
use Illuminate\Http\Request;

class FilasController extends Controller
{
    private $queuesService;

    public function __construct(
        QueuesService $queuesService
    ) {
        $this->queuesService = $queuesService;
    }

    /**
     * @OA\Get(
     *     path="/api/filas/get",
     *     summary="Coleta filas.",
     *     tags={"Filas"},
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/FilasGetResponse")
     *         )
     *     )
     * )
     */
    public function get(Request $request)
    {
        return $this->queuesService->get($request);
    }

    /**
     * @OA\Post(
     *     path="/api/filas/create",
     *     summary="Realiza o cadastro da fila.",
     *     tags={"Filas"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/FilasCreateRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function create(Request $request)
    {
        return $this->queuesService->create($request);
    }

    /**
     * @OA\put(
     *     path="/api/filas/edit",
     *     summary="Realiza a edição da fila.",
     *     tags={"Filas"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/FilasEditRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function edit(Request $request)
    {
        return $this->queuesService->edit($request);
    }

    /**
     * @OA\delete(
     *     path="/api/filas/delete",
     *     summary="Realiza a edição da fila.",
     *     tags={"Filas"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function delete(Request $request)
    {
        return $this->queuesService->delete($request);
    }
}
