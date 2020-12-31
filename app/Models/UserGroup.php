<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $group_id
 */
class UserGroup extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'accepted_at',
        'group_id',
        'invited_at',
        'inviter_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'accepted_at' => 'datetime',
        'group_id' => 'integer',
        'invited_at' => 'datetime',
        'inviter_id' => 'integer',
        'user_id' => 'integer',
    ];

    // RELATIONSHIP

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
