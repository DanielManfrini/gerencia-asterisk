<?php

namespace App\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="FilasGetResponse",
 *     type="object",
 *     @OA\Property(property="name", type="string", example="ativo"),
 *     @OA\Property(property="musiconhold", type="string", example="default"),
 *     @OA\Property(property="strategy", type="string", example="leastrecent"),
 *     @OA\Property(property="retry", type="integer", example=5),
 *     @OA\Property(property="id", type="integer", example=1)
 * )
 *
 * @OA\Schema(
 *     schema="FilasCreateRequest",
 *     type="object",
 *     required={"name", "musiconhold", "retry", "strategy"},
 *     @OA\Property(property="name", type="string", example="daniel"),
 *     @OA\Property(property="musiconhold", type="string", example="default"),
 *     @OA\Property(property="retry", type="integer", example=5),
 *     @OA\Property(property="strategy", type="string", example="leastrecent"),
 * )
 *
 *  @OA\Schema(
 *     schema="FilasEditRequest",
 *     type="object",
 *     required={"id"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="daniel"),
 *     @OA\Property(property="musiconhold", type="string", example="default"),
 *     @OA\Property(property="retry", type="integer", example=5),
 *     @OA\Property(property="strategy", type="string", example="leastrecent"),
 * )
 */
class FilasSchemas
{
};
