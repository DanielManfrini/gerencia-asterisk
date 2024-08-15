<?php

namespace App\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UrasGetResponse",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example="2"),
 *     @OA\Property(property="context", type="string", example="ura"),
 *     @OA\Property(property="exten", type="any", example="3000,switch-2"),
 *     @OA\Property(property="priority", type="integer", example=5),
 *     @OA\Property(property="app", type="string", example=1),
 *     @OA\Property(property="appdata", type="string", example=1)
 * )
 *
 * @OA\Schema(
 *     schema="UrasCreateRequest",
 *     type="object",
 *     required={"context", "exten", "priority", "app", "appdata"},
 *     @OA\Property(property="context", type="string", example="ura"),
 *     @OA\Property(property="exten", type="any", example="3000,switch-2"),
 *     @OA\Property(property="priority", type="integer", example=5),
 *     @OA\Property(property="app", type="string", example=1),
 *     @OA\Property(property="appdata", type="string", example=1)
 * )
 *
 *  @OA\Schema(
 *     schema="UrasEditRequest",
 *     type="object",
 *     required={"id"},
 *     @OA\Property(property="id", type="integer", example="2"),
 *     @OA\Property(property="context", type="string", example="ura"),
 *     @OA\Property(property="exten", type="any", example="3000,switch-2"),
 *     @OA\Property(property="priority", type="integer", example=5),
 *     @OA\Property(property="app", type="string", example=1),
 *     @OA\Property(property="appdata", type="string", example=1)
 * )
 */
class UrasSchemas
{
};
