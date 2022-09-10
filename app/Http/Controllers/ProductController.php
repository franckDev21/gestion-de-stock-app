<?php

namespace App\Http\Controllers;

use App\Models\Approvisionnement;
use App\Models\Category;
use App\Models\Fournisseur;
use App\Models\HistoriqueProduct;
use App\Models\Product;
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
            ->paginate(5);
        return view('products.index', compact('products'));
    }

    public function historiques()
    {
        $historiques = HistoriqueProduct::with(['product', 'user'])
            ->orderBy('created_at', 'DESC')
            ->filter(request(['tag', 'search']))
            ->paginate(5);

        return view('products.history.index', compact('historiques'));
    }

    public function inputHistoriques(){
        $historiques = HistoriqueProduct::with(['product', 'user'])
            ->orderBy('created_at', 'DESC')
            ->filter(request(['tag', 'search']))
            ->where('type','ENTRÉE')
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

        // new approvisionnement
        Approvisionnement::create([
            'product_id' => $product->id,
            'prix_achat' => $request->prix,
            'quantite'   => $request->qte,
            'user_id'    => $request->user()->id,
        ]);

        // new historic
        HistoriqueProduct::create([
            'quantite'  => $request->qte,
            'type'      => 'ENTRÉE',
            'motif'     => 'Approvisionnement',
            'product_id' => $product->id,
            'user_id'   => $request->user()->id
        ]);

        return back()->with("message", 'Votre approvisionnement a été ajouter avec succès !');
    }

    public function addOutput(Request $request, Product $product)
    {
        $request->validate([
            'qte'   => 'required',
            'modif'   => 'required',
            'type'   => 'required'
        ]);


        if ($request->type === 'UNITE') {

            // si c'est un produit non liquide dont on peut 
            if(($product->unite_mesure === 'KG' || $product->unite_mesure === 'G') && !$product->nbre_par_carton){
                $nbreUnites =  ($product->qte_en_stock * $product->poids) + $product->reste_unites;
                $newNbreUnites = $nbreUnites - (int)$request->qte;
                $newNbreParCarton = intval($newNbreUnites / $product->poids);
                $resteUnites = $newNbreUnites % $product->poids;

                // on verifie que le nbre de seau($product->qte_en_stock) >= 1
                    // si oui
                        // on verifie que ce quil veux enlever soit < au poids d'un seau($request->qte < $product->new_poids) | on ne veux pas enlever tous le contenu du seau
                            // on verifie qu'il y'a un reste pour le produit en BD $produit->reste_unites ($produit->reste_unites > 0)
                                // si oui 
                                    // $stepReste = $produit->reste_unites - $request->qte
                                    // $old_reste = $produit->reste_unites
                                    // on verifie si $stepReste < 0
                                        // si oui  | xa veux dire que ce qu'on veux enlever est > ou = 0
                                            // on met le reste en BD a 0 | $produit->reste_unites = 0
                                            // on verifie la qte en stock > 1
                                                // si oui
                                                    // on decremente 1 unité sur la qte en stock en BD | $product->qte_en_stock = $product->qte_en_stock - 1
                                                    // on calcule le newReste => $newPoidUnSeau = $product->new_poids - ($stepReste * (-1))
                                                    // on met a jour le $produit->reste_unites en BD | $produit->reste_unites = $newPoidUnSeau + (($stepReste * (-1)) - $old_reste)
                                                // sinon | xa veux dire qu'il reste 1 seul en stock
                                                    //  on met 
                                            // 
                                        // sinon
                                // sinon
                                    // si oui 
                                        // on decremente le poids d'un seau
                                        // $newPoidUnSeau = $product->new_poids - $request->qte
                                        // on verifie que $newPoidUnSeau est > 0
                                            // si oui
                                                // ont met a jour le stock . $product->qte_en_stock = $product->qte_en_stock - 1
                                                // on met a jour la proriete reste_unites ($produit->reste_unites = $newPoidUnSeau)
                                            // sinon
                                                # j'amis on arrivera ici
                                        // $request->new_poids = $new_poids
                                    // sinon
                                        // message d'erreur => vous ne pouvez pas enlever tous le contenu d'un seau
                    // sinon 
                        // message d'erreur => stock insuffisant

            }else if(($product->unite_mesure !== 'KG' || $product->unite_mesure !== 'G') && !$product->nbre_par_carton){
                // dd($product,$request->all(),'liquide mais sans nombre par carton');

                $nbreUnites =  ($product->qte_en_stock * $product->qte_en_littre) + $product->reste_unites;
                $newNbreUnites = $nbreUnites - (int)$request->qte;
                $newNbreParCarton = intval($newNbreUnites / $product->qte_en_littre);
                $resteUnites = $newNbreUnites % $product->qte_en_littre;

                // decremente la qte en littre du produit => $new_qte_en_littre = $request->qte_en_littre - $request->qte
                // on garde xa comme nouvelle valeur en stock de la colonne $produit->qte_en_littre = $new_qte_en_littre
            }else{
                // dd($product,$request->all(),'solide avec nombre par carton');

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

                return back()->with("message", 'Le produit a été rétiré avec succès !');
            } else {
                return back()->with("error", "La quantité en stock du $product->nom est insuffisant !");
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

                return back()->with("message", 'Le produit a été rétiré avec succès !');
            } else {
                return back()->with("error", "La quantité en stock du $product->nom est insuffisant !");
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


        if($request->unite_mesure === 'KG' || $request->unite_mesure === 'G'){
            $poids = $request->poids;
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
        ]);

        return to_route('products.index')->with("message", 'Votre produit a été ajouter avec succès !');
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
        $fournisseurs = Fournisseur::all();
        $categories   = Category::all();
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

        if($request->unite_mesure === 'KG' || $request->unite_mesure === 'G'){
            $poids = $request->poids;
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
        ]);

        return back()->with('message', "le produit $product->nom a été mise à jour avec succès !");
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
            return to_route('products.index')->with('message', "le produit $name a été supprimer avec succès !");
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
            ->where('type','ENTRÉE')
            ->get();

        $name = 'entree';

        $pdf->loadView('pdf.historique', compact(
            'historiques',
            'name'
        ));

        return $pdf->stream();
    }

}
