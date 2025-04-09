<?php

namespace App\Models;

use Sawmainek\Apitoolz\Traits\QueryFilterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;

class Country extends Model
{
    use SoftDeletes;
    use QueryFilterTrait;
    use Searchable;
    use Notifiable;

    protected $table = "countries";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'iso_code', 'phone_code', 'currency', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $searchable = [
        'id', 'name', 'iso_code', 'phone_code', 'currency', 'created_at', 'updated_at'
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
            'id' => 'integer', 'name' => 'string', 'iso_code' => 'string', 'phone_code' => 'string', 'currency' => 'string', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'deleted_at' => 'datetime'
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
            'name' => $this->name,
			'iso_code' => $this->iso_code,
			'phone_code' => $this->phone_code,
			'currency' => $this->currency,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at
        ];
    }

    

}
