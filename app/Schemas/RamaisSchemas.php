<?php

namespace App\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="RamalGetResponse",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="login", type="string", example="user123"),
 *     @OA\Property(property="max_contacts", type="integer", example=5),
 *     @OA\Property(property="transport", type="string", example="UDP"),
 *     @OA\Property(property="allow", type="string", example="all"),
 *     @OA\Property(property="context", type="string", example="default")
 * )
 *
 * @OA\Schema(
 *     schema="RamalCreateRequest",
 *     type="object",
 *     required={"login", "senha"},
 *     @OA\Property(property="login", type="string", example="user123"),
 *     @OA\Property(property="senha", type="string", example="password123"),
 *     @OA\Property(property="max_contacts", type="integer", example=5),
 *     @OA\Property(property="transport", type="string", example="UDP"),
 *     @OA\Property(property="allow", type="string", example="all"),
 *     @OA\Property(property="context", type="string", example="default")
 * )
 *
 *  @OA\Schema(
 *     schema="RamalEditRequest",
 *     type="object",
 *     required={"id"},
 *     @OA\Property(property="id", type="integer", example="125104"),
 *     @OA\Property(property="login", type="string", example="user123"),
 *     @OA\Property(property="senha", type="string", example="password123"),
 *     @OA\Property(property="max_contacts", type="integer", example=5),
 *     @OA\Property(property="transport", type="string", example="UDP"),
 *     @OA\Property(property="allow", type="string", example="all"),
 *     @OA\Property(property="context", type="string", example="default")
 * )
 */
class RamaisSchemas
{ /* .... */
};
