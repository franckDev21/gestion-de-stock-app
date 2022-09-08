<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
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

Route::middleware(['auth'])->group(function(){
    Route::get('/', [HomeController::class,'index'])->name('home');
    Route::get('/dashboard', function () {return view('dashboard'); })->name('dashboard');

    // profil
    Route::post('mon-profil/photo',[UserController::class,'photo'])->name('profil.photo');
    Route::get('mon-profil',[UserController::class,'profil'])->name('profil.index');
    Route::patch('mon-profil/{user}',[UserController::class,'profilUpdate'])->name('profil.update');
    Route::post('mon-profil/password',[UserController::class,'profilPassword'])->name('profil.update-password');

    // products
    Route::resource('products',ProductController::class);

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


