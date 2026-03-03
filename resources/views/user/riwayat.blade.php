<x-user-layout title="Riwayat Perjalanan" subtitle="Semua Perjalanan">

    <h2 style="font-family:'Syne',sans-serif; font-size:20px; font-weight:800; margin-bottom:20px">
        Riwayat Perjalanan
    </h2>

    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#Kode</th>
                        <th>Bus</th>
                        <th>Rute</th>
                        <th>Tgl Perjalanan</th>
                        <th>Total</th>
                        <th>Status</th>
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
                        <td style="font-weight:600; font-size:13px">{{ $order->bus->nama }}</td>
                        <td style="font-size:13px">{{ $order->bus->asal }} → {{ $order->bus->tujuan }}</td>
                        <td style="font-size:13px">{{ $order->tanggal_berangkat->format('d M Y') }}</td>
                        <td style="font-weight:700; color:var(--green)">{{ $order->total_format }}</td>
                        <td>
                            <span class="badge {{ $order->status_class }}">{{ $order->status_label }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:48px; color:var(--text3)">
                            <div style="font-size:32px; margin-bottom:8px">🛣️</div>
                            Belum ada riwayat perjalanan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-user-layout>