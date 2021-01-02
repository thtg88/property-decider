<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function getLikes(): Collection
    {
        return $this->property_preferences->where('is_liked', true);
    }

    public function getDislikes(): Collection
    {
        return $this->property_preferences->where('is_liked', false);
    }

    // RELATIONSHIPS

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function property_amenities(): HasMany
    {
        return $this->hasMany(PropertyAmenity::class);
    }

    public function property_preferences(): HasMany
    {
        return $this->hasMany(PropertyPreference::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
