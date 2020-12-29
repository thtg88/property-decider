<?php

namespace App\Models;

class PropertyAmenity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amenity_id',
        'property_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'amenity_id' => 'integer',
        'property_id' => 'integer',
    ];
}
