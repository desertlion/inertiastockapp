<?php

namespace App\Http\Controllers;

use App\IncomingWare;
use App\Product;
use App\Stock;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class IncomingWaresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('incomingwares/index', [
            'wares' => IncomingWare::with(['product','penerima'])->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('incomingwares/create', [
            'products' => Product::all(),
            'users' => User::all(),
        ]);
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
            'product_id' => 'required',
            'jumlah' => 'required|integer',
            'tanggal_masuk' => 'required|date',
            'nama_toko' => 'required',
            'penerima' => 'required'
        ]);
        DB::transaction(function () use ($request) {
            IncomingWare::create([
                'product_id' => (int) $request->input('product_id'),
                'jumlah' => (int) $request->input('jumlah'),
                'tanggal_masuk' => $request->input('tanggal_masuk'),
                'nama_toko' => $request->input('nama_toko'),
                'penerima' => $request->input('penerima'),
            ]);
            $stock = Stock::where('product_id', $request->input('product_id'))->first();
            $stock->total = $stock->total + $request->input('jumlah');
            $stock->save();
        });

        return redirect()->route('incomingwares.index');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
