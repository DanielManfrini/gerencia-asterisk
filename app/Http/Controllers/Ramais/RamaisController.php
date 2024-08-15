<?php

namespace App\Http\Controllers\Ramais;

use App\Http\Controllers\Controller;
use App\Models\Ramais\ViewRamaisModel;
use App\Repositories\Ramais\ViewRamaisRepository;
use App\Services\Ramais\RamaisService;
use Illuminate\Http\Request;

/**
 * Classe relacionada aos ramais, que compoe 3 objetos separados.
 * - Aors
 * - Auths
 * - Endpoints
 */
class RamaisController extends Controller
{

    protected $ramaisService;
    protected $viewRamaisRepository;

    public function __construct(
        ViewRamaisRepository $viewRamaisRepository,
        RamaisService $ramaisService
    ) {
        $this->viewRamaisRepository = $viewRamaisRepository;
        $this->ramaisService = $ramaisService;
    }

    /**
     * @OA\Get(
     *     path="/api/ramais/get",
     *     summary="Coleta os ramais ou o ramal com base no ID.",
     *     tags={"Ramais"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/RamalGetResponse")
     *     ),
     * )
     */
    public function get(Request $request)
    {
        return response()->json($this->viewRamaisRepository->get($request->id), 200);
    }


    /**
     * @OA\Post(
     *     path="/api/ramais/create",
     *     summary="Realiza o cadastro do ramal com base na matrícula e senha do usuário.",
     *     tags={"Ramais"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RamalCreateRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     * )
     */
    public function create(Request $request)
    {
        return $this->ramaisService->create($request);
    }

    /**
     * @OA\put(
     *     path="/api/ramais/edit",
     *     summary="Realiza a edição do ramal com base na matrícula do usuário.",
     *     tags={"Ramais"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RamalEditRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     * )
     */
    public function edit(Request $request)
    {
        return $this->ramaisService->edit($request);
    }


    /**
     * @OA\delete(
     *     path="/api/ramais/edit",
     *     summary="Deleta o ramal com base no ID.",
     *     tags={"Ramais"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example="125104"),
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
        return $this->ramaisService->delete($request);
    }
}
