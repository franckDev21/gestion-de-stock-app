<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approvisionnement extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'prix_achat',
        'quantite',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query,$filters){
        if($filters['search'] ?? false){
            $query
                ->where('quantite','like','%'.strtolower($filters['search']).'%')
                ->orWhere('prix_achat','like','%'.strtolower($filters['search']).'%');
        }
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
