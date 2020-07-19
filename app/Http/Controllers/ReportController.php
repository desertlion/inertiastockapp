<?php

namespace App\Http\Controllers;

use App\Product;
use App\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function index()
    {
        return Inertia::render('reports/index');
    }

    public function stock($start_date = null, $end_date = null)
    {
        $start = isset($start_date) ? $start_date : date('Y').'-'.date('m').'-01';
        $end = isset($end_date) ? $end_date : date('Y').'-'.date('m').'-'.Carbon::now()->endOfMonth()->format('d');
        return Inertia::render('reports/persediaan-barang', [
            'products' => Product::all(['id','name']),
            'incomings' => DB::table('incoming_wares')
                // ->leftjoin('products','products.id','=','incoming_wares.product_id')
                ->select('product_id','jumlah_sebelum', DB::raw('SUM(jumlah) as jlh_total'))
                ->whereRaw("created_at BETWEEN CAST('2020-07-01' AS DATE) AND CAST('2020-07-31' AS DATE)")
                ->groupBy('product_id')
                ->orderBy('product_id')
                ->orderBy('created_at', 'asc')
                ->get(),
            'outgoings' => DB::table('orders')
                // ->leftjoin('orders','orders.id','=','deliveries.order_id')
                ->select('product_id', DB::raw('SUM(jumlah) as jlh_total'))
                ->whereRaw("status > 0 AND created_at BETWEEN CAST('2020-07-01' AS DATE) AND CAST('2020-07-31' AS DATE)")
                ->groupBy('product_id')
                ->orderBy('product_id')
                ->orderBy('created_at', 'asc')
                ->get(),
            'start_date' => $start,
            'end_date' => $end,
        ]);
    }
}
