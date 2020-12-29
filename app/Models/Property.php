<?php

namespace App\Models;

/**
 * @property int $id
 * @property string $broadband_speed
 * @property string $description
 * @property int $price
 * @property int $status_id
 * @property string $title
 * @property string $url
 * @property int $user_id
 */
class Property extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'broadband_speed',
        'description',
        'price',
        'status_id',
        'title',
        'url',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'integer',
        'status_id' => 'integer',
        'user_id' => 'integer',
    ];
}
