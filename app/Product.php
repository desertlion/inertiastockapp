<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name','satuan'];

    public function stock() {
        return $this->hasOne('App\Stock');
    }
}
