<?php

namespace Tests\Feature\Property\Destroy;

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

        $this->user = User::factory()->emailVerified()->create();
    }

    /** @test */
    public function successful_destroy_as_property_creator(): void
    {
        $model = call_user_func($this->model_classname.'::factory')->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)
            ->delete($this->getRoute([$model->id]));
        $response->assertStatus(302)
            ->assertRedirect(route('dashboard'));

        $this->assertNull(
            call_user_func($this->model_classname.'::where', ['id', $model->id])
                ->first()
        );
    }

    /** @test */
    public function successful_destroy_as_group_member(): void
    {
        $model = call_user_func($this->model_classname.'::factory')->create();
        $group = Group::factory()->create();
        UserGroup::factory()->invited($model->user)->accepted()->create([
            'group_id' => $group->id,
            'user_id' => $model->user_id,
        ]);
        UserGroup::factory()->invited($model->user)->accepted()->create([
            'group_id' => $group->id,
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)
            ->delete($this->getRoute([$model->id]));
        $response->assertStatus(302)
            ->assertRedirect(route('dashboard'));

        $this->assertNull(
            call_user_func($this->model_classname.'::where', ['id', $model->id])
                ->first()
        );
    }
}
