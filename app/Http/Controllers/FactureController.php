<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class FactureController extends Controller
{
    public function index(){
        $factures = Facture::with(['commande','client'])
            ->orderBy('updated_at', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->paginate(20);

        return view('facture.index',compact('factures'));
    }

    public function show(Facture $facture){
        // factures.show
        $pdf = App::make('dompdf.wrapper');
            
        $commandes = $facture->commande->commandeProducts;
        $commande = $facture->commande;

        $pdf->loadView('pdf.facture',compact(
            'commandes',
            'commande'
        ));

        return $pdf->stream();
    }
}
