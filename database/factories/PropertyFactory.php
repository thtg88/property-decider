<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Property::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'broadband_speed' => rand(1, 100).' Mbps',
            'description' => $this->faker->text,
            'price' => rand(10000, 1000000),
            'status_id' => Status::inRandomOrder()->first(),
            'title' => $this->faker->words(5, true),
            'url' => $this->fakeUrl(),
            'user_id' => User::factory(),
        ];
    }

    public function fakeUrl(): string
    {
        return 'https://'.$this->faker->safeEmailDomain.
            '/'.$this->faker->slug().'.html';
    }
}
