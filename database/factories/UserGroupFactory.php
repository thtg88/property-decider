<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'group_id' => Group::factory(),
            'user_id' => User::factory(),
        ];
    }

    public function accepted(): self
    {
        return $this->state([
            'accepted_at' => now()->toDateTimeString(),
        ]);
    }

    public function invited(?User $inviter = null): self
    {
        return $this->state([
            'invited_at' => now()->toDateTimeString(),
            'inviter_id' => $inviter ?? User::factory(),
        ]);
    }
}
