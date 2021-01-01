<?php

namespace Tests\Feature\Property\Destroy;

use App\Models\User;
use Tests\Feature\Property\WithModelData;
use Tests\Feature\TestCase;

class NotFoundTest extends TestCase
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
    public function random_string_id_not_found_errors(): void
    {
        $response = $this->actingAs($this->user)
            ->delete($this->getRoute(['ABCD']));
        $response->assertStatus(404);
    }

    /** @test */
    public function random_number_id_not_found_errors(): void
    {
        $response = $this->actingAs($this->user)
            ->delete($this->getRoute([1234]));
        $response->assertStatus(404);
    }

    /** @test */
    public function deleted_model_not_found_errors(): void
    {
        $model = call_user_func($this->model_classname.'::factory')->create();

        $model->delete();

        $response = $this->actingAs($this->user)
            ->delete($this->getRoute([$model->id]));
        $response->assertStatus(404);
    }
}
