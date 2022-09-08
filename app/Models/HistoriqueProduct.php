<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriqueProduct extends Model
{
    use HasFactory;

    protected $fillable = ['quantite','type','motif','product_id','user_id'];
}
