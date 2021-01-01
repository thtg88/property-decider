<?php

namespace Tests\Feature\Property\Reprocess;

use App\Jobs\ProcessPropertyUrlJob;
use App\Models\Group;
use App\Models\PropertyPreference;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Support\Facades\Bus;
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
    public function successful_reprocess_as_property_creator(): void
    {
        Bus::fake();

        $model = call_user_func($this->model_classname.'::factory')->createOne([
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)
            ->post($this->getRoute([$model->id]));
        $response->assertStatus(302);

        Bus::assertDispatched(
            static function (ProcessPropertyUrlJob $job) use ($model) {
                return $job->property->id === $model->id;
            }
        );
    }

    /** @test */
    public function successful_reprocess_as_group_member(): void
    {
        Bus::fake();

        $model = call_user_func($this->model_classname.'::factory')->createOne();
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
            ->post($this->getRoute([$model->id]));
        $response->assertStatus(302);

        Bus::assertDispatched(
            static function (ProcessPropertyUrlJob $job) use ($model) {
                return $job->property->id === $model->id;
            }
        );
    }
}
