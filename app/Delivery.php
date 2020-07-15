<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = ['order_id','tanggal_penyerahan'];

    public function order() {
        return $this->belongsTo('App\Order', 'order_id');
    }
}
