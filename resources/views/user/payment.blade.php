<x-user-layout title="Upload Bukti Transfer">

<div style="max-width:660px;margin:0 auto">

    {{-- Header --}}
    <div style="background:linear-gradient(135deg,rgba(59,130,246,.15),rgba(59,130,246,.05));border:1px solid rgba(59,130,246,.25);border-radius:20px;padding:22px 24px;margin-bottom:22px;display:flex;align-items:center;gap:16px;flex-wrap:wrap">
        <div style="width:50px;height:50px;background:rgba(59,130,246,.2);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:24px;flex-shrink:0">🏦</div>
        <div style="flex:1">
            <div style="font-family:'Syne',sans-serif;font-size:17px;font-weight:800">Selesaikan Pembayaran</div>
            <div style="font-size:13px;color:var(--text2);margin-top:2px">
                Pesanan <code style="color:var(--accent);background:var(--surface);padding:1px 7px;border-radius:6px">{{ $order->kode_order }}</code>
                menunggu bukti transfer
            </div>
        </div>
        <span class="badge badge-{{ $order->status_bayar_class }}">{{ $order->status_bayar_label }}</span>
    </div>

    {{-- Ringkasan Pesanan + Rekening --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:20px">

        {{-- Detail Pesanan --}}
        <div class="card">
            <div class="card-header"><div class="card-title">🎫 Ringkasan</div></div>
            <div class="card-body" style="padding:14px">
                @foreach([
                    'Bus'     => $order->bus?->nama,
                    'Rute'    => ($order->bus?->asal ?? '-') . ' → ' . ($order->bus?->tujuan ?? '-'),
                    'Tanggal' => $order->tanggal_berangkat->format('d M Y'),
                    'Kursi'   => $order->jumlah_kursi . ' kursi',
                ] as $label => $val)
                <div style="display:flex;justify-content:space-between;padding:7px 0;border-bottom:1px solid var(--border);font-size:13px">
                    <span style="color:var(--text3)">{{ $label }}</span>
                    <span style="font-weight:600">{{ $val }}</span>
                </div>
                @endforeach

                {{-- Tampilkan info promo jika catatan mengandung "Promo:" --}}
                @if($order->catatan && str_starts_with($order->catatan, 'Promo:'))
                @php
                    // Ambil bagian promo dari catatan
                    preg_match('/Promo: (.+?)\./', $order->catatan, $match);
                    $promoInfo = $match[1] ?? null;
                @endphp
                @if($promoInfo)
                <div style="display:flex;justify-content:space-between;padding:7px 0;border-bottom:1px solid var(--border);font-size:13px">
                    <span style="color:var(--green)">🎁 Promo</span>
                    <span style="font-weight:600;color:var(--green)">{{ $promoInfo }}</span>
                </div>
                @endif
                @endif

                {{-- Total --}}
                <div style="display:flex;justify-content:space-between;padding:10px 0;margin-top:2px">
                    <span style="font-size:13px;color:var(--text3)">Total Bayar</span>
                    <span style="font-family:'Syne',sans-serif;font-size:20px;font-weight:800;color:var(--accent)">
                        {{ $order->total_format }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Rekening --}}
        <div class="card">
            <div class="card-header"><div class="card-title">💳 Transfer ke</div></div>
            <div class="card-body" style="padding:14px">
                @foreach([
                    ['BCA',     '🔵', '1234567890'],
                    ['Mandiri', '🟡', '0987654321'],
                    ['BRI',     '🔵', '1122334455'],
                    ['BNI',     '🟠', '5544332211'],
                ] as [$bank, $emoji, $norek])
                <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border)">
                    <span style="font-size:13px;color:var(--text2)">{{ $emoji }} {{ $bank }}</span>
                    <code onclick="copyText('{{ $norek }}', this)"
                          title="Klik untuk salin"
                          style="font-size:13px;font-weight:700;cursor:pointer;transition:color .2s">
                        {{ $norek }}
                    </code>
                </div>
                @endforeach
                <div style="font-size:11px;color:var(--text3);margin-top:10px">
                    a/n: <strong style="color:var(--text2)">PT BusGo Indonesia</strong>
                </div>
                <div style="margin-top:10px;padding:8px 10px;background:rgba(249,115,22,.08);border-radius:8px;font-size:12px;color:var(--accent)">
                    ⚠️ Transfer tepat <strong>{{ $order->total_format }}</strong>
                </div>
            </div>
        </div>
    </div>

    {{-- Upload Form --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">📤 Upload Bukti Transfer</div>
        </div>
        <div class="card-body">

            {{-- Sudah pernah upload tapi ditolak --}}
            @if($order->bukti_transfer && $order->catatan_bayar)
            <div style="background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);border-radius:12px;padding:14px;margin-bottom:16px">
                <div style="font-size:13px;font-weight:600;color:var(--red);margin-bottom:4px">❌ Bukti sebelumnya ditolak</div>
                <div style="font-size:12px;color:var(--text3)">Alasan: <em>{{ $order->catatan_bayar }}</em></div>
                <a href="{{ asset('storage/' . $order->bukti_transfer) }}" target="_blank"
                   class="btn btn-ghost btn-sm" style="margin-top:8px">👁️ Lihat bukti lama</a>
            </div>
            @elseif($order->status_bayar === 'menunggu_verifikasi')
            <div style="background:rgba(234,179,8,.08);border:1px solid rgba(234,179,8,.2);border-radius:12px;padding:14px;margin-bottom:16px;display:flex;align-items:center;gap:12px">
                <div style="font-size:24px">⏳</div>
                <div>
                    <div style="font-size:13px;font-weight:600;color:var(--yellow)">Bukti sudah dikirim</div>
                    <div style="font-size:12px;color:var(--text3)">
                        Dikirim {{ $order->bukti_uploaded_at?->format('d M Y, H:i') }} WIB — Admin sedang memverifikasi.
                    </div>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('user.payment.upload', $order) }}"
                  enctype="multipart/form-data" id="uploadForm">
                @csrf

                {{-- Dropzone --}}
                <div id="dropzone"
                     onclick="document.getElementById('fileInput').click()"
                     ondragover="event.preventDefault();this.style.borderColor='var(--accent)'"
                     ondragleave="this.style.borderColor='var(--border)'"
                     ondrop="handleDrop(event)"
                     style="border:2px dashed var(--border);border-radius:14px;padding:32px;text-align:center;cursor:pointer;transition:border-color .2s;margin-bottom:14px">
                    <div id="dropContent">
                        <div style="font-size:40px;margin-bottom:8px">📎</div>
                        <div style="font-size:14px;font-weight:600;margin-bottom:3px">Klik atau drag & drop</div>
                        <div style="font-size:12px;color:var(--text3)">JPG, PNG, PDF — Maks. 3MB</div>
                    </div>
                    <div id="previewWrap" style="display:none">
                        <img id="previewImg" style="max-height:180px;max-width:100%;border-radius:10px;object-fit:contain">
                        <div id="previewName" style="font-size:13px;color:var(--text2);margin-top:6px"></div>
                        <div style="font-size:12px;color:var(--green);margin-top:3px">✅ Siap diupload</div>
                    </div>
                </div>

                <input type="file" id="fileInput" name="bukti_transfer"
                       accept=".jpg,.jpeg,.png,.pdf" style="display:none"
                       onchange="previewFile(this)">

                @error('bukti_transfer')
                    <div class="alert alert-error" style="margin-bottom:12px">{{ $message }}</div>
                @enderror

                <button type="submit" id="btnUpload"
                        class="btn btn-primary"
                        style="width:100%;justify-content:center;padding:13px;font-size:15px">
                    📤 Kirim Bukti Transfer
                </button>
            </form>
        </div>
    </div>

    <div style="text-align:center;margin-top:14px">
        <a href="{{ route('user.pesanan') }}" style="font-size:13px;color:var(--text3);text-decoration:none">
            ← Kembali ke Pesanan Saya
        </a>
    </div>

