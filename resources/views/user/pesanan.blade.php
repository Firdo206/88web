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
                        <th>Total</th>
                        <th>Pembayaran</th>
                        <th>Status Pesan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>
                            <code style="color:var(--accent);font-size:12px">{{ $order->kode_order }}</code>
                            <div style="font-size:11px;color:var(--text3);margin-top:2px">
                                {{ $order->created_at->format('d M Y') }}
                            </div>
                        </td>
                        <td>
                            <div style="font-size:13px;font-weight:600">{{ $order->bus?->nama }}</div>
                            <div style="font-size:12px;color:var(--text3)">
                                {{ $order->bus?->asal }} → {{ $order->bus?->tujuan }}
                            </div>
                        </td>
                        <td style="font-size:13px">{{ $order->tanggal_berangkat->format('d M Y') }}</td>
                        <td>
                            <div style="font-weight:700;color:var(--green);font-size:13px">{{ $order->total_format }}</div>
                            <div style="font-size:11px;color:var(--text3)">{{ $order->metode_bayar_label }}</div>
                        </td>
                        <td>
                            <span class="badge badge-{{ $order->status_bayar_class }}">
                                {{ $order->status_bayar_label }}
                            </span>
                            @if($order->status_bayar === 'menunggu_verifikasi')
                                <div style="font-size:11px;color:var(--yellow);margin-top:3px">⏳ Admin sedang cek</div>
                            @endif
                            @if($order->catatan_bayar && $order->status_bayar === 'belum_bayar')
                                <div style="font-size:11px;color:var(--red);margin-top:3px">❌ {{ $order->catatan_bayar }}</div>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{ $order->status_class }}">{{ $order->status_label }}</span>
                        </td>
                        <td>
                            <div style="display:flex;flex-direction:column;gap:6px">

                                {{-- Tombol upload / update bukti --}}
                                @if($order->metode_bayar === 'transfer' && in_array($order->status_bayar, ['belum_bayar', 'menunggu_verifikasi']))
                                    <a href="{{ route('user.payment', $order) }}"
                                       class="btn btn-{{ $order->status_bayar === 'belum_bayar' ? 'primary' : 'warning' }} btn-sm">
                                        {{ $order->status_bayar === 'belum_bayar' ? '📤 Bayar' : '🔄 Update Bukti' }}
                                    </a>
                                @endif

                                {{-- Tombol lihat bukti jika sudah pernah upload --}}
                                @if($order->bukti_transfer)
                                    <a href="{{ route('user.bukti.show', $order) }}" target="_blank"
                                       class="btn btn-ghost btn-sm">
                                        🖼️ Lihat Bukti
                                    </a>
                                @endif

                                {{-- Status lunas tanpa aksi --}}
                                @if($order->status_bayar === 'lunas' && !$order->bukti_transfer)
                                    <span style="font-size:13px;color:var(--green)">✅ Lunas</span>
                                @endif

                                {{-- COD --}}
                                @if($order->status_bayar === 'cod_pending')
                                    <span style="font-size:12px;color:var(--blue)">💵 Bayar di Bus</span>
                                @endif

                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</x-user-layout>