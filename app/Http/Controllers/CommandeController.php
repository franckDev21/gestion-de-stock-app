<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\CommandeProduct;
use App\Models\HistoriqueProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commandes = Commande::with(['user','client'])
        ->orderBy('updated_at', 'DESC')
        ->orderBy('created_at', 'DESC')
        ->paginate(5);

        // dd($commandes);
        
        return view('commande.index',compact('commandes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('commande.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // on creer la commande
        $commande = Commande::create([
            'reference' => time(),
            'quantite'  => $request->total_qte,
            'desc'      => $request->desc,
            'cout'      => $request->totalCommande,
            'client_id' => $request->client,
            'user_id'   => $request->user_id,
            'etat'      => 'IMPAYER'
        ]);

        foreach($request->carts as $cart){
            CommandeProduct::create([
                'commande_id' => $commande->id,
                'product_id'  => $cart['id'],
                'qte'         => $cart['qte']
            ]);
        }

        // on met a jour le stock
        foreach($request->carts as $cart){

            if(($cart['unite_mesure'] === 'KG' || $cart['unite_mesure'] === 'G') && !$cart['nbre_par_carton']){
                if($cart['vendu_par_piece']){
                    $nbreUnites = $cart['qte_en_stock'] + $cart['reste_unites'];
                    $newNbreUnites = $nbreUnites - (int)$cart['qte'];
                    $newNbreParCarton = $newNbreUnites;
                    $resteUnites = 0;
                }else{
                    $nbreUnites =  ($cart['qte_en_stock'] * $cart['poids']) + $cart['reste_unites'];
                    $newNbreUnites = $nbreUnites - (int)$cart['qte'];
                    $newNbreParCarton = intval($newNbreUnites / $cart['poids']);
                    $resteUnites = $newNbreUnites % $cart['poids'];
                }
                
            }else if(($cart['unite_mesure'] !== 'KG' || $cart['unite_mesure'] !== 'G') && !$cart['nbre_par_carton']){
                $nbreUnites =  ($cart['qte_en_stock'] * $cart['qte_en_littre']) + $cart['reste_unites'];
                $newNbreUnites = $nbreUnites - (int)$cart['qte'];
                $newNbreParCarton = intval($newNbreUnites / $cart['qte_en_littre']);
                $resteUnites = $newNbreUnites % $cart['qte_en_littre'];
            }else{
                $nbreUnites =  ($cart['qte_en_stock'] * $cart['nbre_par_carton']) + $cart['reste_unites'];
                $newNbreUnites = $nbreUnites - (int)$request->qte;
                $newNbreParCarton = intval($newNbreUnites / $cart['nbre_par_carton']);
                $resteUnites = $newNbreUnites % $cart['nbre_par_carton'];
            }

            if ($newNbreUnites >= 0) {
                // increment qte product
                $product = Product::find($cart['id']);
                $product->update([
                    'qte_en_stock' => $newNbreParCarton,
                    'is_stock'     => $newNbreUnites > 0,
                    'reste_unites' => $resteUnites
                ]);

                if ($newNbreParCarton <= $product->qte_stock_alert) {
                    // notification alert stock
                }

                // new historic
                HistoriqueProduct::create([
                    'quantite'  => $cart['qte'],
                    'type'      => 'SORTIE',
                    'motif'     => 'Commande',
                    'product_id'=> $cart['id'],
                    'user_id'   => $request->user_id,
                    'is_unite'  => false
                ]);

            } else {
                return response()->json(["error", 'Stock inssufisant !']);
            }
            
        }

        return response()->json(["success", 'Votre commande a été rétiré avec succès !']);;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function show(Commande $commande)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function edit(Commande $commande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commande $commande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commande $commande)
    {
        //
    }
}
