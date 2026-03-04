<x-admin-layout title="Riwayat Pesanan">

    <div class="card">
        <div class="card-header">
            <div class="card-title">📋 Semua Riwayat Pesanan ({{ $orders->count() }})</div>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Penumpang</th>
                        <th>Bus / Rute</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td><code style="color:var(--accent);font-size:12px">{{ $order->kode_order }}</code></td>
                        <td>
                            <div style="font-weight:600;font-size:14px">{{ $order->nama_penumpang }}</div>
                            <div style="font-size:12px;color:var(--text3)">{{ $order->user?->name }}</div>
                        </td>
                        <td>
                            <div style="font-size:13px;font-weight:500">{{ $order->bus?->nama }}</div>
                            <div style="font-size:12px;color:var(--text3)">{{ $order->bus?->asal }} → {{ $order->bus?->tujuan }}</div>
                        </td>
                        <td style="font-size:13px">{{ $order->tanggal_berangkat->format('d M Y') }}</td>
                        <td style="font-weight:700;color:var(--green);font-size:13px">{{ $order->total_format }}</td>
                        <td><span class="badge badge-{{ $order->status_class }}">{{ $order->status_label }}</span></td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-ghost btn-sm">👁️ Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7">
                        <div class="empty-state">
                            <div class="empty-state-icon">📋</div>
                            <div>Belum ada riwayat pesanan</div>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-admin-layout>