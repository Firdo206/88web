<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Order;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            ->when($request->asal,   fn ($q) => $q->where('asal',   $request->asal))
            ->when($request->tujuan, fn ($q) => $q->where('tujuan', $request->tujuan))
            ->latest()->get();

        $kotaList = Bus::where('status', 'Aktif')
            ->selectRaw('DISTINCT asal as kota')->pluck('kota')
            ->merge(Bus::where('status', 'Aktif')->selectRaw('DISTINCT tujuan as kota')->pluck('kota'))
            ->unique()->sort()->values();

        return view('user.bus', compact('buses', 'kotaList'));
    }

    /*
    |--------------------------------------------------------------------------
    | Simpan pesanan + promo + metode bayar
    |--------------------------------------------------------------------------
    */
    public function orderStore(Request $request)
    {
        $validated = $request->validate([
            'bus_id'            => 'required|exists:buses,id',
            'nama_penumpang'    => 'required|string|max:255',
            'telepon'           => 'nullable|string|max:20',
            'tanggal_berangkat' => 'required|date|after_or_equal:today',
            'jumlah_kursi'      => 'required|integer|min:1|max:10',
            'metode_bayar'      => 'required|in:transfer,cod',
            'kode_promo'        => 'nullable|string|max:50',
            'catatan'           => 'nullable|string',
        ]);

        $bus      = Bus::findOrFail($validated['bus_id']);
        $subtotal = $bus->harga * $validated['jumlah_kursi'];

        // Hitung diskon jika ada kode promo valid
        $diskon      = 0;
        $namaPromo   = null;
        $kodePromo   = strtoupper(trim($validated['kode_promo'] ?? ''));

        if ($kodePromo) {
            $promo = Promo::where('kode', $kodePromo)
                ->where('status', 'Aktif')
                ->where('berlaku_hingga', '>=', now()->toDateString())
                ->first();

            if ($promo) {
                $diskon    = floor($subtotal * $promo->diskon / 100);
                $namaPromo = $promo->nama . ' (' . $promo->diskon . '%)';
            }
        }

        $total_harga  = $subtotal - $diskon;
        $status_bayar = $validated['metode_bayar'] === 'cod' ? 'cod_pending' : 'belum_bayar';

        $catatan = $validated['catatan'] ?? '';
        if ($namaPromo) {
            $catatan = trim("Promo: {$namaPromo}. " . $catatan);
        }

        $order = Order::create([
            'bus_id'            => $validated['bus_id'],
            'user_id'           => auth()->id(),
            'nama_penumpang'    => $validated['nama_penumpang'],
            'telepon'           => $validated['telepon'] ?? null,
            'tanggal_berangkat' => $validated['tanggal_berangkat'],
            'jumlah_kursi'      => $validated['jumlah_kursi'],
            'total_harga'       => $total_harga,
            'status'            => 'pending',
            'metode_bayar'      => $validated['metode_bayar'],
            'status_bayar'      => $status_bayar,
            'catatan'           => $catatan ?: null,
        ]);

        if ($validated['metode_bayar'] === 'transfer') {
            return redirect()->route('user.payment', $order)
                ->with('success', 'Pesanan berhasil! Silakan upload bukti transfer.');
        }

        return redirect()->route('user.pesanan')
            ->with('success', "Pesanan {$order->kode_order} berhasil! Bayar ke kondektur saat berangkat.");
    }

    /*
    |--------------------------------------------------------------------------
    | Halaman upload bukti transfer (USER ONLY)
    |--------------------------------------------------------------------------
    */
    public function payment(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        abort_if($order->metode_bayar !== 'transfer', 404);
        return view('user.payment', compact('order'));
    }

    /*
    |--------------------------------------------------------------------------
    | Upload bukti transfer
    |--------------------------------------------------------------------------
    */
    public function uploadBukti(Request $request, Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        $request->validate([
            'bukti_transfer' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:3072'],
        ], [
            'bukti_transfer.required' => 'Bukti transfer wajib diupload.',
            'bukti_transfer.mimes'    => 'Format file harus JPG, PNG, atau PDF.',
            'bukti_transfer.max'      => 'Ukuran file maksimal 3MB.',
        ]);

        if ($order->bukti_transfer) {
            Storage::disk('public')->delete($order->bukti_transfer);
        }

        $path = $request->file('bukti_transfer')->store('bukti_transfer', 'public');

        $order->update([
            'bukti_transfer'    => $path,
            'bukti_uploaded_at' => now(),
            'status_bayar'      => 'menunggu_verifikasi',
        ]);

        return redirect()->route('user.pesanan')
            ->with('success', "Bukti transfer {$order->kode_order} dikirim! Admin akan memverifikasi.");
    }

    /*
|--------------------------------------------------------------------------
| Lihat bukti transfer (USER ONLY)
|--------------------------------------------------------------------------
*/
public function showBukti(Order $order)
{
    // Pastikan hanya pemilik order yang bisa lihat
    abort_if($order->user_id !== auth()->id(), 403);

    // Jika belum ada file
    abort_if(!$order->bukti_transfer, 404);

    // Tampilkan file
    return response()->file(
        storage_path('app/public/' . $order->bukti_transfer)
    );
}

    public function pesanan()
    {
        $orders = Order::with('bus')
            ->where('user_id', auth()->id())
            ->latest()->get();
        return view('user.pesanan', compact('orders'));
    }

    public function riwayat()
    {
        $orders = Order::with('bus')
            ->where('user_id', auth()->id())
            ->whereIn('status', ['confirmed', 'completed', 'cancelled'])
            ->latest()->get();
        return view('user.riwayat', compact('orders'));
    }
}