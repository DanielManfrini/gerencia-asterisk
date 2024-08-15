<?php

namespace App\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ContextGetResponse",
 *     type="object",
 *     @OA\Property(property="ContextId", type="integer", example="1"),
 *     @OA\Property(property="name", type="string", example="contexto-teste"),
 * )
 *
 * @OA\Schema(
 *     schema="ContextCreateRequest",
 *     type="object",
 *     required={"ContextId", "name"},
 *     @OA\Property(property="ContextId", type="integer", example="1"),
 *     @OA\Property(property="name", type="string", example="contexto-teste"),
 * )
 *
 *  @OA\Schema(
 *     schema="ContextEditRequest",
 *     type="object",
 *     required={"ContextId", "name"},
 *     @OA\Property(property="ContextId", type="integer", example="1"),
 *     @OA\Property(property="name", type="string", example="contexto-teste"),
 * )
 */
class ContextSchemas
{ /* .... */
};
