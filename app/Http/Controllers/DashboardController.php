<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Order;
use App\Models\Promo;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $buses       = Bus::where('status', 'Aktif')->latest()->take(6)->get();
        $activePromo = Promo::where('status', 'Aktif')
            ->where('berlaku_hingga', '>=', now())
            ->first();

        return view('user.dashboard', compact('buses', 'activePromo'));
    }

    public function busIndex(Request $request)
    {
        $buses = Bus::where('status', 'Aktif')
            ->when($request->asal,   fn ($q) => $q->where('asal', $request->asal))
            ->when($request->tujuan, fn ($q) => $q->where('tujuan', $request->tujuan))
            ->latest()
            ->get();

        $kotaList = Bus::where('status', 'Aktif')
            ->selectRaw('DISTINCT asal as kota')->pluck('kota')
            ->merge(
                Bus::where('status', 'Aktif')->selectRaw('DISTINCT tujuan as kota')->pluck('kota')
            )
            ->unique()->sort()->values();

        return view('user.bus', compact('buses', 'kotaList'));
    }

    public function orderStore(Request $request)
    {
        $validated = $request->validate([
            'bus_id'            => 'required|exists:buses,id',
            'nama_penumpang'    => 'required|string|max:255',
            'telepon'           => 'nullable|string|max:20',
            'tanggal_berangkat' => 'required|date|after_or_equal:today',
            'jumlah_kursi'      => 'required|integer|min:1|max:10',
            'catatan'           => 'nullable|string',
        ]);

        $bus         = Bus::findOrFail($validated['bus_id']);
        $total_harga = $bus->harga * $validated['jumlah_kursi'];

        $order = Order::create([
            ...$validated,
            'user_id'     => auth()->id(),
            'total_harga' => $total_harga,
            'status'      => 'pending',
        ]);

        return redirect()->route('user.pesanan')
            ->with('success', "Tiket berhasil dipesan! ID: {$order->kode_order}. Menunggu konfirmasi admin.");
    }

    public function pesanan(Request $request)
    {
        $orders = Order::with('bus')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.pesanan', compact('orders'));
    }

    public function riwayat()
    {
        $orders = Order::with('bus')
            ->where('user_id', auth()->id())
            ->whereIn('status', ['confirmed', 'completed', 'cancelled'])
            ->latest()
            ->get();

        return view('user.riwayat', compact('orders'));
    }
}