<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Fournisseur;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'qte_en_stock' => rand(10,50),
            'qte_stock_alert' => rand(2,4),
            'prix_unitaire' => rand(500,40000),
            'nom' => fake()->word,
            'fournisseur_id' => Fournisseur::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,
        ];
    }
}
