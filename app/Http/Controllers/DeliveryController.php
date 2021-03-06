<?php

namespace App\Http\Controllers;

use App\Delivery;
use App\Order;
use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('deliveries/index', [
            'filters' => $request->all('search'),
            'deliveries' => Delivery::with(['order'])->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // pastikan dulu ada itu input order
        $order = Order::find($request->input('order_id'));
        if(!$order) return redirect()->back()->with('error', 'Nomor Permintaan tidak ditemukan');

        $stock = Stock::where('product_id', $order->product_id)->first();
        if($stock->jumlah - $order->jumlah < 0):
            return redirect()->back()->with('error', 'Stock barang tidak mencukupi!');
        endif;

        return Inertia::render('deliveries/create', [
            'order_id' => $request->input('order_id'),
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
            'order_id' => 'required',
            'tanggal_penyerahan' => 'date',
        ]);

        // pastikan dulu ada itu input order
        $order = Order::find($request->input('order_id'));
        if(!$order) return redirect()->back();

        $stock = Stock::where('product_id', $order->product_id)->first();
        if($stock->jumlah - $order->jumlah < 0):
            return redirect()->back()->with('error', 'Stock barang tidak mencukupi!');
        endif;

        DB::transaction(function () use ($request, $order, $stock) {
            Delivery::create([
                'order_id' => $request->input('order_id'),
                'tanggal_penyerahan' => $request->input('tanggal_penyerahan'),
            ]);
            // Ubah Status Permintaan dari Processing menjadi done
            $order->status = '1';
            $order->save();
            // Kurangi jumlah stock
            $stock->jumlah = (int) $stock->jumlah - (int) $order->jumlah;
            $stock->total = $stock->total;
            $stock->save();
        });
        return redirect()->route('deliveries.index');
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
