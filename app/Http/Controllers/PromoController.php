<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::latest()->get();

        return view('admin.promo.index', compact('promos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'kode'          => 'required|string|max:50|unique:promos,kode',
            'diskon'        => 'required|integer|min:1|max:100',
            'berlaku_hingga'=> 'required|date',
            'deskripsi'     => 'nullable|string',
            'status'        => 'required|in:Aktif,Tidak Aktif',
        ]);

        Promo::create($validated);

        return redirect()->route('admin.promo.index')
            ->with('success', "Promo \"{$validated['nama']}\" berhasil ditambahkan!");
    }

    public function destroy(Promo $promo)
    {
        $nama = $promo->nama;
        $promo->delete();

        return redirect()->route('admin.promo.index')
            ->with('success', "Promo \"{$nama}\" berhasil dihapus!");
    }
}