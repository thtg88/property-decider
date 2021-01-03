<?php

namespace Tests\Feature;

use App\Models\User;

class WelcomeTest extends TestCase
{
    /** @test */
    public function successful_get_as_guest(): void
    {
        $response = $this->get($this->getRoute());
        $response->assertStatus(200)
            ->assertViewIs('welcome.main');
    }

    /** @test */
    public function successful_authenticated(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get($this->getRoute());
        $response->assertStatus(200)
            ->assertViewIs('welcome.main');
    }

    /**
     * Return the route to use for these tests.
     *
     * @param array $parameters
     * @return string
     */
    public function getRoute(array $parameters = []): string
    {
        return '/';
    }
}
