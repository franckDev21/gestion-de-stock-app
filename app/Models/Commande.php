<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'quantite',
        'cout',
        'etat' ,
        'client_id',
        'user_id'  ,
        'desc'
    ];

    public function user(){
       return $this->belongsTo(User::class);
    }

   //  public function product(){
   //     return $this->belongsTo(Product::class);
   //  }

         public function commandeProducts(){
          return $this->hasMany(CommandeProduct::class);
       }

    public function client(){
       return $this->belongsTo(Client::class);
    }

}
