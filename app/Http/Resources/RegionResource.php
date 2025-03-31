<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="RegionResource",
 *     @OA\Property(property="id", type="integer", example="62"),
 *     @OA\Property(property="name_en", type="string", example="Name_en Example"),
 *     @OA\Property(property="name_mm", type="string", example="Name_mm Example"),
 *     @OA\Property(property="code", type="string", example="Code Example"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-31 09:12:31"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-31 09:12:31")
 * )
 */

class RegionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
			'name_en' => $this->name_en,
			'name_mm' => $this->name_mm,
			'code' => $this->code,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at
        ];
    }
}
