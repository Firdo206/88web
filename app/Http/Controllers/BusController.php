<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::latest()->get();

        return view('admin.bus.index', compact('buses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'plat'          => 'nullable|string|max:20',
            'asal'          => 'required|string|max:100',
            'tujuan'        => 'required|string|max:100',
            'jam_berangkat' => 'required',
            'harga'         => 'required|integer|min:0',
            'kapasitas'     => 'required|integer|min:1',
            'tipe'          => 'required|in:Ekonomi,Eksekutif,Super Eksekutif,Sleeper',
            'fasilitas'     => 'nullable|string',
            'deskripsi'     => 'nullable|string',
            'promo'         => 'nullable|string|max:50',
            'status'        => 'required|in:Aktif,Tidak Aktif',
        ]);

        Bus::create($validated);

        return redirect()->route('admin.bus.index')
            ->with('success', "Bus \"{$validated['nama']}\" berhasil ditambahkan!");
    }

    public function update(Request $request, Bus $bus)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'plat'          => 'nullable|string|max:20',
            'asal'          => 'required|string|max:100',
            'tujuan'        => 'required|string|max:100',
            'jam_berangkat' => 'required',
            'harga'         => 'required|integer|min:0',
            'kapasitas'     => 'required|integer|min:1',
            'tipe'          => 'required|in:Ekonomi,Eksekutif,Super Eksekutif,Sleeper',
            'fasilitas'     => 'nullable|string',
            'deskripsi'     => 'nullable|string',
            'promo'         => 'nullable|string|max:50',
            'status'        => 'required|in:Aktif,Tidak Aktif',
        ]);

        $bus->update($validated);

        return redirect()->route('admin.bus.index')
            ->with('success', "Bus \"{$bus->nama}\" berhasil diperbarui!");
    }

    public function destroy(Bus $bus)
    {
        $nama = $bus->nama;
        $bus->delete();

        return redirect()->route('admin.bus.index')
            ->with('success', "Bus \"{$nama}\" berhasil dihapus!");
    }
}