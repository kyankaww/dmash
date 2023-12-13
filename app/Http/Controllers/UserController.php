<?php

namespace App\Http\Controllers;

use App\Models\EvidancePayment;
use App\Models\MethodPayment;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserController extends Controller
{
    public function index()
    {
        $data['title'] = 'Daftar User';
        $data['user'] = User::all();
        $data['page'] = 'user';
        return view('pages.admin.user.index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah User';
        $data['page'] = 'user';
        return view('pages.admin.user.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik'     => 'required',
            'fullname'    => 'required',
            'email' => 'required',
            'no_hp' => 'required'
        ]);

        $data = User::create([
            'nik' => $request->nik,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'username' => $request->email,
            'password' => Hash::make($request->nik),
            'role' => 'user'
        ]);
        $id = $data->id;
        CartController::store($id);

        return redirect('/user')->with('success', 'Data Berhasil Ditambahkan');
    }
    
    public function show($id)
    {
        $data['title'] = 'Detail User';
        $data['page'] = 'user';
        $data['user'] = User::find($id);
        return view('pages.admin.user.show', $data);
    }
    
    public function edit($id)
    {
        $data['title'] = 'Edit User';
        $data['page'] = 'user';
        $data['user'] = User::find($id);
        return view('pages.admin.user.edit', $data);
    }
    
    public function update(Request $request, $id)
    {
        User::where('id', $id)->update([
            'nik' => $request->nik,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'username' => $request->email,
            'password' => Hash::make($request->nik),
        ]);
        return redirect('/user')->with('success', 'Data Berhasil Diedit');
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            User::find($id)->delete();
            DB::commit();
            return redirect()->route('pages.admin.user.index')->with('success', 'Data Berhasil Dihapus');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('UserController destroy() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }


    public function dashboard()
    {
        $data['product'] = Product::all();
        return view('pages.user.dashboard', $data);
    }

    public function profile()
    {
        $data['user'] = User::find(Auth::user()->id);
        $data['order'] = Order::where('user_id', Auth::user()->id)->get();
        $data['method'] = MethodPayment::all();
        return view('pages.user.profile', $data);
    }

    public function orderUpdate(Request $request)
    {
        $order = Order::where('id', $request->id)->first();
        $order->update([
            'payment_method' => $request->payment_method,
            'status' => 'pay',
        ]);
        return redirect()->back()->with('success', 'Data Berhasil Diedit');
    }

    public function payment(Request $request)
    {
        $request->validate([
            'evidance'=>'required|image|mimes:png,jpg,jpeg,svg',
        ]);
        $imageName = time().'.'.$request->evidance->extension();
        $request->evidance->move(public_path('evidance'), $imageName);
        EvidancePayment::create([
            'user_id' => auth()->user()->id,
            'order_id' => $request->id,
            'evidance' => $imageName,
        ]);
        $order = Order::where('id', $request->id)->first();
        $order->update([
            'status' => 'waiting',
        ]);
        return redirect()->back()->with('success', 'Data Berhasil Diedit');
    }
}
