<?php

namespace App\Http\Controllers\Uras;

use App\Http\Controllers\Controller;
use App\Repositories\Uras\UrasRepository;
use App\Services\Uras\UrasService;
use Illuminate\Http\Request;

class UrasController extends Controller{

    private $urasService;

    public function __construct(
        UrasService $urasService
    ) {
        $this->urasService = $urasService;
    }

    /**
     * @OA\Get(
     *     path="/api/uras/get",
     *     summary="Coleta as uras.",
     *     tags={"Uras"},
     *     @OA\Parameter(
     *         name="exten",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/UrasGetResponse")
     *         )
     *     )
     * )
     */
    public function get(Request $request)
    {
        return $this->urasService->get($request->exten);
    }

    /**
     * @OA\Post(
     *     path="/api/uras/create",
     *     summary="Realiza o cadastro da ura.",
     *     tags={"Uras"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UrasCreateRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function create(Request $request)
    {
        return $this->urasService->create($request);
    }

    /**
     * @OA\put(
     *     path="/api/uras/edit",
     *     summary="Realiza a edição da ura.",
     *     tags={"Uras"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UrasEditRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function edit(Request $request)
    {
        return $this->urasService->edit($request);
    }

    /**
     * @OA\delete(
     *     path="/api/uras/delete",
     *     summary="Realiza a exclusao da ura.",
     *     tags={"Uras"},
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
        return $this->urasService->delete($request);
    }

}
