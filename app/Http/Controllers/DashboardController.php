<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $page = 'dashboard';
        return view('pages.admin.dashboard', compact('page'));
    }

    public function login()
    {
        return view('login');
    }

    public function auth(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $user = $request->only('username', 'password');
        if (Auth::attempt($user)) {
            if (Auth::user()->role == 'admin') {
                return redirect('/dashboard');
            } else {
                return redirect('/');
            }
        } else {
            return redirect()->back()->withInput($request->only('username'))->with('error', 'Invalid credentials');
        }
    }
}
