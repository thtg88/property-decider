<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    // RELATIONSHIPS

    public function amenity(): BelongsTo
    {
        return $this->belongsTo(Amenity::class);
    }
}
