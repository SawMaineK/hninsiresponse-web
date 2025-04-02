<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="IncidentResource",
 *     @OA\Property(property="id", type="integer", example="22"),
 *     @OA\Property(property="title", type="string", example="Title Example"),
 *     @OA\Property(property="name", type="string", example="Name Example"),
 *     @OA\Property(property="photo", type="string", example="Photo Example"),
 *     @OA\Property(property="post_by_name", type="string", example="Post_by_name Example"),
 *     @OA\Property(property="post_by_phone", type="string", example="Post_by_phone Example"),
 *     @OA\Property(property="post_by_email", type="string", example="Post_by_email Example"),
 *     @OA\Property(property="related_to", type="string", example="Related_to Example"),
 *     @OA\Property(property="condition", type="string", example="Condition Example"),
 *     @OA\Property(property="description", type="string", example="Description Example"),
 *     @OA\Property(property="address", type="string", example="Address Example"),
 *     @OA\Property(property="city_id", type="integer", example="6"),
 *     @OA\Property(property="township_id", type="string", example="Township_id Example"),
 *     @OA\Property(property="country_id", type="integer", example="83"),
 *     @OA\Property(property="latitude", type="string", example="Latitude Example"),
 *     @OA\Property(property="longitude", type="string", example="Longitude Example"),
 *     @OA\Property(property="status", type="string", example="Status Example"),
 *     @OA\Property(property="severity", type="string", example="Severity Example"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-02 10:52:00"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-04-02 10:52:00"),
 *     @OA\Property(property="other_condition", type="string", example="Other_condition Example"),
 *     @OA\Property(property="type", type="string", example="Type Example")
 * )
 */

class IncidentResource extends JsonResource
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
			'title' => $this->title,
			'name' => $this->name,
			'photo' => $this->photo,
			'post_by_name' => $this->post_by_name,
			'post_by_phone' => $this->post_by_phone,
			'post_by_email' => $this->post_by_email,
			'related_to' => $this->related_to,
			'condition' => $this->condition,
			'description' => $this->description,
			'address' => $this->address,
			'city_id' => $this->city_id,
			'township_id' => $this->township_id,
			'country_id' => $this->country_id,
			'latitude' => $this->latitude,
			'longitude' => $this->longitude,
			'status' => $this->status,
			'severity' => $this->severity,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
			'other_condition' => $this->other_condition,
			'type' => $this->type,
			'township' => new CityResource($this->township),
			'city' => new RegionResource($this->city)
        ];
    }
}
