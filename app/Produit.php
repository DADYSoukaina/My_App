<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable=['id','code','nom','des','pr_cl_fi','pr_cl_di','pr_cl_in','pr_cl_au','quan_mi','unite','famille_id'];


    public function famille(){
        return $this->belongsTo('App\Famille');
    }
}
