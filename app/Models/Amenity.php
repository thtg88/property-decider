<?php

namespace App\Models;

/**
 * @property int $id
 * @property string $name
 */
class Amenity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}
