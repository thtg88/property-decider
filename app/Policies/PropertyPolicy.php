<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PropertyPolicy extends Policy
{
    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can create a comment for the model.
     *
     * @param \App\Models\User $user
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function createComment(User $user, Model $model)
    {
        return $this->isOwnerOrOwnerGroupMember($user, $model);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function delete(User $user, Model $model)
    {
        return $this->isOwnerOrOwnerGroupMember($user, $model);
    }

    /**
     * Determine whether the user can dislike the model.
     *
     * @param \App\Models\User $user
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function dislike(User $user, Model $model)
    {
        return $this->isOwnerOrOwnerGroupMember($user, $model);
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
        return $this->isOwnerOrOwnerGroupMember($user, $model);
    }

    /**
     * Determine whether the user can reprocess the model.
     *
     * @param \App\Models\User $user
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function reprocess(User $user, Model $model)
    {
        return $this->isOwnerOrOwnerGroupMember($user, $model);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function view(User $user, Model $model)
    {
        return $this->isOwnerOrOwnerGroupMember($user, $model);
    }

    protected function isOwnerOrOwnerGroupMember(
        User $user,
        Model $model
    ): bool {
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
