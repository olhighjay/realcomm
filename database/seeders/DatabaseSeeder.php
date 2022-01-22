<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Cart;
use App\Models\Admin;
use App\Models\Business;
use App\Models\Business_category;
use App\Models\Subscription;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(30)->create();
        Admin::factory(15)->create();
        Category::factory(6)->create();
        Subscription::factory(5)->create();
        Business_category::factory(7)->create();
        Business::factory(10)->create();
        Product::factory(100)->create();
        Cart::factory(12)->create();
    }
}
