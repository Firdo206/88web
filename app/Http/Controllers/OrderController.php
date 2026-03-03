<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        $orders = Order::with(['bus', 'user'])
            ->when($status !== 'all', fn ($q) => $q->where('status', $status))
            ->latest()
            ->get();

        $pendingCount = Order::where('status', 'pending')->count();

        return view('admin.orders.index', compact('orders', 'status', 'pendingCount'));
    }

    public function show(Order $order)
    {
        $order->load(['bus', 'user']);

        return view('admin.orders.show', compact('order'));
    }

    public function confirm(Order $order)
    {
        if ($order->status !== 'pending') {
            return back()->with('error', 'Hanya pesanan berstatus pending yang bisa dikonfirmasi.');
        }

        $order->update([
            'status'       => 'confirmed',
            'confirmed_at' => now(),
        ]);

        return redirect()->route('admin.orders.index')
            ->with('success', "Pesanan {$order->kode_order} berhasil dikonfirmasi!");
    }

    public function cancel(Order $order)
    {
        if (! in_array($order->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'Pesanan ini tidak dapat dibatalkan.');
        }

        $order->update(['status' => 'cancelled']);

        return redirect()->route('admin.orders.index')
            ->with('success', "Pesanan {$order->kode_order} telah dibatalkan.");
    }

    public function complete(Order $order)
    {
        if ($order->status !== 'confirmed') {
            return back()->with('error', 'Hanya pesanan berstatus dikonfirmasi yang bisa diselesaikan.');
        }

        $order->update(['status' => 'completed']);

        return redirect()->route('admin.orders.index')
            ->with('success', "Pesanan {$order->kode_order} ditandai selesai!");
    }

    public function history()
    {
        $orders = Order::with(['bus', 'user'])
            ->whereIn('status', ['confirmed', 'completed', 'cancelled'])
            ->latest()
            ->get();

        return view('admin.orders.history', compact('orders'));
    }
}