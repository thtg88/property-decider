<?php

namespace Tests\Feature\Property\Show;

use App\Models\Group;
use App\Models\PropertyPreference;
use App\Models\User;
use App\Models\UserGroup;
use Tests\Feature\Property\WithModelData;
use Tests\Feature\TestCase;

class SuccessfulTest extends TestCase
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
    public function successful_show_as_property_creator(): void
    {
        $model = call_user_func($this->model_classname.'::factory')->createOne([
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get($this->getRoute([$model->id]));
        $response->assertStatus(200)
            ->assertViewIs('properties.show.main');
    }

    /** @test */
    public function successful_show_as_group_member(): void
    {
        $model = call_user_func($this->model_classname.'::factory')->createOne();
        $group = Group::factory()->createOne();
        UserGroup::factory()->invited($model->user)->accepted()->createOne([
            'group_id' => $group->id,
            'user_id' => $model->user_id,
        ]);
        UserGroup::factory()->invited($model->user)->accepted()->createOne([
            'group_id' => $group->id,
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get($this->getRoute([$model->id]));
        $response->assertStatus(200)
            ->assertViewIs('properties.show.main');
    }
}
