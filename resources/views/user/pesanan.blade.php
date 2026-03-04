<x-user-layout title="Pesanan Saya">

    <div class="card">
        <div class="card-header">
            <div class="card-title">🎫 Pesanan Saya ({{ $orders->count() }})</div>
            <a href="{{ route('user.bus') }}" class="btn btn-primary btn-sm">+ Pesan Tiket</a>
        </div>

        @if($orders->isEmpty())
            <div class="empty-state" style="padding:48px">
                <div class="empty-state-icon">🎫</div>
                <div style="margin-bottom:12px">Belum ada pesanan</div>
                <a href="{{ route('user.bus') }}" class="btn btn-primary">🚌 Cari Bus Sekarang</a>
            </div>
        @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Bus / Rute</th>
                        <th>Tanggal</th>
                        <th>Kursi</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Dipesan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td><code style="color:var(--accent);font-size:12px">{{ $order->kode_order }}</code></td>
                        <td>
                            <div style="font-size:13px;font-weight:600">{{ $order->bus?->nama }}</div>
                            <div style="font-size:12px;color:var(--text3)">{{ $order->bus?->asal }} → {{ $order->bus?->tujuan }}</div>
                        </td>
                        <td style="font-size:13px">{{ $order->tanggal_berangkat->format('d M Y') }}</td>
                        <td style="font-size:13px;text-align:center">{{ $order->jumlah_kursi }}</td>
                        <td style="font-weight:700;color:var(--green);font-size:13px">{{ $order->total_format }}</td>
                        <td><span class="badge badge-{{ $order->status_class }}">{{ $order->status_label }}</span></td>
                        <td style="font-size:12px;color:var(--text3)">{{ $order->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</x-user-layout>