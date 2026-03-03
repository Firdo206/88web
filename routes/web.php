<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Redirect Root
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect()->route('login'));

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'showLogin']   )->name('login');
    Route::post('/login',    [AuthController::class, 'login']       )->name('login.post');
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']    )->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Admin  —  hanya bisa diakses role=admin
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        // Dashboard
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        // Manajemen Bus
        Route::get   ('bus',          [Admin\BusController::class, 'index'  ])->name('bus.index');
        Route::post  ('bus',          [Admin\BusController::class, 'store'  ])->name('bus.store');
        Route::put   ('bus/{bus}',    [Admin\BusController::class, 'update' ])->name('bus.update');
        Route::delete('bus/{bus}',    [Admin\BusController::class, 'destroy'])->name('bus.destroy');

        // Promo & Diskon
        Route::get   ('promo',          [Admin\PromoController::class, 'index'  ])->name('promo.index');
        Route::post  ('promo',          [Admin\PromoController::class, 'store'  ])->name('promo.store');
        Route::delete('promo/{promo}',  [Admin\PromoController::class, 'destroy'])->name('promo.destroy');

        // Pesanan
        Route::get ('orders',                    [Admin\OrderController::class, 'index'  ])->name('orders.index');
        Route::get ('orders/{order}',            [Admin\OrderController::class, 'show'   ])->name('orders.show');
        Route::post('orders/{order}/confirm',    [Admin\OrderController::class, 'confirm'])->name('orders.confirm');
        Route::post('orders/{order}/cancel',     [Admin\OrderController::class, 'cancel' ])->name('orders.cancel');
        Route::post('orders/{order}/complete',   [Admin\OrderController::class, 'complete'])->name('orders.complete');

        // Riwayat Pesanan
        Route::get('orders-history', [Admin\OrderController::class, 'history'])->name('orders.history');
    });

/*
|--------------------------------------------------------------------------
| User  —  pengguna yang sudah login
|--------------------------------------------------------------------------
*/
Route::prefix('dashboard')
    ->name('user.')
    ->middleware('auth')
    ->group(function () {

        Route::get ('/',        [User\DashboardController::class, 'index'     ])->name('dashboard');
        Route::get ('bus',      [User\DashboardController::class, 'busIndex'  ])->name('bus');
        Route::post('pesan',    [User\DashboardController::class, 'orderStore'])->name('order.store');
        Route::get ('pesanan',  [User\DashboardController::class, 'pesanan'   ])->name('pesanan');
        Route::get ('riwayat',  [User\DashboardController::class, 'riwayat'   ])->name('riwayat');
    });