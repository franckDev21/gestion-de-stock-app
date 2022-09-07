<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Approvisionnement>
 */
class ApprovisionnementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'product_id' => Product::inRandomOrder()->first()->id,
            'prix_achat' => rand(20000,1200000),
            'quantite' => rand(1,40),
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
