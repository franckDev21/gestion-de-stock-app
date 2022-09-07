<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'lastname' => fake()->lastName(),
            'firstname' => fake()->firstName(),
            'tel' => fake()->phoneNumber(),
            'email' => fake()->safeEmail(),
            'address' => fake()->address,
        ];
    }
}
