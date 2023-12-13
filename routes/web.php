<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//dashboard

// //Cart
// Route::get('/cart', [CartController::class, 'index'])->name('cart');
// Route::post('/cart', [CartController::class, 'edit'])->name('cart.store');

//Order
Route::post('/order', [OrderController::class, 'store']);

//auth

Route::middleware('isGuest')->group(function () {
    Route::get('/login', [DashboardController::class, 'login'])->name('login');
    Route::post('/auth', [DashboardController::class, 'auth'])->name('auth');
});

Route::middleware(['isLogin', 'cekRole:admin,user'])->group(function () {
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/', [UserController::class, 'dashboard']);
    Route::get('/profile', [UserController::class, 'profile']);
    Route::post('/order-update', [UserController::class, 'orderUpdate']);
    Route::post('/payy', [UserController::class, 'payment']);
    Route::get('/payment', [OrderController::class, 'payment']);
    Route::delete('/order/{id}', [OrderController::class, 'destroy']);
});

Route::middleware(['isLogin', 'cekRole:admin'])->group(function () {
    Route::resources([
        'category' => CategoryController::class,
    ]);
    Route::resources([
        'user' => UserController::class,
    ]);
    Route::resources([
        'product' => ProductController::class,
    ]);
    Route::post('/tambah-stock', [ProductController::class, 'tambahStock'])->name('tambah-stock');
    Route::get('/dashboard', [DashboardController::class, 'dashboard']);
    Route::get('/order', [OrderController::class, 'index']) ;
    Route::post('/approve', [OrderController::class, 'approve']);
});
