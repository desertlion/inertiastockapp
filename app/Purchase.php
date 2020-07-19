<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['product_id', 'nama_toko', 'jumlah', 'total_harga'];

    public function product() {
        return $this->belongsTo('App\Product');
    }
}
