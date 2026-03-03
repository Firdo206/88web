<x-admin-layout title="Detail Pesanan" subtitle="{{ $order->kode_order }}">

    <div class="mb-4">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost btn-sm">← Kembali ke Pesanan</a>
    </div>

    <div class="grid-2">

        {{-- Detail Pesanan --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">🎫 Detail Pesanan</span>
                <span class="badge {{ $order->status_class }}">{{ $order->status_label }}</span>
            </div>
            <div class="card-body">
                <div style="display:grid; gap:18px">

                    @foreach([
                        ['Kode Pesanan',    $order->kode_order],
                        ['Nama Penumpang',  $order->nama_penumpang],
                        ['Telepon',         $order->telepon ?? '-'],
                        ['Tgl Berangkat',   $order->tanggal_berangkat->format('d M Y')],
                        ['Jumlah Kursi',    $order->jumlah_kursi . ' kursi'],
                        ['Total Harga',     $order->total_format],
                        ['Catatan',         $order->catatan ?? '-'],
                        ['Waktu Pesan',     $order->created_at->format('d M Y, H:i')],
                    ] as [$label, $val])
                    <div>
                        <div style="font-size:11px; font-weight:600; color:var(--text3);
                                    text-transform:uppercase; letter-spacing:.5px; margin-bottom:3px">
                            {{ $label }}
                        </div>
                        <div style="font-size:15px; font-weight:500">{{ $val }}</div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>

        <div>
            {{-- Info Bus --}}
            <div class="card mb-4">
                <div class="card-header">
                    <span class="card-title">🚌 Informasi Bus</span>
                </div>
                <div class="card-body">
                    <div style="display:flex; align-items:center; gap:14px; margin-bottom:16px">
                        <div style="font-size:42px">{{ $order->bus->emoji }}</div>
                        <div>
                            <div style="font-family:'Syne',sans-serif; font-weight:700; font-size:16px">
                                {{ $order->bus->nama }}
                            </div>
                            <div style="font-size:13px; color:var(--text2)">
                                📍 {{ $order->bus->asal }} → {{ $order->bus->tujuan }}
                            </div>
                            <div style="font-size:14px; color:var(--accent); font-weight:700; margin-top:2px">
                                {{ $order->bus->harga_format }} / kursi
                            </div>
                        </div>
                    </div>
                    <div style="font-size:13px; color:var(--text2)">
                        🕐 {{ $order->bus->jam_berangkat }}
                        &nbsp;|&nbsp; 💺 {{ $order->bus->kapasitas }} kursi
                        &nbsp;|&nbsp; 🏷️ {{ $order->bus->tipe }}
                    </div>
                    <div style="font-size:13px; color:var(--text2); margin-top:6px">
                        🎯 {{ $order->bus->fasilitas }}
                    </div>
                </div>
            </div>

            {{-- Aksi --}}
            <div class="card">
                <div class="card-header">
                    <span class="card-title">⚡ Aksi</span>
                </div>
                <div class="card-body" style="display:flex; flex-direction:column; gap:10px">

                    @if($order->status === 'pending')

                        <form method="POST" action="{{ route('admin.orders.confirm', $order) }}">
                            @csrf
                            <button type="submit" class="btn btn-success"
                                    style="width:100%; justify-content:center">
                                ✅ Konfirmasi Pesanan
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.orders.cancel', $order) }}"
                              onsubmit="return confirm('Yakin menolak pesanan ini?')">
                            @csrf
                            <button type="submit" class="btn btn-danger"
                                    style="width:100%; justify-content:center">
                                ❌ Tolak Pesanan
                            </button>
                        </form>

                    @elseif($order->status === 'confirmed')

                        <form method="POST" action="{{ route('admin.orders.complete', $order) }}">
                            @csrf
                            <button type="submit" class="btn btn-warning"
                                    style="width:100%; justify-content:center">
                                🏁 Tandai Selesai
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.orders.cancel', $order) }}"
                              onsubmit="return confirm('Batalkan pesanan ini?')">
                            @csrf
                            <button type="submit" class="btn btn-danger"
                                    style="width:100%; justify-content:center">
                                ❌ Batalkan Pesanan
                            </button>
                        </form>

                    @else

                        <div style="text-align:center; padding:16px; color:var(--text3); font-size:14px">
                            Pesanan sudah berstatus <strong>{{ $order->status_label }}</strong>.
                        </div>

                    @endif

                </div>
            </div>
        </div>

    </div>

</x-admin-layout>