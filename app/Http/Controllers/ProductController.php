<?php

namespace App\Http\Controllers;

use App\Models\Approvisionnement;
use App\Models\Category;
use App\Models\Fournisseur;
use App\Models\HistoriqueProduct;
use App\Models\Product;
use App\Notifications\ProductStockDangerNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('updated_at', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->filter(request(['tag', 'search']))
            ->paginate(10);
        return view('products.index', compact('products'));
    }

    public function indexApi(){
        return response()->json(Product::all());
    }

    public function approvisionnement(){
        $approvisionnements = Approvisionnement::orderBy('updated_at', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->filter(request(['tag', 'search']))
            ->paginate(5);

        return view('approvisionnement.index', compact('approvisionnements'));
    }

    public function historiques()
    {
        $historiques = HistoriqueProduct::with(['product', 'user'])
            ->orderBy('created_at', 'DESC')
            ->filter(request(['tag', 'search']))
            ->paginate(5);

        return view('products.history.index', compact('historiques'));
    }

    public function productHistoriques(Product $product){
        $historiques = HistoriqueProduct::with(['product', 'user'])
            ->orderBy('created_at', 'DESC')
            ->filter(request(['tag', 'search']))
            ->where('product_id',$product->id)
            ->paginate(5);

        return view('products.history.one', compact('historiques','product'));
    }

    public function productIntHistoriques(Product $product){
        $historiques = HistoriqueProduct::with(['product', 'user'])
            ->orderBy('created_at', 'DESC')
            ->filter(request(['tag', 'search']))
            ->where('product_id',$product->id)
            ->where('type','ENTR??E')
            ->paginate(5);

        return view('products.history.one', compact('historiques','product'));
    }

    public function productOutHistoriques(Product $product){
        $historiques = HistoriqueProduct::with(['product', 'user'])
            ->orderBy('created_at', 'DESC')
            ->filter(request(['tag', 'search']))
            ->where('product_id',$product->id)
            ->where('type','SORTIE')
            ->paginate(5);

        return view('products.history.one', compact('historiques','product'));
    }

    public function inputHistoriques(){
        $historiques = HistoriqueProduct::with(['product', 'user'])
            ->orderBy('created_at', 'DESC')
            ->filter(request(['tag', 'search']))
            ->where('type','ENTR??E')
            ->paginate(5);

        return view('products.history.input', compact('historiques'));
    }

    public function outputHistoriques(){
        $historiques = HistoriqueProduct::with(['product', 'user'])
            ->orderBy('created_at', 'DESC')
            ->filter(request(['tag', 'search']))
            ->where('type','SORTIE')
            ->paginate(5);

        return view('products.history.output', compact('historiques'));
    }

    public function addInput(Request $request, Product $product)
    {
        $request->validate([
            'qte'   => 'required',
            'prix'  => 'required'
        ]);

        // increment qte product
        $product->update([
            'qte_en_stock' => ((int)$product->qte_en_stock += (int)$request->qte),
            'is_stock'     => ((int)$product->qte_en_stock += (int)$request->qte) > 0
        ]);

        // on recupere le produit et verificie si son stock est > au stock_alert
        $product = Product::find($product->id);
        if((int)$product->qte_en_stock > (int)$product->qte_stock_alert){
            foreach($product->unreadNotifications as $notification){
                $notification->markAsRead();
            }
        }


        // new approvisionnement
        Approvisionnement::create([
            'product_id' => $product->id,
            'prix_achat' => $request->prix,
            'quantite'   => $request->qte,
            'user_id'    => $request->user()->id,
            'is_unite'   => false
        ]);

        // new historic
        HistoriqueProduct::create([
            'quantite'  => $request->qte,
            'type'      => 'ENTR??E',
            'motif'     => 'Approvisionnement',
            'product_id' => $product->id,
            'user_id'   => $request->user()->id
        ]);

        return back()->with("message", 'Votre approvisionnement a ??t?? ajout?? avec succ??s !');
    }

    public function addOutput(Request $request, Product $product)
    {
        $request->validate([
            'qte'   => 'required',
            'modif'   => 'required',
            'type'   => 'required'
        ]);


        if ($request->type === 'UNITE') {

            if(($product->unite_mesure === 'KG' || $product->unite_mesure === 'G') && !$product->nbre_par_carton){
                $nbreUnites =  ($product->qte_en_stock * $product->poids) + $product->reste_unites;
                $newNbreUnites = $nbreUnites - (int)$request->qte;
                $newNbreParCarton = intval($newNbreUnites / $product->poids);
                $resteUnites = $newNbreUnites % $product->poids;
            }else if(($product->unite_mesure !== 'KG' || $product->unite_mesure !== 'G') && !$product->nbre_par_carton){
                $nbreUnites =  ($product->qte_en_stock * $product->qte_en_littre) + $product->reste_unites;
                $newNbreUnites = $nbreUnites - (int)$request->qte;
                $newNbreParCarton = intval($newNbreUnites / $product->qte_en_littre);
                $resteUnites = $newNbreUnites % $product->qte_en_littre;
            }else{
                $nbreUnites =  ($product->qte_en_stock * $product->nbre_par_carton) + $product->reste_unites;
                $newNbreUnites = $nbreUnites - (int)$request->qte;
                $newNbreParCarton = intval($newNbreUnites / $product->nbre_par_carton);
                $resteUnites = $newNbreUnites % $product->nbre_par_carton;
            }

            if ($newNbreUnites >= 0) {
                // increment qte product
                $product->update([
                    'qte_en_stock' => $newNbreParCarton,
                    'is_stock'     => $newNbreUnites > 0,
                    'reste_unites' => $resteUnites
                ]);

                if ($newNbreParCarton <= $product->qte_stock_alert) {
                    // notification alert stock
                    $product->notify(new ProductStockDangerNotification());
                }

                // new historic
                HistoriqueProduct::create([
                    'quantite'  => $request->qte,
                    'type'      => 'SORTIE',
                    'motif'     => $request->modif,
                    'product_id' => $product->id,
                    'user_id'   => $request->user()->id,
                    'is_unite'  => $request->type === 'CARTON' ? false : true
                ]);

                return back()->with("message", 'Le produit a ??t?? r??tir?? avec succ??s !');
            } else {
                return back()->with("error", "La quantit?? en stock du $product->nom est insuffisant !");
            }
        } else {
            if (((int)$product->qte_en_stock - (int)$request->qte) >= 0) {
                $newQteProduct = (int)$product->qte_en_stock -= (int)$request->qte;
                // increment qte product
                $product->update([
                    'qte_en_stock' => $newQteProduct,
                    'is_stock'     =>  ($newQteProduct + $product->reste_unites) > 0 
                ]);

                if ($newQteProduct <= $product->qte_stock_alert) {
                    // notification alert stock
                    $product->notify(new ProductStockDangerNotification());
                }

                // new historic
                HistoriqueProduct::create([
                    'quantite'  => $request->qte,
                    'type'      => 'SORTIE',
                    'motif'     => $request->modif,
                    'product_id' => $product->id,
                    'user_id'   => $request->user()->id,
                    'is_unite'  => $request->type === 'CARTON' ? false : true
                ]);

                return back()->with("message", 'Le produit a ??t?? r??tir?? avec succ??s !');
            } else {
                return back()->with("error", "La quantit?? en stock du $product->nom est insuffisant !");
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fournisseurs = Fournisseur::all();
        $categories   = Category::all();
        return view('products.create', compact('fournisseurs', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $desactiveNbreParKilo = $request->desactive ? true : false;

        $rules = [
            'qte_stock_alert'   => 'required',
            'prix_unitaire'     => 'required',
            'nom'               => 'required',
            'fournisseur_id'    => 'required',
            'category_id'       => 'required',
            'type_approvionement' => 'required',
            'unite_mesure'        => 'required'
        ];

        $nbre_par_carton = null;
        $poids = null;
        $qte_en_littre = null;
        $vendu_par_piece = false;

        if($request->unite_mesure === 'KG' || $request->unite_mesure === 'G'){
            $poids = $request->poids ? $request->poids : $request->poids2;
        }elseif($request->unite_mesure === 'UNIQUE'){
            $poids = $request->poids;
            $vendu_par_piece = true;
            $request->unite_mesure = 'KG';
            
        }else{
            $qte_en_littre = $request->qte_en_littre;
        }

        if (!$desactiveNbreParKilo) {
            $nbre_par_carton = (int)$request->nbre_par_carton;
        }

        if ($request->image) {
            $rules['image'] = 'required|mimes:png,jpg,jpeg,PNG,JPG,JPEG,jfif|max:4000';
            $filename = time() . '.' . $request->image->extension();
            $path = $request->image->storeAs('img/products', $filename, 'public');
        }

        $request->validate($rules);

        Product::create([
            'qte_stock_alert' => $request->qte_stock_alert,
            'prix_unitaire'   => $request->prix_unitaire,
            'nom'             => strtolower($request->nom),
            'fournisseur_id'  => $request->fournisseur_id,
            'category_id'     => $request->category_id,
            'is_stock'        => false,
            'image'           => $path ?? null,
            'description'     => $request->description ?? null,
            'type_approvionement' => $request->type_approvionement,
            'nbre_par_carton'     => $nbre_par_carton,
            'unite_mesure'        => $request->unite_mesure,
            'poids'               => $poids,
            'qte_en_littre'       => $qte_en_littre,
            'vendu_par_piece'     => $vendu_par_piece
        ]);

        return to_route('products.index')->with("message", 'Votre produit a ??t?? ajout?? avec succ??s !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $fournisseurs = Fournisseur::all();
        $categories   = Category::all();
        return view('products.show', compact('product', 'categories', 'fournisseurs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        // dd($product);
        $fournisseurs = Fournisseur::all();
        $categories   = Category::all();
        // dd($product->unite_mesure == 'L');
        return view('products.edit', compact('product', 'categories', 'fournisseurs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {

        $desactiveNbreParKilo = $request->desactive ? true : false;

        $rules = [
            'qte_stock_alert'   => 'required',
            'prix_unitaire'     => 'required',
            'nom'               => 'required',
            'fournisseur_id'    => 'required',
            'category_id'       => 'required',
            'type_approvionement' => 'required',
            'unite_mesure'        => 'required'
        ];

        $nbre_par_carton = null;
        $poids = null;
        $qte_en_littre = null;
        $vendu_par_piece = false;

        if($request->unite_mesure === 'KG' || $request->unite_mesure === 'G'){
            $poids = $request->poids ? $request->poids : $request->poids2;
        }elseif($request->unite_mesure === 'UNIQUE'){
            $poids = $request->poids;
            $vendu_par_piece = true;
            $request->unite_mesure = 'KG';
            
        }else{
            $qte_en_littre = $request->qte_en_littre;
        }

        if (!$desactiveNbreParKilo) {
            $rules['nbre_par_carton'] = 'required';
            $nbre_par_carton = (int)$request->nbre_par_carton;
        }

        if ($request->image) {
            if ($product->image) {
                if (File::exists($product->image)) {
                    File::delete($product->image);
                    Storage::delete($product->image);
                    unlink($$product->image);
                }
            }
            $rules['image'] = 'required|mimes:png,jpg,jpeg,PNG,JPG,JPEG,jfif|max:4000';
            $filename = time() . '.' . $request->image->extension();
            $path = $request->image->storeAs('img/products', $filename, 'public');
        }

        $request->validate($rules);

        $product->update([
            'qte_stock_alert' => $request->qte_stock_alert,
            'prix_unitaire'   => $request->prix_unitaire,
            'nom'             => strtolower($request->nom),
            'fournisseur_id'  => $request->fournisseur_id,
            'category_id'     => $request->category_id,
            'image'           => $path ?? $product->image,
            'description'     => $request->description ?? null,
            'type_approvionement' => $request->type_approvionement,
            'nbre_par_carton'     => $nbre_par_carton,
            'unite_mesure'        => $request->unite_mesure,
            'poids'               => $poids,
            'qte_en_littre'       => $qte_en_littre,
            'vendu_par_piece'     => $vendu_par_piece
        ]);

        return back()->with('message', "le produit $product->nom a ??t?? mis ?? jour avec succ??s !");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $name = $product->nom;
        if ($product->delete()) {
            return to_route('products.index')->with('message', "le produit $name a ??t?? supprimer avec succ??s !");
        }
        return back()->withErrors('message');
    }


    public function printProducts()
    {
        $pdf = App::make('dompdf.wrapper');

        $products = Product::all();

        $pdf->loadView('pdf.products', compact(
            'products'
        ));

        return $pdf->stream();
    }

    public function printHistoriques(){
        $pdf = App::make('dompdf.wrapper');

        $historiques = HistoriqueProduct::with(['product', 'user'])
            ->orderBy('created_at', 'DESC')
            ->get();

        $name = 'all';

        $pdf->loadView('pdf.historique', compact(
            'historiques',
            'name'
        ));

        return $pdf->stream();
    }

    public function printOutHistoriques(){
        $pdf = App::make('dompdf.wrapper');

        $historiques = HistoriqueProduct::with(['product', 'user'])
            ->orderBy('created_at', 'DESC')
            ->where('type','SORTIE')
            ->get();

        $name = 'sortie';

        $pdf->loadView('pdf.historique', compact(
            'historiques',
            'name'
        ));

        return $pdf->stream();
    }

    public function printIntHistoriques(){
        $pdf = App::make('dompdf.wrapper');

        $historiques = HistoriqueProduct::with(['product', 'user'])
            ->orderBy('created_at', 'DESC')
            ->where('type','ENTR??E')
            ->get();

        $name = 'entree';

        $pdf->loadView('pdf.historique', compact(
            'historiques',
            'name'
        ));

        return $pdf->stream();
    }

}
