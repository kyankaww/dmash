<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use Throwable;

class ProductController extends Controller
{
    public function index()
    {
        $data['title'] = 'Daftar Product';
        $data['category'] = DB::table('category')->get();
        $data['product'] = Product::all();
        $data['page'] = 'product';
        return view('pages.admin.product.index', $data);
    }

    public function create()
    {
        $data['page'] = 'product';
        $data['title'] = 'Tambah Product';
        return view('pages.admin.product.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name'=>'required',
            'img'=>'required|image|mimes:png,jpg,jpeg,svg',
            'category'=>'required',
            'price'=>'required',
            'stock'=>'required',
            'discount'=>'required',
            'desc'=>'required',
            'status'=>'required',
        ]);

        $fileName = time() . '.' . $request->img->extension();
     $request->img->move(storage_path('app/public/img'), $fileName);
        
        Product::create([
            'product_name' => $request->product_name,
            'img' => $fileName,
            'category_id' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
            'discount' => $request->discount,
            'desc' => $request->desc,
            'status' => $request->status,
        ]);
            
        return redirect('/product')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function show($id)
    {
        $data['title'] = 'Detail Product';
        $data['page'] = 'product';
        $data['product'] = Product::find($id);
        return view('pages.admin.product.show', $data);
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Product';
        $data['page'] = 'product';
        $data['category'] = DB::table('category')->get();
        $data['product'] = Product::find($id)->with('category')->first();
        return view('pages.admin.product.edit', $data);
    }

    public function update(Request $request, $id)
    {
        

        if ($request->img == null) {
            Product::where('id', $id)->update([
                'product_name' => $request->product_name,
                'category_id' => $request->category,
                'price' => $request->price,
                'stock' => $request->stock,
                'discount' => $request->discount,
                'desc' => $request->desc,
            ]);
        } else {
            $request->validate([
                'img'=>'required|image|mimes:png,jpg,jpeg,svg',
            ]);

            $imageName = time().'.'.$request->img->extension();
            $request->img->move(public_path('images'), $imageName);

            Product::where('id', $id)->update([
                'product_name' => $request->product_name,
                'img' => $imageName,
                'category_id' => $request->category,
                'price' => $request->price,
                'stock' => $request->stock,
                'discount' => $request->discount,
                'desc' => $request->desc,
            ]);
        }

        return redirect('/product')->with('success', 'Data Berhasil Diedit');
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            Product::find($id)->delete();
            DB::commit();
            return redirect('/product')->with('success', 'Data Berhasil Dihapus');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('ProductController destroy() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function tambahStock(Request $request)
    {
        $id = $request->brg_id;
        $stock = $request->stock;
        $product = Product::find($id);
        $product->stock = $product->stock + $stock;
        $product->save();
        return redirect('/product')->with('success', 'Stock Berhasil Ditambahkan');
    }
}
