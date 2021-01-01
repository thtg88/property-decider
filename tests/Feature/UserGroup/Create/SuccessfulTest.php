<?php

namespace Tests\Feature\UserGroup\Create;

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
    public function successful_create(): void
    {
        $response = $this->actingAs($this->user)->get($this->getRoute());
        $response->assertStatus(200)
            ->assertViewIs('user-groups.create');
    }
}
