<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Famille extends Model
{
    protected $fillable=['nom','designation'];


    public function produits(){
        return $this->hasMany('App\Produit');

    }
}
