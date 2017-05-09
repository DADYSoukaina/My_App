<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Famille extends Model
{
    protected $fillable=['nom','des'];


    public function produits(){
        return $this->hasMany('App\Produit','famille_id');

    }
}
