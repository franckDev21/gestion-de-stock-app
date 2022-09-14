<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'tel',
        'active',
        'email',
        'address',
        'photo'
    ];

    public function scopeFilter($query,$filters){
        if($filters['search'] ?? false){
            $query
                ->where('firstname','like','%'.$filters['search'].'%')
                ->orWhere('lastname','like','%'.$filters['search'].'%')
                ->orWhere('email','like','%'.$filters['search'].'%')
                ->orWhere('tel','like','%'.$filters['search'].'%');
        }
    }

    public function commandes(){
        return $this->hasMany(Commande::class);
    }
    
}

