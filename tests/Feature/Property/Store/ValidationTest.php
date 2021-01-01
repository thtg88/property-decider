<?php

namespace Tests\Feature\Property\Store;

use App\Models\User;
use Illuminate\Support\Str;
use Tests\Feature\Property\WithModelData;
use Tests\Feature\TestCase;

class ValidationTest extends TestCase
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
    public function url_required_validation_errors(): void
    {
        $response = $this->actingAs($this->user)->post($this->getRoute());
        $response->assertStatus(302)
            ->assertSessionHasErrors([
                'url' => 'The url field is required.',
            ]);
    }

    /** @test */
    public function url_string_validation_errors(): void
    {
        $response = $this->actingAs($this->user)->post($this->getRoute(), [
            'url' => ['ABCD'],
        ]);
        $response->assertStatus(302)
            ->assertSessionHasErrors([
                'url' => 'The url must be a string.',
            ]);
    }

    /** @test */
    public function url_url_validation_errors(): void
    {
        $response = $this->actingAs($this->user)->post($this->getRoute(), [
            'url' => 'ABCD',
        ]);
        $response->assertStatus(302)
            ->assertSessionHasErrors([
                'url' => 'The url format is invalid.',
            ]);
    }

    /** @test */
    public function url_max_validation_errors(): void
    {
        $url = call_user_func($this->model_classname.'::factory')->fakeUrl();

        $response = $this->actingAs($this->user)->post($this->getRoute(), [
            'url' => Str::padRight($url, 2001, 'A'),
        ]);
        $response->assertStatus(302)
            ->assertSessionHasErrors([
                'url' => 'The url may not be greater than 2000 characters.',
            ]);
    }

    /** @test */
    public function url_starts_with_http_validation_errors(): void
    {
        $url = 'ftp://'.$this->faker->safeEmailDomain.
            '/'.$this->faker->slug().'.html';

        $response = $this->actingAs($this->user)->post($this->getRoute(), [
            'url' => Str::padRight($url, 2001, 'A'),
        ]);
        $response->assertStatus(302)
            ->assertSessionHasErrors([
                'url' => 'The url must start with one of the following: http.',
            ]);
    }
}
