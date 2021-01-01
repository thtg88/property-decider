<?php

namespace Tests\Feature\UserGroup\Store;

use App\Models\Group;
use App\Models\User;
use App\Notifications\InviteUserNotification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;
use Tests\Feature\TestCase;
use Tests\Feature\UserGroup\WithModelData;

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
    public function successful_store(): void
    {
        Notification::fake();

        $data = [
            'name' => $this->faker->firstName,
            'email' => $this->faker->safeEmail,
        ];

        $this->assertEquals(Group::count(), 0);
        $this->assertEquals(
            call_user_func($this->model_classname.'::count'),
            0
        );
        $this->assertNull($this->user->getGroup());

        $response = $this->actingAs($this->user)
            ->post($this->getRoute(), $data);
        $response->assertStatus(302)
            ->assertSessionHasNoErrors();

        $model = call_user_func($this->model_classname.'::latest', 'id')->first();
        $user = User::where('email', $data['email'])->first();

        $this->assertNotNull($model);
        $this->assertNotNull($user);
        $this->assertInstanceOf($this->model_classname, $model);
        $this->assertNotNull($model->group);
        $this->assertNotNull($model->user);
        $this->assertInstanceOf(Group::class, $model->group);
        $this->assertInstanceOf(User::class, $model->user);

        $this->user = $this->user->refresh();

        $this->assertNotNull($this->user->getGroup());
        $this->assertNotNull($user->getGroup());
        $this->assertInstanceOf(Group::class, $this->user->getGroup());
        $this->assertInstanceOf(Group::class, $user->getGroup());
        $this->assertEquals(Group::count(), 1);
        $this->assertEquals(
            call_user_func($this->model_classname.'::count'),
            2
        );
        $this->assertEquals($user->id, $model->user_id);
        $this->assertNotNull($user->email_verified_at);
        $this->assertEquals(
            $this->user->getGroup()?->id,
            $user->getGroup()->id
        );

        foreach($data as $key => $value) {
            $this->assertEquals($user->$key, $value);
        }

        $response->assertRedirect(route('dashboard'));

        Notification::assertSentTo(
            [$model->user],
            InviteUserNotification::class
        );
    }
}
