<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['page'] = 'cart';
        $data['product'] = Product::all();
        return view('pages.admin.cart.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    static function store($id)
    {
        Cart::create([
            'user_id' => $id,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart, Request $request)
    {
        $a = Cart::where('user_id', Auth::user()->id)->first();
        $c = $a->products_id;
        if ($c == null) {
            Cart::where('user_id', Auth::user()->id)->update([
                'products_id' => [
                    'brg_id' => $request->brg_id,
                    'qty' => $request->qty,
                ],
            ]);
        } else {
            $b = $a->products_id;
            $n = json_decode($b);

            $data = [
                'brg_id' => $request->brg_id,
                'qty' => $request->qty,
            ];
            array_push($n, $data);
            Cart::where('user_id', Auth::user()->id)->update([
                'products_id' => $n,
            ]);
        }

        return redirect('/cart')->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
