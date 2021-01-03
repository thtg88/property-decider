<?php

namespace App\Policies;

use App\Models\User;

class UserGroupPolicy extends Policy
{
    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return true;
    }
}
