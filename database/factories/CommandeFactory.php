<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commande>
 */
class CommandeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'reference'     => time(),
            'quantite'      => rand(1,200),
            'cout'          => rand(1000,5000),
            'etat'          => ['FACTURER','IMPAYER','PAYER'][rand(0,2)],
            'client_id'     => Client::inRandomOrder()->first()->id,
            'product_id'    => Product::inRandomOrder()->first()->id,
            'user_id'       => User::inRandomOrder()->first()->id,
        ];
    }
}
