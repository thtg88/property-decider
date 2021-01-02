<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $property_id
 * @property int $user_id
 */
class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content',
        'property_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'property_id' => 'integer',
        'user_id' => 'integer',
    ];

    // RELATIONSHIPS

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
