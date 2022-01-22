<?php

namespace Database\Factories;

use App\Models\Subscription;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subscription::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $subscription_name = $this->faker->unique()->words($nb=4, $asText=true);
        $slug = Str::slug($subscription_name);
        return [
            'name' => $subscription_name,
            'description' => $this->faker->text(500),
            'slug' => $slug,
            'status' => 'active',
        ];
    }
}
