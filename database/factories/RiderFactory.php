<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rider>
 */
class RiderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'mobile' =>(int) $this->faker->numerify('##########'), // Adjust this according to your needs
            'mobile_verified_at' => now(),
            'password' => bcrypt('password'), // You may customize the default password
            'otp' => $this->faker->randomNumber(6), // Adjust this according to your needs
            'country_id' => 99,
        ];
    }
}
