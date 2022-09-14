<?php

namespace App\Http\Controllers;

use App\Models\CaisseTotal;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){

        $products = Product::all();
        $productNotifications = [];
        foreach($products as $product){
            foreach($product->unreadNotifications as $notification){
                $productNotifications[] = "La quantité en stock du produit `".ucfirst($notification->data['name'])."` est insufissant";
            }
        }

        // total caisse
        $caisses = CaisseTotal::all();
        if(!$caisses->first()){
            CaisseTotal::create([
                'montant' => 0
            ]);
        }
        $totalCaisse = $caisses->sum('montant');

        // total user
        $totalUser = User::all()->count();

        // total product
        $totalProduct = Product::all()->count();

        // total product
        $totalClient = Client::all()->count();

        // total commande
        $totalCommande = Commande::all()->count();


        // dd($totalUser);
        return view('dashboard',compact(
            'totalCaisse',
            'totalUser',
            'totalProduct',
            'totalClient',
            'totalCommande',
            'productNotifications'
        ));
    }
}
