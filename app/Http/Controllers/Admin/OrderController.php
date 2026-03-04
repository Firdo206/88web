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
            ->latest()->get();

        $pendingCount          = Order::where('status', 'pending')->count();
        $menungguVerifikasiCount = Order::where('status_bayar', 'menunggu_verifikasi')->count();

        return view('admin.orders.index', compact('orders', 'status', 'pendingCount', 'menungguVerifikasiCount'));
    }

    public function show(Order $order)
    {
        $order->load(['bus', 'user']);
        return view('admin.orders.show', compact('order'));
    }

    /*
    |--------------------------------------------------------------------------
    | Verifikasi pembayaran transfer
    |--------------------------------------------------------------------------
    */
    public function verifyPayment(Order $order)
    {
        if ($order->status_bayar !== 'menunggu_verifikasi') {
            return back()->with('error', 'Pembayaran ini tidak bisa diverifikasi.');
        }

        $order->update([
            'status_bayar' => 'lunas',
            'verified_at'  => now(),
        ]);

        return back()->with('success', "Pembayaran {$order->kode_order} telah diverifikasi ✅");
    }

    /*
    |--------------------------------------------------------------------------
    | Tolak bukti transfer (minta upload ulang)
    |--------------------------------------------------------------------------
    */
    public function rejectPayment(Request $request, Order $order)
    {
        $request->validate([
            'catatan_bayar' => 'required|string|max:255',
        ]);

        $order->update([
            'status_bayar'   => 'belum_bayar',
            'bukti_transfer' => null,
            'bukti_uploaded_at' => null,
            'catatan_bayar'  => $request->catatan_bayar,
        ]);

        return back()->with('success', "Bukti transfer ditolak. User diminta upload ulang.");
    }

    /*
    |--------------------------------------------------------------------------
    | Verifikasi COD (admin tandai sudah bayar di tempat)
    |--------------------------------------------------------------------------
    */
    public function verifyCod(Order $order)
    {
        if ($order->metode_bayar !== 'cod') {
            return back()->with('error', 'Pesanan ini bukan COD.');
        }

        $order->update([
            'status_bayar' => 'lunas',
            'verified_at'  => now(),
        ]);

        return back()->with('success', "Pembayaran COD {$order->kode_order} dikonfirmasi lunas ✅");
    }

    /*
    |--------------------------------------------------------------------------
    | Konfirmasi pesanan (setelah pembayaran lunas)
    |--------------------------------------------------------------------------
    */
    public function confirm(Order $order)
    {
        if ($order->status !== 'pending') {
            return back()->with('error', 'Hanya pesanan pending yang bisa dikonfirmasi.');
        }

        if (!in_array($order->status_bayar, ['lunas', 'cod_pending'])) {
            return back()->with('error', 'Pesanan belum lunas. Verifikasi pembayaran dulu.');
        }

        $order->update([
            'status'       => 'confirmed',
            'confirmed_at' => now(),
        ]);

        return back()->with('success', "Pesanan {$order->kode_order} dikonfirmasi!");
    }

    public function cancel(Order $order)
    {
        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'Pesanan ini tidak dapat dibatalkan.');
        }

        $order->update(['status' => 'cancelled']);

        return back()->with('success', "Pesanan {$order->kode_order} dibatalkan.");
    }

    public function complete(Order $order)
    {
        if ($order->status !== 'confirmed') {
            return back()->with('error', 'Hanya pesanan confirmed yang bisa diselesaikan.');
        }

        $order->update(['status' => 'completed']);

        return back()->with('success', "Pesanan {$order->kode_order} selesai!");
    }

    public function history()
    {
        $orders = Order::with(['bus', 'user'])
            ->whereIn('status', ['confirmed', 'completed', 'cancelled'])
            ->latest()->get();

        return view('admin.orders.history', compact('orders'));
    }
}