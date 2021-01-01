<?php

namespace Tests\Feature\Property\Destroy;

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

        $this->user = User::factory()->emailVerified()->createOne();
    }

    /** @test */
    public function not_owned_model_authorization_errors(): void
    {
        $model = call_user_func($this->model_classname.'::factory')->createOne();

        $response = $this->actingAs($this->user)
            ->delete($this->getRoute([$model->id]));
        $response->assertStatus(403);
    }

    /** @test */
    public function not_accepted_group_member_invitation_authorization_errors(): void
    {
        $model = call_user_func($this->model_classname.'::factory')->createOne();
        $group = Group::factory()->createOne();
        UserGroup::factory()->invited($model->user)->accepted()->createOne([
            'group_id' => $group->id,
            'user_id' => $model->user_id,
        ]);
        UserGroup::factory()->invited($model->user)->createOne([
            'group_id' => $group->id,
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)
            ->delete($this->getRoute([$model->id]));
        $response->assertStatus(403);
    }

    /** @test */
    public function not_invited_group_member_invitation_authorization_errors(): void
    {
        $model = call_user_func($this->model_classname.'::factory')->createOne();
        $group = Group::factory()->createOne();
        UserGroup::factory()->invited($model->user)->accepted()->createOne([
            'group_id' => $group->id,
            'user_id' => $model->user_id,
        ]);
        UserGroup::factory()->createOne([
            'group_id' => $group->id,
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)
            ->delete($this->getRoute([$model->id]));
        $response->assertStatus(403);
    }
}
