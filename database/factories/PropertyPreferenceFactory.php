<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\PropertyPreference;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyPreferenceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PropertyPreference::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'is_liked' => rand(0, 1) === 1,
            'property_id' => Property::factory(),
            'user_id' => User::factory(),
        ];
    }
}
