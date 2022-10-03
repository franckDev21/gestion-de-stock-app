<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('qte_en_stock')->default(0);
            $table->integer('qte_stock_alert');
            $table->boolean('is_stock')->default(true);
            $table->integer('prix_unitaire');
            $table->integer('nbre_par_carton')->nullable();
            $table->integer('reste_unites')->nullable();
            $table->integer('poids')->nullable();
            $table->integer('qte_en_littre')->nullable();
            $table->enum('unite_mesure',['KG','L','G']);
            $table->string('image')->nullable();
            $table->string('nom');
            $table->string('type_approvionement')->default('carton');
            $table->text('description')->nullable();
            $table->boolean('vendu_par_piece')->default(false);
            $table->foreignId('fournisseur_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
