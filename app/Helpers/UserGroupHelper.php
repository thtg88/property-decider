<?php

namespace App\Helpers;

use App\Models\Group;
use App\Models\User;
use App\Models\UserGroup;
use App\Notifications\InviteUserNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class UserGroupHelper
{
    /**
     * Invite a given user, to the given inviter's current group.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $inviter
     * @return \App\Models\UserGroup
     */
    public function invite(User $user, User $inviter): UserGroup
    {
        $current_user_group = $inviter->user_groups()->first();
        if ($current_user_group === null) {
            $group = Group::create();
            $current_user_group = UserGroup::create([
                'accepted_at' => now()->toDateTimeString(),
                'group_id' => $group->id,
                'invited_at' => now()->toDateTimeString(),
                'inviter_id' => $inviter->id,
                'user_id' => $inviter->id,
            ]);
        }

        $user_group = UserGroup::firstOrCreate([
            'group_id' => $current_user_group->group_id,
            'user_id' => $user->id,
        ], [
            'invited_at' => now()->toDateTimeString(),
            'inviter_id' => $inviter->id,
        ]);

        $this->sendUserInvite($user, $user_group);

        return $user_group;
    }

    /**
     * Send an invite to a given user.
     *
     * @param \App\Models\User $user
     * @return void
     */
    protected function sendUserInvite(User $user, UserGroup $user_group): void
    {
        // create password reset token
        $token = Password::broker()->createToken($user);

        // They will then an email prompting them to reset their password
        $user->notify(new InviteUserNotification($token, $user_group));
    }
}
