<?php

namespace App\Http\Controllers;

use App\Product;
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
}
