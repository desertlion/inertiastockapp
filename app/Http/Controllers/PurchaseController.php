<?php

namespace App\Http\Controllers;

use App\Product;
use App\Purchase;
use App\Stock;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PurchaseController extends Controller
{
    public function index()
    {
        return Inertia::render('purchases/index', [
            'stocks' => Stock::with(['product'])->where('jumlah', '<', 11)->get(),
        ]);
    }

    public function create($product_id = null)
    {
        return Inertia::render('purchases/create', [
            'product_id' => isset($product_id) ? $product_id : null,
            'products' => Product::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'nama_toko' => 'required',
            'jumlah' => 'integer',
            'total_harga' => 'integer',
        ]);

        Purchase::create([
            'product_id' => $request->input('product_id'),
            'nama_toko' => $request->input('nama_toko'),
            'jumlah' => $request->input('jumlah'),
            'total_harga' => $request->input('total_harga'),
        ]);

        return redirect()->route('purchases.index');
    }
}
