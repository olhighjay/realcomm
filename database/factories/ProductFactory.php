<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use App\Models\Business;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product_name = $this->faker->unique()->words($nb=4, $asText=true);
        $slug = Str::slug($product_name);
        $vendors = User::where('role', 'vendor')->where('deactivated', false)->pluck('id');
        $businesses = Business::where('deactivated', false)->pluck('id');
        $array = [1,2,3,4,5,6,7,8,9,0,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        $randomStr = Str::random(3);
        // error_log($randomStr);
        $rand = array_rand($array, 2);
        // error_log($rand);
        $random1 = $array[$rand[1]];
        $random2 = $array[$rand[0]];
        $t=time();
        $curentSec = date("s",$t);
        // error_log($random);
        // error_log($curentSec);
        return [
            'name' => $product_name,
            'slug' => $slug,
            'short_description' => $this->faker->text(200),
            'description' => $this->faker->text(500),
            'regular_price' => $this->faker->numberBetween(30000,50000),
            'sale_price' => $this->faker->numberBetween(1000,20000),
            'user_id' => 3,
            'business_id' => 4,
            'product_specific_id' => $randomStr.$curentSec.$random1.$random2,
            'user_id' => $vendors[$this->faker->numberBetween(0, count($vendors)-1)],
            'business_id' => $businesses[$this->faker->numberBetween(0, count($businesses)-1)],
            'SKU' => 'DIGI'.$this->faker->unique()->numberBetween(10,500),
            'stock_status' => $this->faker->randomElement(['in stock', 'out of stock', 'low stock']),
            'quantity' => $this->faker->numberBetween(1,20),
            'category_id' => $this->faker->numberBetween(1,5),
            'status' => 'active',
            'deactivated' => false,
        ];
    }
}
