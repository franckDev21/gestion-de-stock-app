<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'qte_en_stock',
        'qte_stock_alert',
        'prix_unitaire',
        'image',
        'nom',
        'fournisseur_id',
        'category_id',
        'is_stock'
    ];

    public function scopeFilter($query,$filters){
        if($filters['search'] ?? false){
            $query
                ->where('nom','like','%'.strtolower($filters['search']).'%')
                ->orWhere('qte_en_stock','like','%'.strtolower($filters['search']).'%')
                ->orWhere('prix_unitaire','like','%'.strtolower($filters['search']).'%')
                ->orWhere('qte_stock_alert','like','%'.strtolower($filters['search']).'%');
        }
    }

    public function fournisseur(){
        return $this->belongsTo(Fournisseur::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

}
