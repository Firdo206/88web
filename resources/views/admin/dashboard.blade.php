<x-admin-layout title="Dashboard">

    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card orange">
            <div class="stat-icon orange">🚌</div>
            <div class="stat-value">{{ $totalBus }}</div>
            <div class="stat-label">Total Armada Bus</div>
        </div>
        <div class="stat-card green">
            <div class="stat-icon green">🎫</div>
            <div class="stat-value">{{ $totalPesanan }}</div>
            <div class="stat-label">Total Pesanan</div>
        </div>
        <div class="stat-card yellow">
            <div class="stat-icon yellow">⏳</div>
            <div class="stat-value">{{ $pendingPesanan }}</div>
            <div class="stat-label">Menunggu Konfirmasi</div>
            @if($pendingPesanan > 0)
                <div class="stat-change down">⚠️ Perlu ditindak</div>
            @endif
        </div>
        <div class="stat-card blue">
            <div class="stat-icon blue">💰</div>
            <div class="stat-value" style="font-size:18px">Rp {{ number_format($pendapatan,0,',','.') }}</div>
            <div class="stat-label">Total Pendapatan</div>
        </div>
    </div>

    <div class="grid-2">

        {{-- Pesanan Terbaru --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">🧾 Pesanan Terbaru</div>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost btn-sm">Lihat Semua</a>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Penumpang</th>
                            <th>Rute</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td><code style="color:var(--accent);font-size:12px">{{ $order->kode_order }}</code></td>
                            <td>{{ $order->nama_penumpang }}</td>
                            <td style="font-size:12px;color:var(--text2)">
                                {{ $order->bus?->asal }} → {{ $order->bus?->tujuan }}
                            </td>
                            <td><span class="badge badge-{{ $order->status_class ?? 'gray' }}">{{ $order->status_label }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="4" style="text-align:center;color:var(--text3);padding:24px">Belum ada pesanan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Bus Populer --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">🏆 Bus Paling Populer</div>
                <a href="{{ route('admin.bus.index') }}" class="btn btn-ghost btn-sm">Kelola Bus</a>
            </div>
            <div class="card-body">
                @forelse($popularBus as $i => $bus)
                <div style="display:flex;align-items:center;gap:14px;padding:12px 0;border-bottom:1px solid var(--border)">
                    <div style="width:32px;height:32px;border-radius:8px;background:var(--accent-dim);display:flex;align-items:center;justify-content:center;font-weight:800;color:var(--accent);font-size:14px;flex-shrink:0">
                        {{ $i + 1 }}
                    </div>
                    <div style="flex:1;min-width:0">
                        <div style="font-weight:600;font-size:14px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $bus->nama }}</div>
                        <div style="font-size:12px;color:var(--text3)">{{ $bus->asal }} → {{ $bus->tujuan }}</div>
                    </div>
                    <div style="font-size:13px;font-weight:700;color:var(--accent);flex-shrink:0">
                        {{ $bus->orders_count }} pesanan
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <div class="empty-state-icon">🚌</div>
                    <div>Belum ada data</div>
                </div>
                @endforelse
            </div>
        </div>

    </div>

</x-admin-layout>