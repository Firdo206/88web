<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;

class PromoApiController extends Controller
{
    /**
     * Cek kode promo via AJAX
     * GET /api/promo/cek?kode=XXXX
     */
    public function cek(Request $request)
    {
        $kode = strtoupper(trim($request->kode ?? ''));

        if (!$kode) {
            return response()->json(['valid' => false, 'message' => 'Kode promo kosong.']);
        }

        $promo = Promo::where('kode', $kode)
            ->where('status', 'Aktif')
            ->where('berlaku_hingga', '>=', now()->toDateString())
            ->first();

        if (!$promo) {
            return response()->json([
                'valid'   => false,
                'message' => 'Kode promo tidak ditemukan atau sudah kedaluwarsa.',
            ]);
        }

        return response()->json([
            'valid'  => true,
            'diskon' => $promo->diskon,
            'nama'   => $promo->nama,
        ]);
    }
}