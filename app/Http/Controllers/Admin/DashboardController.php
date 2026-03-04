<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Order;
use App\Models\Promo;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBus       = Bus::count();
        $totalPesanan   = Order::count();
        $pendingPesanan = Order::where('status', 'pending')->count();
        $pendapatan     = Order::whereIn('status', ['confirmed', 'completed'])->sum('total_harga');
        $recentOrders   = Order::with('bus')->latest()->take(5)->get();
        $popularBus     = Bus::withCount('orders')->orderByDesc('orders_count')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalBus',
            'totalPesanan',
            'pendingPesanan',
            'pendapatan',
            'recentOrders',
            'popularBus'
        ));
    }
}