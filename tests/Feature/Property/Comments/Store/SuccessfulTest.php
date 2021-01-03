<?php

namespace Tests\Feature\Property\Comments\Store;

use App\Events\CommentStored;
use App\Models\Comment;
use App\Models\Group;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
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
    public function successful_store_as_property_creator(): void
    {
        Event::fake();
        Notification::fake();

        $model = call_user_func($this->model_classname.'::factory')
            ->createOne(['user_id' => $this->user->id]);

        $content = $this->faker->text;

        $response = $this->actingAs($this->user)
            ->post($this->getRoute([$model->id]), ['content' => $content]);
        $response->assertStatus(302)
            ->assertSessionHasNoErrors();

        $comment = Comment::latest()->first();

        $this->assertNotNull($comment);
        $this->assertInstanceOf(Comment::class, $comment);
        $this->assertNotNull($comment->user);
        $this->assertInstanceOf(Collection::class, $model->refresh()->comments);
        $this->assertInstanceOf(User::class, $model->user);

        $this->assertEquals($model->comments->count(), 1);
        $this->assertEquals($model->comments->first()->id, $comment->id);

        $this->assertEquals($comment->content, $content);
        $this->assertEquals($comment->property_id, $model->id);
        $this->assertEquals($comment->user_id, $this->user->id);

        $response->assertRedirect(
            route('properties.show', ['property' => $model->id]).'#comments'
        );

        Event::assertDispatched(CommentStored::class);
    }

    /** @test */
    public function successful_store_as_group_member(): void
    {
        Event::fake();
        Notification::fake();

        $model = call_user_func($this->model_classname.'::factory')->createOne();
        $content = $this->faker->text;
        $group = Group::factory()->createOne();
        UserGroup::factory()->invited($model->user)->accepted()->createOne([
            'group_id' => $group->id,
            'user_id' => $model->user_id,
        ]);
        UserGroup::factory()->invited($model->user)->accepted()->createOne([
            'group_id' => $group->id,
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)
            ->post($this->getRoute([$model->id]), ['content' => $content]);
        $response->assertStatus(302)
            ->assertSessionHasNoErrors();

        $comment = Comment::latest()->first();

        $this->assertNotNull($comment);
        $this->assertInstanceOf(Comment::class, $comment);
        $this->assertNotNull($comment->user);
        $this->assertInstanceOf(Collection::class, $model->refresh()->comments);
        $this->assertInstanceOf(User::class, $model->user);

        $this->assertEquals($model->comments->count(), 1);
        $this->assertEquals($model->comments->first()->id, $comment->id);

        $this->assertEquals($comment->content, $content);
        $this->assertEquals($comment->property_id, $model->id);
        $this->assertEquals($comment->user_id, $this->user->id);

        $response->assertRedirect(
            route('properties.show', ['property' => $model->id]).'#comments'
        );

        Event::assertDispatched(CommentStored::class);
    }
}
