<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PropertyPolicy extends Policy
{
    /**
     * Determine whether the user can dislike the model.
     *
     * @param \App\Models\User $user
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function dislike(User $user, Model $model)
    {
        // If I created the property
        if ($user->id === $model->user_id) {
            return true;
        }

        // user is part of the group of the creator
        return $user->getUserGroups()
            ->whereNotNull('accepted_at')
            ->where('group_id', $model->user?->getGroup()?->id ?? 0)
            ->where('user_id', $user->id)
            ->count() > 0;
    }

    /**
     * Determine whether the user can like the model.
     *
     * @param \App\Models\User $user
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function like(User $user, Model $model)
    {
        // If I created the property
        if ($user->id === $model->user_id) {
            return true;
        }

        // user is part of the group of the creator
        return $user->getUserGroups()
            ->whereNotNull('accepted_at')
            ->where('group_id', $model->user?->getGroup()?->id ?? 0)
            ->where('user_id', $user->id)
            ->count() > 0;
    }
}
