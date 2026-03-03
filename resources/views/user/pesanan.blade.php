<x-user-layout title="Pesanan Saya" subtitle="Tiket Saya">

    <h2 style="font-family:'Syne',sans-serif; font-size:20px; font-weight:800; margin-bottom:20px">
        Pesanan Saya
    </h2>

    {{-- Tab Filter --}}
    <div class="tabs">
        @foreach([
            'all'       => 'Semua',
            'pending'   => 'Menunggu',
            'confirmed' => 'Dikonfirmasi',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ] as $val => $label)
        <a href="{{ route('user.pesanan', ['status' => $val]) }}"
           class="tab {{ request('status', 'all') === $val ? 'active' : '' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    {{-- Filter in controller via query string --}}
    @php
        $currentStatus = request('status', 'all');
        $filtered = $currentStatus === 'all'
            ? $orders
            : $orders->where('status', $currentStatus);
    @endphp

    @if($filtered->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">🎫</div>
            <p>Belum ada pesanan di kategori ini.</p>
            <a href="{{ route('user.bus') }}" class="btn btn-primary" style="margin-top:16px">
                Pesan Sekarang
            </a>
        </div>
    @else
        @foreach($filtered as $order)
        <div class="card mb-4">
            <div class="card-header">
                <div>
                    <div style="font-family:'Syne',sans-serif; font-weight:700; font-size:15px">
                        {{ $order->bus->nama }}
                    </div>
                    <div style="font-size:13px; color:var(--text2); margin-top:2px">
                        📍 {{ $order->bus->asal }} → {{ $order->bus->tujuan }}
                        &nbsp;|&nbsp;
                        📅 {{ $order->tanggal_berangkat->format('d M Y') }}
                    </div>
                </div>
                <div style="display:flex; align-items:center; gap:10px">
                    <span class="badge {{ $order->status_class }}">{{ $order->status_label }}</span>
                    <span style="font-family:'Syne',sans-serif; font-weight:800; color:var(--green)">
                        {{ $order->total_format }}
                    </span>
                </div>
            </div>
            <div class="card-body"
                 style="padding:14px 22px; display:flex; align-items:center; justify-content:space-between">
                <div style="font-size:13px; color:var(--text2)">
                    ID: <strong style="color:var(--accent)">{{ $order->kode_order }}</strong>
                    &nbsp;|&nbsp; {{ $order->jumlah_kursi }} kursi
                    &nbsp;|&nbsp; Dipesan: {{ $order->created_at->format('d M Y, H:i') }}
                </div>
                <div style="font-size:13px">
                    @if($order->status === 'pending')
                        <span style="color:var(--yellow)">⏳ Menunggu konfirmasi admin</span>
                    @elseif($order->status === 'confirmed')
                        <span style="color:var(--green)">✅ Tiket sudah dikonfirmasi</span>
                    @elseif($order->status === 'completed')
                        <span style="color:var(--blue)">🏁 Perjalanan selesai</span>
                    @elseif($order->status === 'cancelled')
                        <span style="color:var(--red)">❌ Pesanan dibatalkan</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    @endif

</x-user-layout>