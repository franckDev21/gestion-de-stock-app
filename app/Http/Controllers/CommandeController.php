<?php

namespace App\Http\Controllers;

use App\Mail\CommandeMail;
use App\Models\Caisse;
use App\Models\CaisseTotal;
use App\Models\Client;
use App\Models\Commande;
use App\Models\CommandeProduct;
use App\Models\HistoriqueProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

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
            ->filter(request(['search']))
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
                $newNbreUnites = $nbreUnites - (int)$cart['qte'];
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
                    'is_unite'  => true
                ]);

            } else {
                return response()->json(["error", 'Stock inssufisant !']);
            }
            
        }

        return response()->json(["success" =>  $commande->id]);;

    }

    public function payer(Commande $commande){

        if($commande->etat === 'PAYER'){
            return back()->with('warning','Cette commande a déjà été payer');
        }

        // on met a jour l'etat de la commande
        $commande->update([
            'etat' => 'PAYER'
        ]);

        // on met a jour la caisse
        Caisse::create([
            'user_id' => auth()->user()->id,
            'type' => 'ENTRER',
            'montant' => (int)implode('',explode('.',$commande->cout)),
            'commande_id' => $commande->id,
            'motif'   => 'Paiement de la commande'
        ]);

        $caisse = CaisseTotal::first();

        if(!$caisse){
            $caisse = CaisseTotal::create([
                'montant' => 0
            ]);
        }

        $total = $caisse->sum('montant');

        $caisse->update([
            'montant' => (int)$total + (int)implode('',explode('.',$commande->cout))
        ]);

        return to_route('commandes.show',$commande->id)->with('message','La commande a été payer avec succès !');
    }

    public function facture(Request $request, Commande $commande){

       $commande->update([
            'etat' => 'FACTURER'
       ]);

        if($request->payer){
            $this->payer($commande);
        }

       $pdf = App::make('dompdf.wrapper');
        
       $commandes = $commande->commandeProducts;

       if(isset($commande->client->email)){
        // on envoi un mail l'utilisateur
        Mail::to($commande->client->email)
        ->send(new CommandeMail($commande,$commandes));

        
       }
       $pdf->loadView('pdf.facture', compact(
        'commandes',
        'commande'
    ));
        return $pdf->stream();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function show(Commande $commande)
    {
        $commande = Commande::with(['client','user','commandeProducts'])
            ->where('id',$commande->id)->first();
        
            // dd($commande->commandeProducts,$commande->commandeProducts->first()->product);
            
        return view('commande.show',compact('commande'));
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
        if($commande->statut !== 'PAYER'){
            $commande->delete();
            return to_route('commandes.index')->with('message',"la commande a été supprimer avec succès !");
        }else{
            return back();
        }
    }
}
