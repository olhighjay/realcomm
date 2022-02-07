<?php

namespace Database\Factories;

use App\Models\state;
use Illuminate\Database\Eloquent\Factories\Factory;

class stateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = state::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $state_name = $this->faker->unique()->words($nb=4, $asText=true);
        return [
            'name' => $state_name
        ];
    }
}
