<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="CountryResource",
 *     @OA\Property(property="id", type="integer", example="40"),
 *     @OA\Property(property="name", type="string", example="Name Example"),
 *     @OA\Property(property="iso_code", type="string", example="Iso_code Example"),
 *     @OA\Property(property="phone_code", type="string", example="Phone_code Example"),
 *     @OA\Property(property="currency", type="string", example="Currency Example"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-06 07:18:18"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-04-06 07:18:18")
 * )
 */

class CountryResource extends JsonResource
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
			'name' => $this->name,
			'iso_code' => $this->iso_code,
			'phone_code' => $this->phone_code,
			'currency' => $this->currency,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at
        ];
    }
}
