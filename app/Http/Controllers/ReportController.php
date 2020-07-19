<?php

namespace App\Http\Controllers;

use App\IncomingWare;
use App\Order;
use App\Product;
use App\Purchase;
use App\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function __construct()
    {
        Carbon::setLocale('id');
    }
    public function index()
    {
        return Inertia::render('reports/index');
    }

    public function stock($bulan = null, $tahun = null)
    {
        // tentukan periode
        if(!isset($bulan)) $bulan = date('m');
        if(!isset($tahun)) $tahun = date('Y');

        return Inertia::render('reports/persediaan-barang', [
            'products' => Product::all(['id','name']),
            'incomings' => DB::table('incoming_wares')
                // ->leftjoin('products','products.id','=','incoming_wares.product_id')
                ->select('product_id','jumlah_sebelum', DB::raw('SUM(jumlah) as jlh_total'))
                ->whereMonth('incoming_wares.created_at', $bulan)
                ->whereYear('incoming_wares.created_at', $tahun)
                // ->whereRaw("created_at BETWEEN CAST('2020-07-01' AS DATE) AND CAST('2020-07-31' AS DATE)")
                ->groupBy('product_id')
                ->orderBy('product_id')
                ->orderBy('created_at', 'asc')
                ->get(),
            'outgoings' => DB::table('orders')
                // ->leftjoin('orders','orders.id','=','deliveries.order_id')
                ->select('product_id', DB::raw('SUM(jumlah) as jlh_total'))
                // ->whereRaw("status > 0 AND created_at BETWEEN CAST('2020-07-01' AS DATE) AND CAST('2020-07-31' AS DATE)")
                ->where('status', '>', 0)
                ->whereMonth('orders.created_at', $bulan)
                ->whereYear('orders.created_at', $tahun)
                ->groupBy('product_id')
                ->orderBy('product_id')
                ->orderBy('created_at', 'asc')
                ->get(),
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);
    }

    public function demands($bulan = null, $tahun = null)
    {
        // tentukan tanggal
        if(!isset($bulan)) $bulan = date('m');
        if(!isset($tahun)) $tahun = date('Y');

        return Inertia::render('reports/demands', [
            'demands' => Order::with(['pegawai','product'])
                ->whereMonth('created_at', $bulan)
                ->whereYear('created_at', $tahun)
                ->get(),
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);
    }

    public function pembelian($bulan = null, $tahun = null)
    {
        // tentukan tanggal
        if(!isset($bulan)) $bulan = date('m');
        if(!isset($tahun)) $tahun = date('Y');

        return Inertia::render('reports/purchases', [
            'purchases' => Purchase::with(['product'])
                ->whereMonth('created_at', $bulan)
                ->whereYear('created_at', $tahun)
                ->get(),
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);
    }

    public function barangmasuk($bulan = null, $tahun = null)
    {
        // tentukan tanggal
        if(!isset($bulan)) $bulan = date('m');
        if(!isset($tahun)) $tahun = date('Y');

        return Inertia::render('reports/barangmasuk', [
            'wares' => IncomingWare::with(['product','penerima'])
                ->whereMonth('created_at', $bulan)
                ->whereYear('created_at', $tahun)
                ->get(),
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);
    }
}
