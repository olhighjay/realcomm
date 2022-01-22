<?php

namespace Database\Factories;

use App\Models\Business_category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class Business_categoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Business_category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $business_category_name = $this->faker->unique()->words($nb=4, $asText=true);
        $slug = Str::slug($business_category_name);
        return [
            'name' => $business_category_name,
            'description' => $this->faker->text(500),
            'slug' => $slug,
            'status' => 'active',
        ];
    }
}
