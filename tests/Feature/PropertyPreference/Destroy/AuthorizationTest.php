<?php

namespace Tests\Feature\PropertyPreference\Destroy;

use App\Models\User;
use Tests\Feature\PropertyPreference\WithModelData;
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

        $this->user = User::factory()->create();
    }

    /** @test */
    public function not_owned_model_authorization_errors(): void
    {
        $model = call_user_func($this->model_classname.'::factory')->create();

        $response = $this->actingAs($this->user)
            ->delete($this->getRoute([$model->id]));
        $response->assertStatus(403);
    }
}
