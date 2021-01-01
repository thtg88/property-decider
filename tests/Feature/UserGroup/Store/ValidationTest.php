<?php

namespace Tests\Feature\UserGroup\Store;

use App\Models\User;
use Illuminate\Support\Str;
use Tests\Feature\TestCase;
use Tests\Feature\UserGroup\WithModelData;

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
    public function email_required_validation_errors(): void
    {
        $response = $this->actingAs($this->user)->post($this->getRoute());
        $response->assertStatus(302)
            ->assertSessionHasErrors([
                'email' => 'The email field is required.',
            ]);
    }

    /** @test */
    public function email_string_validation_errors(): void
    {
        $response = $this->actingAs($this->user)->post($this->getRoute(), [
            'email' => ['ABCD'],
        ]);
        $response->assertStatus(302)
            ->assertSessionHasErrors([
                'email' => 'The email must be a string.',
            ]);
    }

    /** @test */
    public function email_max_validation_errors(): void
    {
        $email = '@'.$this->faker->safeEmailDomain;

        $response = $this->actingAs($this->user)->post($this->getRoute(), [
            'email' => Str::padLeft($email, 256, 'a'),
        ]);
        $response->assertStatus(302)
            ->assertSessionHasErrors([
                'email' => 'The email may not be greater than 255 characters.',
            ]);
    }

    /** @test */
    public function name_required_validation_errors(): void
    {
        $response = $this->actingAs($this->user)->post($this->getRoute());
        $response->assertStatus(302)
            ->assertSessionHasErrors([
                'name' => 'The name field is required.',
            ]);
    }

    /** @test */
    public function name_string_validation_errors(): void
    {
        $response = $this->actingAs($this->user)->post($this->getRoute(), [
            'name' => ['ABCD'],
        ]);
        $response->assertStatus(302)
            ->assertSessionHasErrors([
                'name' => 'The name must be a string.',
            ]);
    }

    /** @test */
    public function name_max_validation_errors(): void
    {
        $name = '';

        $response = $this->actingAs($this->user)->post($this->getRoute(), [
            'name' => Str::padRight($name, 256, 'A'),
        ]);
        $response->assertStatus(302)
            ->assertSessionHasErrors([
                'name' => 'The name may not be greater than 255 characters.',
            ]);
    }
}
