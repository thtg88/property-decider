<?php

namespace Tests\Feature\Property\Store;

use App\Helpers\PropertyHelper;
use App\Jobs\ProcessPropertyUrlJob;
use App\Models\Group;
use App\Models\PropertyPreference;
use App\Models\Status;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Database\Eloquent\Collection;
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
    public function successful_store(): void
    {
        Bus::fake();

        $url = call_user_func($this->model_classname.'::factory')->fakeUrl();

        $response = $this->actingAs($this->user)
            ->post($this->getRoute(), ['url' => $url]);
        $response->assertStatus(302)
            ->assertSessionHasNoErrors();

        $model = call_user_func($this->model_classname.'::latest')->first();

        $this->assertNotNull($model);
        $this->assertInstanceOf($this->model_classname, $model);
        $this->assertNotNull($model->property_amenities);
        $this->assertNotNull($model->property_preferences);
        $this->assertNotNull($model->status);
        $this->assertNotNull($model->user);
        $this->assertInstanceOf(Collection::class, $model->property_amenities);
        $this->assertInstanceOf(Collection::class, $model->property_preferences);
        $this->assertInstanceOf(Status::class, $model->status);
        $this->assertInstanceOf(User::class, $model->user);

        $this->assertEquals($model->url, $url);

        $response->assertRedirect(
            route('properties.show', ['property' => $model->id])
        );

        Bus::assertDispatched(ProcessPropertyUrlJob::class);
    }

    /** @test */
    public function successful_store_strips_url_query_string(): void
    {
        Bus::fake();

        $helper = resolve(PropertyHelper::class);

        $url = call_user_func($this->model_classname.'::factory')
            ->fakeUrl().'?foo=bar';

        $response = $this->actingAs($this->user)
            ->post($this->getRoute(), ['url' => $url]);
        $response->assertStatus(302)
            ->assertSessionHasNoErrors();

        $model = call_user_func($this->model_classname.'::latest')->first();

        $this->assertNotNull($model);

        $this->assertEquals($model->url, $helper->stripQuery($url));

        $response->assertRedirect(
            route('properties.show', ['property' => $model->id])
        );

        Bus::assertDispatched(ProcessPropertyUrlJob::class);
    }
}
