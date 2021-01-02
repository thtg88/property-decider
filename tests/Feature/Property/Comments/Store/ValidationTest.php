<?php

namespace Tests\Feature\Property\Comments\Store;

use App\Models\User;
use Illuminate\Support\Str;
use Tests\Feature\Property\WithModelData;
use Tests\Feature\TestCase;

class ValidationTest extends TestCase
{
    use WithRoute;
    use WithModelData;

    /** @var \App\Models\Property */
    protected $model;

    /** @var \App\Models\User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->emailVerified()->createOne();
        $this->model = call_user_func($this->model_classname.'::factory')
            ->createOne(['user_id' => $this->user->id]);
    }

    /** @test */
    public function content_required_validation_errors(): void
    {
        $response = $this->actingAs($this->user)
            ->post($this->getRoute([$this->model->id]));
        $response->assertStatus(302)
            ->assertSessionHasErrors([
                'content' => 'The content field is required.',
            ]);
    }

    /** @test */
    public function content_string_validation_errors(): void
    {
        $response = $this->actingAs($this->user)
            ->post($this->getRoute([$this->model->id]), [
                'content' => ['ABCD'],
            ]);
        $response->assertStatus(302)
            ->assertSessionHasErrors([
                'content' => 'The content must be a string.',
            ]);
    }

    /** @test */
    public function content_max_validation_errors(): void
    {
        $content = $this->faker->text;

        $response = $this->actingAs($this->user)
            ->post($this->getRoute([$this->model->id]), [
                'content' => Str::padRight($content, 65536, 'A'),
            ]);
        $response->assertStatus(302)
            ->assertSessionHasErrors([
                'content' => 'The content may not be greater than 65535 characters.',
            ]);
    }
}
