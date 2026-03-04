<x-admin-layout title="Pesanan Masuk">

    {{-- Alert notif pembayaran menunggu --}}
    @if($menungguVerifikasiCount > 0)
    <div class="alert" style="background:rgba(234,179,8,.1);border:1px solid rgba(234,179,8,.25);color:var(--yellow);margin-bottom:20px">
        🔔 Ada <strong>{{ $menungguVerifikasiCount }} bukti transfer</strong> menunggu verifikasi Anda.
    </div>
    @endif

    {{-- Filter Tabs --}}
    <div class="tabs">
        @foreach(['all' => 'Semua', 'pending' => 'Menunggu', 'confirmed' => 'Dikonfirmasi', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $val => $label)
        <a href="{{ route('admin.orders.index', ['status' => $val]) }}"
           class="tab {{ $status === $val ? 'active' : '' }}">
            {{ $label }}
            @if($val === 'pending' && $pendingCount > 0)
                <span style="background:var(--accent);color:#fff;font-size:10px;font-weight:700;padding:1px 6px;border-radius:10px;margin-left:4px">
                    {{ $pendingCount }}
                </span>
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
                        <th>Total</th>
                        <th>Metode</th>
                        <th>Status Bayar</th>
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
                            <div style="font-weight:600;font-size:13px">{{ $order->nama_penumpang }}</div>
                            <div style="font-size:11px;color:var(--text3)">{{ $order->user?->email }}</div>
                        </td>
                        <td>
                            <div style="font-size:13px;font-weight:500">{{ $order->bus?->nama }}</div>
                            <div style="font-size:11px;color:var(--text3)">{{ $order->bus?->asal }} → {{ $order->bus?->tujuan }}</div>
                        </td>
                        <td style="font-size:13px">{{ $order->tanggal_berangkat->format('d M Y') }}</td>
                        <td style="font-weight:700;color:var(--green);font-size:13px">{{ $order->total_format }}</td>
                        <td>
                            <span style="font-size:12px">
                                {{ $order->metode_bayar === 'transfer' ? '🏦' : '💵' }}
                                {{ strtoupper($order->metode_bayar) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $order->status_bayar_class }}">
                                {{ $order->status_bayar_label }}
                            </span>
                            @if($order->status_bayar === 'menunggu_verifikasi')
                                <div style="font-size:10px;color:var(--yellow);margin-top:2px">⏳ Perlu dicek</div>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{ $order->status_class }}">{{ $order->status_label }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}"
                               class="btn btn-ghost btn-sm">👁️ Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9">
                        <div class="empty-state">
                            <div class="empty-state-icon">📋</div>
                            <div>Tidak ada pesanan</div>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-admin-layout>