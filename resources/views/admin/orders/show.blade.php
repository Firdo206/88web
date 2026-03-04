<x-admin-layout title="Detail Pesanan" subtitle="{{ $order->kode_order }}">

    <div class="grid-2">

        {{-- Info Pesanan --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">🧾 Info Pesanan</div>
                <span class="badge badge-{{ $order->status_class }}">{{ $order->status_label }}</span>
            </div>
            <div class="card-body">
                @foreach([
                    'Kode Pesanan'     => $order->kode_order,
                    'Nama Penumpang'   => $order->nama_penumpang,
                    'Telepon'          => $order->telepon ?? '-',
                    'Tanggal Berangkat'=> $order->tanggal_berangkat->format('d M Y'),
                    'Jumlah Kursi'     => $order->jumlah_kursi . ' kursi',
                    'Total Harga'      => $order->total_format,
                    'Dipesan Pada'     => $order->created_at->format('d M Y H:i'),
                ] as $label => $val)
                <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--border)">
                    <span style="font-size:13px;color:var(--text3)">{{ $label }}</span>
                    <span style="font-size:14px;font-weight:600">{{ $val }}</span>
                </div>
                @endforeach
                @if($order->catatan)
                <div style="margin-top:12px;padding:12px;background:var(--surface2);border-radius:10px;font-size:13px;color:var(--text2)">
                    <strong>Catatan:</strong> {{ $order->catatan }}
                </div>
                @endif
            </div>
        </div>

        {{-- Info Bus & User --}}
        <div style="display:flex;flex-direction:column;gap:16px">
            <div class="card">
                <div class="card-header"><div class="card-title">🚌 Info Bus</div></div>
                <div class="card-body">
                    @foreach([
                        'Nama Bus'   => $order->bus?->emoji . ' ' . $order->bus?->nama,
                        'Rute'       => ($order->bus?->asal ?? '-') . ' → ' . ($order->bus?->tujuan ?? '-'),
                        'Berangkat'  => \Carbon\Carbon::parse($order->bus?->jam_berangkat)->format('H:i') . ' WIB',
                        'Tipe'       => $order->bus?->tipe,
                        'Harga/Kursi'=> $order->bus?->harga_format,
                    ] as $label => $val)
                    <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border)">
                        <span style="font-size:13px;color:var(--text3)">{{ $label }}</span>
                        <span style="font-size:13px;font-weight:600">{{ $val }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="card">
                <div class="card-header"><div class="card-title">👤 Data Pemesan</div></div>
                <div class="card-body">
                    @foreach([
                        'Nama'  => $order->user?->name,
                        'Email' => $order->user?->email,
                    ] as $label => $val)
                    <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border)">
                        <span style="font-size:13px;color:var(--text3)">{{ $label }}</span>
                        <span style="font-size:13px;font-weight:600">{{ $val }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    {{-- Action Buttons --}}
    <div style="display:flex;gap:12px;margin-top:20px;flex-wrap:wrap">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost">← Kembali</a>

        @if($order->status === 'pending')
            <form method="POST" action="{{ route('admin.orders.confirm', $order) }}">
                @csrf
                <button class="btn btn-success">✅ Konfirmasi Pesanan</button>
            </form>
            <form method="POST" action="{{ route('admin.orders.cancel', $order) }}">
                @csrf
                <button class="btn btn-danger">❌ Batalkan Pesanan</button>
            </form>
        @elseif($order->status === 'confirmed')
            <form method="POST" action="{{ route('admin.orders.complete', $order) }}">
                @csrf
                <button class="btn btn-success">🏁 Tandai Selesai</button>
            </form>
            <form method="POST" action="{{ route('admin.orders.cancel', $order) }}">
                @csrf
                <button class="btn btn-danger">❌ Batalkan</button>
            </form>
        @endif
    </div>

</x-admin-layout>