<?php

namespace Tests\Feature\PropertyPreference\Destroy;

use App\Models\User;
use Tests\Feature\PropertyPreference\WithModelData;
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

        $this->user = User::factory()->create();
    }

    /** @test */
    public function successful_destroy(): void
    {
        $model = call_user_func($this->model_classname.'::factory')->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)
            ->delete($this->getRoute([$model->id]));
        $response->assertStatus(302);
        $this->assertNull(
            call_user_func($this->model_classname.'::where', ['id', $model->id])
                ->first()
        );
    }
}
