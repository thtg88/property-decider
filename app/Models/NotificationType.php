<?php

namespace App\Models;

/**
 * @property int $id
 * @property int $description
 * @property int $title
 */
class NotificationType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'title',
    ];
}
