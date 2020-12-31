<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PropertyPreferencePolicy extends Policy
{
    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function delete(User $user, Model $model)
    {
        // If I've added the preference
        return $user->id === $model->user_id;
    }
}
