<?php

namespace Tests\Feature\Property\Like;

use App\Models\Group;
use App\Models\User;
use App\Models\UserGroup;
use Tests\Feature\Property\WithModelData;
use Tests\Feature\TestCase;

class AuthorizationTest extends TestCase
{
    use WithRoute;
    use WithModelData;

    /** @var \App\Models\User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->emailVerified()->create();
    }

    /** @test */
    public function not_owned_model_authorization_errors(): void
    {
        $model = call_user_func($this->model_classname.'::factory')->create();

        $response = $this->actingAs($this->user)
            ->post($this->getRoute([$model->id]));
        $response->assertStatus(403);
    }

    /** @test */
    public function not_accepted_group_member_invitation_authorization_errors(): void
    {
        $model = call_user_func($this->model_classname.'::factory')->create();
        $group = Group::factory()->create();
        $owner_group = UserGroup::factory()->invited($model->user)->accepted()
            ->create([
                'group_id' => $group->id,
                'user_id' => $model->user_id,
            ]);
        $user_group = UserGroup::factory()->invited($model->user)->create([
            'group_id' => $group->id,
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)
            ->post($this->getRoute([$model->id]));
        $response->assertStatus(403);
    }

    /** @test */
    public function not_invited_group_member_invitation_authorization_errors(): void
    {
        $model = call_user_func($this->model_classname.'::factory')->create();
        $group = Group::factory()->create();
        $owner_group = UserGroup::factory()->invited($model->user)->accepted()
            ->create([
                'group_id' => $group->id,
                'user_id' => $model->user_id,
            ]);
        $user_group = UserGroup::factory()->create([
            'group_id' => $group->id,
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)
            ->post($this->getRoute([$model->id]));
        $response->assertStatus(403);
    }
}
