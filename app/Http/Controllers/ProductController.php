<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Fournisseur;
use App\Models\Product;
use Illuminate\Http\Request;
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
            ->filter(request(['tag','search']))
            ->paginate(5);
        return view('products.index',compact('products'));
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
        return view('products.create',compact('fournisseurs','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'qte_stock_alert'   => 'required',
            'prix_unitaire'     => 'required',
            'nom'               => 'required',
            'fournisseur_id'    => 'required',
            'category_id'       => 'required',
        ];

        if($request->image){
            $rules['image'] = 'required|mimes:png,jpg,jpeg,PNG,JPG,JPEG,jfif|max:4000';
            $filename = time().'.'.$request->image->extension();
            $path = $request->image->storeAs('img/products',$filename,'public');
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
            'description'     => $request->description ?? null
        ]);

        return to_route('products.index')->with("message",'Votre produit a été ajouter avec succès !');

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
        return view('products.show',compact('product','categories','fournisseurs'));
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
        return view('products.edit',compact('product','categories','fournisseurs'));
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

        $rules = [
            'qte_stock_alert'   => 'required',
            'prix_unitaire'     => 'required',
            'nom'               => 'required',
            'fournisseur_id'    => 'required',
            'category_id'       => 'required',
        ];

        if($request->image){
            if($product->image){
                if (File::exists($product->image)) {
                    File::delete($product->image);
                    Storage::delete($product->image);
                    unlink($$product->image);
                }
            }
            $rules['image'] = 'required|mimes:png,jpg,jpeg,PNG,JPG,JPEG,jfif|max:4000';
            $filename = time().'.'.$request->image->extension();
            $path = $request->image->storeAs('img/products',$filename,'public');
        }

        $request->validate($rules);

        $product->update([
            'qte_stock_alert' => $request->qte_stock_alert,
            'prix_unitaire'   => $request->prix_unitaire,
            'nom'             => strtolower($request->nom),
            'fournisseur_id'  => $request->fournisseur_id,
            'category_id'     => $request->category_id,
            'image'           => $path ?? $product->image,
            'description'     => $request->description ?? null
        ]);

        return back()->with('message',"le produit $product->nom a été mise à jour avec succès !");
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
        if($product->delete()){
            return to_route('products.index')->with('message',"le produit $name a été supprimer avec succès !");
        }
        return back()->withErrors('message');
    }
}
