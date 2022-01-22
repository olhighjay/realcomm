<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->words($nb=1, $asText=true),
            'last_name' => $this->faker->words($nb=1, $asText=true),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'dob' => now(),
            'phone_number' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'state' => $this->faker->randomElement(['Abia', 'Akwa Ibom', 'Bayelsa', 'Lagos', 'Oyo', 'Ogun', 'Rivers', 'Kebbi', 'Abuja', 'Lagos', 'Lagos', 'Ogun', 'Abuja', 'Ogun']),
            'role' => $this->faker->randomElement(['guest', 'customer', 'vendor']),
            'gender' => $this->faker->randomElement(['male', 'female','other']),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'status' => 'active',
            'deactivated' => false,
            'verified' => false,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
