<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusinessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Business::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $business_name = $this->faker->unique()->words($nb=4, $asText=true);
        $vendors = User::where('role', 'vendor')->where('deactivated', false)->pluck('id');
        // error_log($vendors);
        // error_log($vendors[1]);
        // error_log($vendors[5]);
        // $randomInputIndex = rand(0, count($vendors)-1); // Returns any integer between 0 and number of contents in vendors in your case
        return [
            'name' => $business_name,
            'description' => $this->faker->text(500),
            'user_id' => $vendors[$this->faker->numberBetween(0, count($vendors)-1)],
            'business_category_id' => $this->faker->numberBetween(1,7),
            'subscription_id' => $this->faker->numberBetween(1,4),
            'status' => 'active',
        ];
    }
}
