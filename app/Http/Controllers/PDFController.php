<?php

namespace App\Http\Controllers;

use App\IncomingWare;
use App\Order;
use App\Product;
use App\Purchase;
use Illuminate\Support\Facades\DB;
use PDF;
use stdClass;

class PDFController extends Controller
{
    public function stock($bulan = null, $tahun = null)
    {
        // tentukan periode
        if(!isset($bulan)) $bulan = date('m');
        if(!isset($tahun)) $tahun = date('Y');

        $Incomings = DB::table('incoming_wares')
            // ->leftjoin('products','products.id','=','incoming_wares.product_id')
            ->select('product_id','jumlah_sebelum', DB::raw('SUM(jumlah) as jlh_total'))
            ->whereMonth('incoming_wares.created_at', $bulan)
            ->whereYear('incoming_wares.created_at', $tahun)
            // ->whereRaw("created_at BETWEEN CAST('2020-07-01' AS DATE) AND CAST('2020-07-31' AS DATE)")
            ->groupBy('product_id')
            ->orderBy('product_id')
            ->orderBy('created_at', 'asc')
            ->get();
        $incomings = [];
        foreach($Incomings as $i):
            if(!key_exists($i->product_id, $incomings)) $incomings[$i->product_id] = $i;
        endforeach;

        $Outgoings = DB::table('orders')
            // ->leftjoin('orders','orders.id','=','deliveries.order_id')
            ->select('product_id', DB::raw('SUM(jumlah) as jlh_total'))
            // ->whereRaw("status > 0 AND created_at BETWEEN CAST('2020-07-01' AS DATE) AND CAST('2020-07-31' AS DATE)")
            ->where('status', '>', 0)
            ->whereMonth('orders.created_at', $bulan)
            ->whereYear('orders.created_at', $tahun)
            ->groupBy('product_id')
            ->orderBy('product_id')
            ->orderBy('created_at', 'asc')
            ->get();
        $outgoings = [];
        foreach($Outgoings as $o):
            if(!key_exists($o->product_id, $outgoings)) $outgoings[$o->product_id] = $o;
        endforeach;

        $reports = Product::all()->map(function ($p) use($incomings, $outgoings) {
          $jlh_sebelum = key_exists($p->id, $incomings) ? $incomings[$p->id]->jumlah_sebelum : 0;
          $jlh_masuk = key_exists($p->id, $incomings) ? $incomings[$p->id]->jlh_total : 0;
          $jlh_keluar = key_exists($p->id, $outgoings) ? $outgoings[$p->id]->jlh_total : 0;
          return (object) [
              "id" => $p->id,
              "product_name" => $p->name,
              "jumlah_sebelum" => $jlh_sebelum,
              "jumlah_masuk" => $jlh_masuk,
              "jumlah_keluar" => $jlh_keluar,
              "stock" => $jlh_sebelum + $jlh_masuk - $jlh_keluar,
          ];
        });

        return PDF::loadView('pdf.stock', [
            'reports' => $reports,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'months' => ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
        ])->stream();
    }

    public function demands($bulan = null, $tahun = null)
    {
        // tentukan tanggal
        if(!isset($bulan)) $bulan = date('m');
        if(!isset($tahun)) $tahun = date('Y');

        return PDF::loadView('pdf.demands', [
            'demands' => Order::with(['pegawai','product'])
                ->whereMonth('created_at', $bulan)
                ->whereYear('created_at', $tahun)
                ->get(),
            'bulan' => $bulan,
            'tahun' => $tahun,
            'months' => ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
        ])->stream();
    }

    public function pembelian($bulan = null, $tahun = null)
    {
        // tentukan tanggal
        if(!isset($bulan)) $bulan = date('m');
        if(!isset($tahun)) $tahun = date('Y');

        return PDF::loadView('pdf.purchases', [
            'purchases' => Purchase::with(['product'])
                ->whereMonth('created_at', $bulan)
                ->whereYear('created_at', $tahun)
                ->get(),
            'bulan' => $bulan,
            'tahun' => $tahun,
            'months' => ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
        ])->stream();
    }

    public function barangmasuk($bulan = null, $tahun = null)
    {
        // tentukan tanggal
        if(!isset($bulan)) $bulan = date('m');
        if(!isset($tahun)) $tahun = date('Y');

        return PDF::loadView('pdf.barangmasuk', [
            'wares' => IncomingWare::with(['product','penerima'])
                ->whereMonth('created_at', $bulan)
                ->whereYear('created_at', $tahun)
                ->get(),
            'bulan' => $bulan,
            'tahun' => $tahun,
            'months' => ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
        ])->stream();
    }
}
