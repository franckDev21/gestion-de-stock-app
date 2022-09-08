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
}