</div>

<script>
function previewFile(input) {
    if (input.files[0]) showPreview(input.files[0]);
}
function handleDrop(e) {
    e.preventDefault();
    document.getElementById('dropzone').style.borderColor = 'var(--border)';
    const file = e.dataTransfer.files[0];
    if (!file) return;
    const dt = new DataTransfer();
    dt.items.add(file);
    document.getElementById('fileInput').files = dt.files;
    showPreview(file);
}
function showPreview(file) {
    document.getElementById('dropContent').style.display = 'none';
    document.getElementById('previewWrap').style.display = 'block';
    document.getElementById('dropzone').style.borderColor = 'var(--green)';
    document.getElementById('previewName').textContent = file.name + ' (' + (file.size/1024).toFixed(0) + ' KB)';
    if (file.type.startsWith('image/')) {
        const r = new FileReader();
        r.onload = e => { document.getElementById('previewImg').src = e.target.result; document.getElementById('previewImg').style.display = 'block'; };
        r.readAsDataURL(file);
    } else {
        document.getElementById('previewImg').style.display = 'none';
    }
}
function copyText(text, el) {
    navigator.clipboard.writeText(text).then(() => {
        const orig = el.textContent;
        el.textContent = '✅ Tersalin!';
        el.style.color = 'var(--green)';
        setTimeout(() => { el.textContent = orig; el.style.color = ''; }, 1500);
    });
}
document.getElementById('uploadForm').addEventListener('submit', () => {
    const btn = document.getElementById('btnUpload');
    btn.disabled = true;
    btn.textContent = '⏳ Mengirim...';
});
</script>

</x-user-layout>