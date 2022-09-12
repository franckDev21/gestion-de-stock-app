<?php

namespace App\Http\Controllers;

use App\Models\Caisse;
use App\Models\CaisseTotal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CaisseController extends Controller
{
    public function index(){
        $caisses = Caisse::latest()
            ->paginate(6);
        $caissesTotal = CaisseTotal::all();
        $total = $caissesTotal->sum('montant');
        return view('caisse.index',compact('caisses','total'));
    }

    public function store(Request $request){
        $data = $request->validate([
            'montant' => 'required',
            'motif' => 'required',
        ]);
        
        
        Caisse::create(array_merge([
            'user_id' => auth()->user()->id,
            'type' => 'ENTRER'
        ],$data));

        $caisse = CaisseTotal::first();

        if(!$caisse){
            $caisse = CaisseTotal::create([
                'montant' => 0
            ]);
        }

        $total = $caisse->sum('montant');

        

        $caisse->update([
            'montant' => (int)$total + (int)$request->montant
        ]);

        return back()->with('message',"Nouvelle entrée enregister !");
    }

    public function sortie(Request $request){
        

        $data = $request->validate([
            'montant' => 'required',
            'motif' => 'required',
        ]);

        $caisses = CaisseTotal::all();
        
        if(!$caisses->first()){
            CaisseTotal::create([
                'montant' => 0
            ]);
        }

        $total = $caisses->sum('montant');

        if((int)$request->montant <= $total){
            $caisse = CaisseTotal::first();

            $caisse->update([
                'montant' => (int)$total - (int)$request->montant
            ]);
            
            Caisse::create(array_merge([
                'user_id' => auth()->user()->id,
                'type' => 'SORTIR'
            ],$data));
    
            return back()->with('message',"Nouvelle sortie enregister !");
        }else{

            return back()->with('error','Montant insufissant !');
        }
        
    }

    public function printCaisse(){
        
        $pdf = App::make('dompdf.wrapper');
        
        $caisses = Caisse::latest()->get();
        $caissesTotal = CaisseTotal::all();
        $total = $caissesTotal->sum('montant');

        $pdf->loadView('pdf.caisse', compact(
            'caisses',
            'total'
        ));

        return $pdf->stream();
    }
}
