<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncomingWare extends Model
{
    protected $fillable = ['product_id','jumlah','tanggal_masuk','nama_toko','penerima','jumlah_sebelum'];

    public function product() {
        return $this->belongsTo('App\Product');
    }

    public function user() {
        return $this->belongsTo('App\User', 'penerima');
    }

    public function Penerima() {
        return $this->belongsTo('App\User', 'penerima');
    }
}
