<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncomingWare extends Model
{
    protected $fillable = ['product_id','jumlah','tanggal_masuk','nama_toko','penerima'];

    public function product() {
        return $this->belongsTo('App\Product');
    }

    public function penerima() {
        return $this->belongsTo('App\User', 'penerima');
    }
}
