<?php

namespace App\Models;

use Sawmainek\Apitoolz\Traits\QueryFilterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;

class Incident extends Model
{
    use SoftDeletes;
    use QueryFilterTrait;
    use Searchable;
    use Notifiable;

    protected $table = "incidents";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'title', 'name', 'photo', 'post_by_name', 'post_by_phone', 'post_by_email', 'related_to', 'condition', 'description', 'address', 'city_id', 'township_id', 'country_id', 'latitude', 'longitude', 'status', 'severity', 'created_at', 'updated_at', 'other_condition', 'type'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $searchable = [
        'id', 'title', 'name', 'photo', 'post_by_name', 'post_by_phone', 'post_by_email', 'related_to', 'condition', 'description', 'address', 'city_id', 'township_id', 'country_id', 'latitude', 'longitude', 'status', 'severity', 'created_at', 'updated_at', 'other_condition', 'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer', 'title' => 'string', 'name' => 'string', 'photo' => 'object', 'post_by_name' => 'string', 'post_by_phone' => 'string', 'post_by_email' => 'string', 'related_to' => 'string', 'condition' => 'string', 'description' => 'string', 'address' => 'string', 'city_id' => 'integer', 'township_id' => 'integer', 'country_id' => 'integer', 'latitude' => 'float', 'longitude' => 'float', 'status' => 'string', 'severity' => 'string', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'deleted_at' => 'datetime', 'other_condition' => 'string', 'type' => 'string'
        ];
    }

    /**
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return array|string
     */
    public function routeNotificationForMail($notification)
    {
        return [
            
        ];
    }

    /**
    * Get the indexable data array for the model.
    *
    * @return array<string, mixed>
    */
    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
			'name' => $this->name,
			'photo' => is_object($this->photo) ? json_encode($this->photo) : $this->photo,
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
			'type' => $this->type
        ];
    }

    
    /**
     * Get the township that owns the .
     */
    public function township()
    {
        return $this->belongsTo('App\Models\City','township_id');
    }
    
    /**
     * Get the city that owns the .
     */
    public function city()
    {
        return $this->belongsTo('App\Models\Region','city_id');
    }
    

}
