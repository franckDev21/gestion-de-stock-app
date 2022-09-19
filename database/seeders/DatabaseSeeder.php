<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use FontLib\Table\Type\name;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->create([
            'email' => 'francktiomela12@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'ADMIN',
            'active' => true
        ]);

        \App\Models\User::factory(10)->create();
        \App\Models\Client::factory(10)->create();
        \App\Models\Fournisseur::factory(10)->create();

        \App\Models\Category::factory(1)->create([
            'name' => 'Matériel d’entretien'
        ]);
        \App\Models\Category::factory(1)->create([
            'name' => 'Produit d’entretien'
        ]);
        \App\Models\Category::factory(1)->create([
            'name' => 'Matériel construction'
        ]);
        
        \App\Models\Category::factory(10)->create();
        
        // \App\Models\Product::factory(10)->create();
        // \App\Models\Approvisionnement::factory(20)->create();
        // \App\Models\Commande::factory(30)->create();
    }
}
