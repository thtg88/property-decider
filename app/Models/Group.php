<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    // RELATIONSHIPS

    public function user_groups(): HasMany
    {
        return $this->hasMany(UserGroup::class, 'group_id', 'id');
    }
}
