<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriqueProduct extends Model
{
    use HasFactory;

    protected $fillable = ['quantite','type','motif','product_id','user_id','is_unite','old_state_stock'];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query,$filters){
        if($filters['search'] ?? false){
            $query
                ->where('created_at','like','%'.strtolower($filters['search']).'%');
        }
    }
}
