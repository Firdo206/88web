<x-admin-layout title="Riwayat Pesanan" subtitle="Semua Riwayat">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 style="font-family:'Syne',sans-serif; font-size:20px; font-weight:800">Riwayat Pesanan</h2>
            <p class="text-muted text-sm" style="margin-top:4px">
                Semua pesanan yang telah dikonfirmasi, selesai, atau dibatalkan
            </p>
        </div>
        <span style="font-size:13px; color:var(--text3)">
            Total: {{ $orders->count() }} pesanan
        </span>
    </div>

    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#Kode</th>
                        <th>Penumpang</th>
                        <th>Bus</th>
                        <th>Rute</th>
                        <th>Tgl Perjalanan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>
                            <span style="font-family:'Syne',sans-serif; font-weight:700; color:var(--accent)">
                                {{ $order->kode_order }}
                            </span>
                        </td>
                        <td>
                            <div style="font-weight:600">{{ $order->nama_penumpang }}</div>
                            <div style="font-size:12px; color:var(--text3)">{{ $order->user->name }}</div>
                        </td>
                        <td style="font-size:13px">{{ $order->bus->nama }}</td>
                        <td style="font-size:13px">{{ $order->bus->asal }} → {{ $order->bus->tujuan }}</td>
                        <td style="font-size:13px">{{ $order->tanggal_berangkat->format('d M Y') }}</td>
                        <td style="font-weight:700; color:var(--green)">{{ $order->total_format }}</td>
                        <td>
                            <span class="badge {{ $order->status_class }}">{{ $order->status_label }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}"
                               class="btn btn-ghost btn-sm">👁️ Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align:center; padding:48px; color:var(--text3)">
                            <div style="font-size:32px; margin-bottom:8px">📋</div>
                            Belum ada riwayat pesanan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-admin-layout>