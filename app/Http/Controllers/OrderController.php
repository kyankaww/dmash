<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['page'] = 'order';
        $data['product'] = Product::all();
        $data['order'] = Order::with('product')->get();
        return view('pages.admin.order.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $order = Order::where('products_id', $request->products_id)->where('user_id', Auth::user()->id)->first();
        if($order && $order->status == 'pening') {
            $order->update([
                'qty' => $order->qty + $request->qty,
            ]);
        } else {
            Order::create([
                'user_id' => auth()->user()->id,
                'products_id' => $request->products_id,
                'qty' => $request->qty,
            ]);
        }
        $product = Product::where('id', $request->products_id)->first();
        $product->update([
            'stock' => $product->stock - $request->qty,
        ]);
        
        return redirect()->back()->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $order = Order::where('id', $id)->first();
        $product = Product::where('id', $order->products_id)->first();
        $product->update([
            'stock' => $product->stock + $order->qty,
        ]);
        $order->delete();
        return redirect()->back()->with('success', 'Data Berhasil Dihapus');
    }

    public function payment(Request $request)
    {
       $data['order'] = Order::where('status', 'waiting')->with('methodPayment')->get();
       $data['page'] = 'payment';
       return view('pages.admin.payment.index', $data);
    }

    public function approve(Request $request)
    {
        // dd($request->all());
        $order = Order::where('id', $request->id)->first();
        if ($request->status == 'terima') {
            $order->update([
                'status' => $request->status,
            ]);
            return redirect()->back()->with('success', 'Data Berhasil Diupdate');
        } else {
            $order->update([
                'status' => $request->status,
            ]);
            $product = Product::where('id', $order->products_id)->first();
            $product->update([
                'stock' => $product->stock + $order->qty,
            ]);
            return redirect()->back()->with('success', 'Data Berhasil Diupdate');
        }
        return redirect()->back()->with('success', 'Data Berhasil Diupdate');
    }
}
