<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cart::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(3,10),
            'status' => 'active',
            'quantity' => $this->faker->numberBetween(1,20),
            'product_id' => function() {
                return Product::factory()->create()->id;
                // return \App\Models\Channel::factory(User::class)->create()->id;

            },
        ];
    }
}
