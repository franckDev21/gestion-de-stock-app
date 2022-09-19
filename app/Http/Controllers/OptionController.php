<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Fournisseur;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function index(){
        $categories = Category::all();
        $fournisseurs = Fournisseur::all();
        return view('options.index',compact(
            'categories',
            'fournisseurs'
        ));
    }

    public function categorieDelete(Category $category){
        $category->delete();
        return back()->with('message',"Votre catégorie à bie été supprimé !");
    }

    public function categorieStore(Request $request){
        $data = $request->validate([
            'name' => 'required|max:255'
        ]);

        Category::create($data);

        return back()->with('message',"votre catégorie a été créé avec succès !");
    }

    public function fournisseurDelete(Fournisseur $fournisseur){
        $fournisseur->delete();
        return back()->with('message',"Votre fournisseur à bie été supprimé !");
    }

    public function fournisseurStore(Request $request){
        $data = $request->validate([
            'name' => 'required|max:255'
        ]);

        Fournisseur::create($data);

        return back()->with('message',"votre Fournisseur a été créé avec succès !");
    }
}
