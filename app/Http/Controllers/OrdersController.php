<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->input('search')):
            $product = Product::where('name','like','%'.$request->input('search').'%')->get(['id']);
            $orders = Order::with(['pegawai','product'])->whereIn('product_id', $product);
        else:
            $orders = Order::with(['pegawai', 'product']);
        endif;
        if(Auth::user()->division != 'rumah tangga'):
            $orders = $orders->where('user_id', Auth::user()->id)->get();
        else:
            $orders = $orders->get();
        endif;
        return Inertia::render('orders/index', [
            'orders' => $orders,
            'status' => ['processing', 'done']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('orders/create', [
            'users' => User::all(),
            'products' => Product::with('stock')
                ->whereHas('stock', function($q) {
                    $q->where('jumlah', '>', 0);
                })
                ->get(),
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
            'user_id' => 'required',
            'product_id' => 'required',
            'jumlah' => 'required|integer',
            'tanggal_permintaan' => 'required|date',
        ]);
        Order::create([
            'user_id' => $request->input('user_id'),
            'product_id' => $request->input('product_id'),
            'jumlah' => $request->input('jumlah'),
            'tanggal_permintaan' => $request->input('tanggal_permintaan'),
        ]);
        return redirect()->route('orders.index');
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
