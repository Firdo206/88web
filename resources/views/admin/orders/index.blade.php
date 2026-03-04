<x-admin-layout title="Pesanan Masuk">

    {{-- Filter Tabs --}}
    <div class="tabs">
        @foreach(['all' => 'Semua', 'pending' => 'Menunggu', 'confirmed' => 'Dikonfirmasi', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $val => $label)
        <a href="{{ route('admin.orders.index', ['status' => $val]) }}"
           class="tab {{ $status === $val ? 'active' : '' }}">
            {{ $label }}
            @if($val === 'pending' && $pendingCount > 0)
                <span style="background:var(--accent);color:#fff;font-size:10px;font-weight:700;padding:1px 6px;border-radius:10px;margin-left:4px">{{ $pendingCount }}</span>
            @endif
        </a>
        @endforeach
    </div>

    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Penumpang</th>
                        <th>Bus / Rute</th>
                        <th>Tanggal</th>
                        <th>Kursi</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>
                            <code style="color:var(--accent);font-size:12px">{{ $order->kode_order }}</code>
                        </td>
                        <td>
                            <div style="font-weight:600;font-size:14px">{{ $order->nama_penumpang }}</div>
                            <div style="font-size:12px;color:var(--text3)">{{ $order->user?->email }}</div>
                        </td>
                        <td>
                            <div style="font-size:13px;font-weight:500">{{ $order->bus?->nama }}</div>
                            <div style="font-size:12px;color:var(--text3)">{{ $order->bus?->asal }} → {{ $order->bus?->tujuan }}</div>
                        </td>
                        <td style="font-size:13px">{{ $order->tanggal_berangkat->format('d M Y') }}</td>
                        <td style="font-size:13px;text-align:center">{{ $order->jumlah_kursi }}</td>
                        <td style="font-weight:700;color:var(--green);font-size:13px">{{ $order->total_format }}</td>
                        <td><span class="badge badge-{{ $order->status_class }}">{{ $order->status_label }}</span></td>
                        <td>
                            <div style="display:flex;gap:6px;flex-wrap:wrap">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-ghost btn-sm">👁️</a>
                                @if($order->status === 'pending')
                                    <form method="POST" action="{{ route('admin.orders.confirm', $order) }}">
                                        @csrf
                                        <button class="btn btn-success btn-sm">✅</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.orders.cancel', $order) }}">
                                        @csrf
                                        <button class="btn btn-danger btn-sm">❌</button>
                                    </form>
                                @elseif($order->status === 'confirmed')
                                    <form method="POST" action="{{ route('admin.orders.complete', $order) }}">
                                        @csrf
                                        <button class="btn btn-success btn-sm">🏁</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8">
                        <div class="empty-state">
                            <div class="empty-state-icon">📋</div>
                            <div>Tidak ada pesanan {{ $status !== 'all' ? "dengan status $status" : '' }}</div>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-admin-layout>