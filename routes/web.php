<?php

use App\Http\Controllers\CaisseController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\Client;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__.'/auth.php';

Route::middleware(['auth','active'])->group(function(){
    // Route::get('/', [HomeController::class,'index'])->name('home');
    Route::get('/', [HomeController::class,'index'])->name('dashboard');

    // options
    Route::get('/options',[OptionController::class,'index'])->name('options.home');
    Route::get('/options/{category}/delete/category',[OptionController::class,'categorieDelete'])->name('options.categories.delete');
    Route::post('/options/category/store',[OptionController::class,'categorieStore'])->name('options.categories.store');
    Route::get('/options/{fournisseur}/delete/fournisseur',[OptionController::class,'fournisseurDelete'])->name('options.fournisseurs.delete');
    Route::post('/options/fournisseur/store',[OptionController::class,'fournisseurStore'])->name('options.fournisseurs.store');
 
    // profil
    Route::post('mon-profil/photo',[UserController::class,'photo'])->name('profil.photo');
    Route::get('mon-profil',[UserController::class,'profil'])->name('profil.index');
    Route::patch('mon-profil/{user}',[UserController::class,'profilUpdate'])->name('profil.update');
    Route::post('mon-profil/password',[UserController::class,'profilPassword'])->name('profil.update-password');

    // products
    Route::get('products/history',[ProductController::class,'historiques'])->name('history.index');
    Route::get('products/history/inputs',[ProductController::class,'inputHistoriques'])->name('history.input');
    Route::get('products/history/outputs',[ProductController::class,'outputHistoriques'])->name('history.output');
    Route::get('products/history/print',[ProductController::class,'printHistoriques'])->name('history.print');
    Route::get('products/history/print/out',[ProductController::class,'printOutHistoriques'])->name('history.print.out');
    Route::get('products/history/print/int',[ProductController::class,'printIntHistoriques'])->name('history.print.int');
    Route::get('products/history/{product}/all',[ProductController::class,'productHistoriques'])->name('history.index.product');
    Route::get('products/history/{product}/input',[ProductController::class,'productIntHistoriques'])->name('history.input.product');
    Route::get('products/history/{product}/output',[ProductController::class,'productOutHistoriques'])->name('history.output.product');
    
    Route::get('products/print',[ProductController::class,'printProducts'])->name('printProducts');
    Route::resource('products',ProductController::class);
    Route::post('products/{product}/input',[ProductController::class,'addInput'])->name('products.addInput');
    Route::post('products/{product}/output',[ProductController::class,'addOutput'])->name('products.addOutput');
    
    // approvisionnement
    Route::get('approvisionnement/all',[ProductController::class,'approvisionnement'])->name('approvisionnement.index');

    // commande
    Route::get('commandes/print',[CommandeController::class,'print'])->name('commandes.printCommande');
    Route::resource('commandes',CommandeController::class);
    Route::post('commandes/payer/{commande}',[CommandeController::class,'payer'])->name('commandes.payer');
    Route::get('commandes/{commande}/facture',[CommandeController::class,'facture'])->name('commandes.facture');


    // caisse
    Route::get('caisse',[CaisseController::class,'index'])->name('caisse.index');
    Route::post('caisse/store',[CaisseController::class,'store'])->name('caisse.store');
    Route::post('caisse/sortie',[CaisseController::class,'sortie'])->name('caisse.sortie');
    Route::get('caisse/print',[CaisseController::class,'printCaisse'])->name('caisse.print');
    
    # admin routes
    Route::middleware('role:ADMIN')->group(function() {
        // users
        Route::get('users/print',[UserController::class,'printUsers'])->name('printUsers');
        Route::post('users/toggle-active/{user}',[UserController::class,'toggleActive']);
        Route::resource('users',UserController::class);

        // clients
        Route::get('clients/print',[ClientController::class,'printClients'])->name('printClients');
        Route::resource('clients',ClientController::class);
    });
});


