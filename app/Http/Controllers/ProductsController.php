<?php

namespace App\Http\Controllers;

use App\IncomingWare;
use App\Product;
use App\Stock;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = $request->input('search')
            ? Product::with(['stock'])->where('name','like','%'.$request->input('search').'%')->get()
            : Product::with(['stock'])->get();
        return Inertia::render('products/index', [
            'filters' => $request->all('search'),
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('products/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'satuan' => 'required',
        ]);
        DB::transaction(function () use ($request) {
            $product = Product::create([
                'name' => $request->input('name'),
                'satuan' => $request->input('satuan'),
            ]);
            Stock::create(['product_id' => $product->id, 'jumlah' => 0, 'total' => 0]);
        });

        return Redirect::route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Inertia::render('products/edit', [
            'product' => Product::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required', 'satuan' => 'required']);
        $product = Product::find($id);
        $product->name = $request->input('name');
        $product->satuan = $request->input('satuan');
        $product->save();
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $incoming = IncomingWare::where('product_id', $id)->first();
        if($incoming == null):
            Product::destroy($id);
            Stock::where('product_id', $id)->destroy();
            return redirect()->back()->with('success', 'Barang berhasil dihapus');
        endif;
        return redirect()->route('products.index')->with('error', 'Tidak bisa menghapus barang, sudah ada transaksi untuk barang ini');
    }

}
