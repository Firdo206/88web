<x-admin-layout title="Detail Pesanan" subtitle="{{ $order->kode_order }}">

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px">

    {{-- Info Pesanan --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">🧾 Info Pesanan</div>
            <span class="badge badge-{{ $order->status_class }}">{{ $order->status_label }}</span>
        </div>
        <div class="card-body">
            @foreach([
                'Kode'              => $order->kode_order,
                'Nama Penumpang'    => $order->nama_penumpang,
                'Telepon'           => $order->telepon ?? '-',
                'Tanggal Berangkat' => $order->tanggal_berangkat->format('d M Y'),
                'Jumlah Kursi'      => $order->jumlah_kursi . ' kursi',
                'Total'             => $order->total_format,
                'Dipesan'           => $order->created_at->format('d M Y, H:i'),
            ] as $label => $val)
            <div style="display:flex;justify-content:space-between;padding:9px 0;border-bottom:1px solid var(--border)">
                <span style="font-size:13px;color:var(--text3)">{{ $label }}</span>
                <span style="font-size:13px;font-weight:600">{{ $val }}</span>
            </div>
            @endforeach
            @if($order->catatan)
            <div style="margin-top:10px;padding:10px;background:var(--surface2);border-radius:8px;font-size:13px;color:var(--text2)">
                📝 {{ $order->catatan }}
            </div>
            @endif
        </div>
    </div>

    {{-- Info Bus & User --}}
    <div style="display:flex;flex-direction:column;gap:14px">
        <div class="card">
            <div class="card-header"><div class="card-title">🚌 Info Bus</div></div>
            <div class="card-body">
                @foreach([
                    'Nama'        => ($order->bus?->emoji ?? '') . ' ' . $order->bus?->nama,
                    'Rute'        => ($order->bus?->asal ?? '-') . ' → ' . ($order->bus?->tujuan ?? '-'),
                    'Berangkat'   => \Carbon\Carbon::parse($order->bus?->jam_berangkat)->format('H:i') . ' WIB',
                    'Tipe'        => $order->bus?->tipe,
                    'Harga/Kursi' => $order->bus?->harga_format,
                ] as $label => $val)
                <div style="display:flex;justify-content:space-between;padding:7px 0;border-bottom:1px solid var(--border)">
                    <span style="font-size:12px;color:var(--text3)">{{ $label }}</span>
                    <span style="font-size:13px;font-weight:600">{{ $val }}</span>
                </div>
                @endforeach
            </div>
        </div>
        <div class="card">
            <div class="card-header"><div class="card-title">👤 Pemesan</div></div>
            <div class="card-body">
                @foreach(['Nama' => $order->user?->name, 'Email' => $order->user?->email] as $label => $val)
                <div style="display:flex;justify-content:space-between;padding:7px 0;border-bottom:1px solid var(--border)">
                    <span style="font-size:12px;color:var(--text3)">{{ $label }}</span>
                    <span style="font-size:13px;font-weight:600">{{ $val }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

{{-- ══════════ PANEL PEMBAYARAN ══════════ --}}
<div class="card" style="margin-bottom:20px">
    <div class="card-header">
        <div class="card-title">💰 Status Pembayaran</div>
        <div style="display:flex;gap:8px;align-items:center">
            <span style="font-size:12px;color:var(--text3)">{{ $order->metode_bayar_label }}</span>
            <span class="badge badge-{{ $order->status_bayar_class }}">{{ $order->status_bayar_label }}</span>
        </div>
    </div>
    <div class="card-body">

        {{-- ═══ TRANSFER ═══ --}}
        @if($order->metode_bayar === 'transfer')

            @if($order->bukti_transfer)

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;align-items:start">

                {{-- Preview Bukti -- admin akses langsung via storage --}}
                <div>
                    <div style="font-size:13px;font-weight:600;color:var(--text2);margin-bottom:10px">
                        📎 Bukti Transfer
                        <span style="font-size:11px;color:var(--text3);font-weight:400;margin-left:6px">
                            Diupload: {{ $order->bukti_uploaded_at?->format('d M Y, H:i') }} WIB
                        </span>
                    </div>

                    @php
                        $ext      = strtolower(pathinfo($order->bukti_transfer, PATHINFO_EXTENSION));
                        $fileUrl  = asset('storage/' . $order->bukti_transfer);
                    @endphp

                    @if(in_array($ext, ['jpg','jpeg','png']))
                        {{-- Klik gambar → buka full size --}}
                        <a href="{{ $fileUrl }}" target="_blank" id="btnLihatBukti">
                            <img src="{{ $fileUrl }}"
                                 alt="Bukti Transfer"
                                 style="width:100%;max-height:300px;object-fit:contain;border-radius:12px;border:1px solid var(--border);cursor:zoom-in;transition:opacity .2s"
                                 onerror="this.style.display='none';document.getElementById('errBukti').style.display='block'">
                        </a>
                        <div id="errBukti" style="display:none;padding:20px;background:var(--surface2);border-radius:10px;text-align:center;color:var(--text3);font-size:13px">
                            ⚠️ Gambar tidak dapat ditampilkan.<br>
                            <a href="{{ $fileUrl }}" target="_blank" class="btn btn-ghost btn-sm" style="margin-top:8px">
                                🔗 Buka File Langsung
                            </a>
                        </div>
                    @elseif($ext === 'pdf')
                        <a href="{{ $fileUrl }}" target="_blank"
                           class="btn btn-ghost" style="width:100%;justify-content:center;padding:24px">
                            📄 Buka File PDF
                        </a>
                    @else
                        <a href="{{ $fileUrl }}" target="_blank"
                           class="btn btn-ghost" style="width:100%;justify-content:center">
                            📎 Unduh Bukti
                        </a>
                    @endif

                    <div style="margin-top:10px;text-align:center">
                        <a href="{{ $fileUrl }}" target="_blank"
                           class="btn btn-ghost btn-sm">
                            🔗 Buka di Tab Baru
                        </a>
                    </div>
                </div>

                {{-- Panel Aksi Verifikasi --}}
                <div style="display:flex;flex-direction:column;gap:14px">

                    @if($order->status_bayar === 'menunggu_verifikasi')

                    {{-- Verifikasi --}}
                    <div style="background:rgba(34,197,94,.08);border:1px solid rgba(34,197,94,.25);border-radius:14px;padding:18px">
                        <div style="font-size:14px;font-weight:700;color:var(--green);margin-bottom:8px">✅ Verifikasi Pembayaran</div>
                        <p style="font-size:12px;color:var(--text3);line-height:1.6;margin-bottom:14px">
                            Pastikan nominal dan nama pengirim sesuai dengan pesanan sebelum memverifikasi.
                        </p>
                        <form method="POST" action="{{ route('admin.orders.verify-payment', $order) }}">
                            @csrf
                            <button class="btn btn-success" style="width:100%;justify-content:center">
                                ✅ Konfirmasi Lunas
                            </button>
                        </form>
                    </div>

                    {{-- Tolak --}}
                    <div style="background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.25);border-radius:14px;padding:18px">
                        <div style="font-size:14px;font-weight:700;color:var(--red);margin-bottom:8px">❌ Tolak Bukti</div>
                        <form method="POST" action="{{ route('admin.orders.reject-payment', $order) }}">
                            @csrf
                            <div class="form-group" style="margin-bottom:10px">
                                <input name="catatan_bayar"
                                       placeholder="Alasan penolakan (wajib diisi)..."
                                       required style="font-size:13px">
                                @error('catatan_bayar')
                                    <span style="color:var(--red);font-size:11px">{{ $message }}</span>
                                @enderror
                            </div>
                            <button class="btn btn-danger" style="width:100%;justify-content:center">
                                ❌ Tolak & Minta Upload Ulang
                            </button>
                        </form>
                    </div>

                    @elseif($order->status_bayar === 'lunas')
                    <div style="background:rgba(34,197,94,.08);border:1px solid rgba(34,197,94,.2);border-radius:14px;padding:20px;text-align:center">
                        <div style="font-size:36px;margin-bottom:8px">✅</div>
                        <div style="font-size:15px;font-weight:700;color:var(--green)">Pembayaran Lunas</div>
                        <div style="font-size:12px;color:var(--text3);margin-top:4px">
                            Diverifikasi: {{ $order->verified_at?->format('d M Y, H:i') }}
                        </div>
                    </div>

                    @elseif($order->status_bayar === 'belum_bayar')
                    <div style="background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);border-radius:14px;padding:20px;text-align:center">
                        <div style="font-size:36px;margin-bottom:8px">⏳</div>
                        <div style="font-size:15px;font-weight:700;color:var(--red)">Menunggu Upload Ulang</div>
                        @if($order->catatan_bayar)
                        <div style="font-size:12px;color:var(--text3);margin-top:8px;background:var(--surface2);padding:8px;border-radius:8px">
                            Alasan ditolak: <em>{{ $order->catatan_bayar }}</em>
                        </div>
                        @endif
                    </div>
                    @endif

                </div>
            </div>

            @else
            {{-- Belum upload --}}
            <div style="text-align:center;padding:40px;background:var(--surface2);border-radius:12px">
                <div style="font-size:48px;margin-bottom:12px;opacity:.4">📭</div>
                <div style="font-size:15px;font-weight:600;color:var(--text2)">Belum ada bukti transfer</div>
                <div style="font-size:13px;color:var(--text3);margin-top:6px">User belum mengupload bukti pembayaran</div>
            </div>
            @endif

        {{-- ═══ COD ═══ --}}
        @elseif($order->metode_bayar === 'cod')
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
            <div style="background:rgba(59,130,246,.08);border:1px solid rgba(59,130,246,.2);border-radius:14px;padding:20px">
                <div style="font-size:32px;margin-bottom:10px">💵</div>
                <div style="font-size:14px;font-weight:700;margin-bottom:6px">Bayar di Tempat (COD)</div>
                <div style="font-size:12px;color:var(--text3);line-height:1.7">
                    User membayar langsung kepada kondektur saat bus berangkat.<br>
                    Total: <strong style="color:var(--accent)">{{ $order->total_format }}</strong>
                </div>
            </div>
            <div style="display:flex;align-items:center;justify-content:center">
                @if($order->status_bayar === 'cod_pending')
                <form method="POST" action="{{ route('admin.orders.verify-cod', $order) }}" style="width:100%">
                    @csrf
                    <button class="btn btn-success" style="width:100%;justify-content:center;padding:16px;font-size:15px">
                        💵 Konfirmasi Sudah Bayar COD
                    </button>
                </form>
                @elseif($order->status_bayar === 'lunas')
                <div style="text-align:center">
                    <div style="font-size:42px;margin-bottom:8px">✅</div>
                    <div style="font-weight:700;color:var(--green)">COD Lunas</div>
                    <div style="font-size:12px;color:var(--text3);margin-top:4px">
                        {{ $order->verified_at?->format('d M Y, H:i') }}
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif

    </div>
</div>

{{-- ══ Aksi Status Pesanan ══ --}}
<div style="display:flex;gap:12px;flex-wrap:wrap">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost">← Kembali</a>

    @if($order->status === 'pending' && in_array($order->status_bayar, ['lunas', 'cod_pending']))
        <form method="POST" action="{{ route('admin.orders.confirm', $order) }}">
            @csrf
            <button class="btn btn-success">✅ Konfirmasi Pesanan</button>
        </form>
    @elseif($order->status === 'pending')
        <div style="font-size:13px;color:var(--yellow);display:flex;align-items:center;gap:6px">
            ⚠️ Konfirmasi hanya tersedia setelah pembayaran lunas
        </div>
    @endif

    @if($order->status === 'confirmed')
        <form method="POST" action="{{ route('admin.orders.complete', $order) }}">
            @csrf
            <button class="btn btn-success">🏁 Tandai Selesai</button>
        </form>
    @endif

    @if(in_array($order->status, ['pending', 'confirmed']))
        <form method="POST" action="{{ route('admin.orders.cancel', $order) }}"
              onsubmit="return confirm('Batalkan pesanan ini?')">
            @csrf
            <button class="btn btn-danger">❌ Batalkan Pesanan</button>
        </form>
    @endif
</div>

</x-admin-layout>