{{-- Modal Pesan Tiket — Transfer / COD + Kode Promo --}}
<div class="modal-overlay" id="modalPesan">
    <div class="modal" style="max-width:620px">
        <div class="modal-header">
            <div class="modal-title" id="modalBusName">🎫 Pesan Tiket</div>
            <button class="modal-close" onclick="document.getElementById('modalPesan').classList.remove('open')">✕</button>
        </div>
        <form method="POST" action="{{ route('user.order.store') }}">
            @csrf
            <input type="hidden" name="bus_id" id="inputBusId">

            <div class="modal-body">

                {{-- Info Bus --}}
                <div style="background:var(--surface2);border-radius:12px;padding:14px;margin-bottom:18px;font-size:13px">
                    <div style="display:flex;gap:16px;flex-wrap:wrap">
                        <div><span style="color:var(--text3)">Rute:</span> <strong id="infoBusRute">-</strong></div>
                        <div><span style="color:var(--text3)">Berangkat:</span> <strong id="infoBusJam">-</strong></div>
                        <div><span style="color:var(--text3)">Tipe:</span> <strong id="infoBusTipe">-</strong></div>
                    </div>
                    <div style="margin-top:8px">
                        <span style="color:var(--text3)">Harga/kursi:</span>
                        <strong id="infoBusHarga" style="color:var(--accent);font-size:15px">-</strong>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group full">
                        <label>Nama Penumpang</label>
                        <input name="nama_penumpang" id="inputNama"
                               placeholder="Nama lengkap" required>
                    </div>
                    <div class="form-group">
                        <label>Nomor Telepon</label>
                        <input name="telepon" type="tel" placeholder="08xxxxxxxxxx">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Berangkat</label>
                        <input name="tanggal_berangkat" type="date"
                               min="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Kursi</label>
                        <input name="jumlah_kursi" type="number" min="1" max="10"
                               value="1" id="inputKursi" oninput="hitungTotal()" required>
                    </div>
                    <div class="form-group">
                        <label>Catatan (opsional)</label>
                        <input name="catatan" placeholder="Permintaan khusus...">
                    </div>
                </div>

                {{-- ══ Kode Promo ══ --}}
                <div style="margin-top:14px">
                    <label style="font-size:13px;font-weight:600;color:var(--text2);display:block;margin-bottom:8px">
                        🎁 Kode Promo (opsional)
                    </label>
                    <div style="display:flex;gap:8px">
                        <input id="inputPromo" placeholder="Masukkan kode promo..." name="kode_promo"
                               style="flex:1;text-transform:uppercase"
                               oninput="this.value=this.value.toUpperCase()">
                        <button type="button" class="btn btn-ghost" onclick="cekPromo()" id="btnCekPromo">
                            Cek
                        </button>
                    </div>
                    <div id="promoInfo" style="display:none;margin-top:8px;padding:10px 14px;border-radius:10px;font-size:13px"></div>
                    <input type="hidden" name="diskon_persen" id="hiddenDiskon" value="0">
                </div>

                {{-- ══ Metode Pembayaran ══ --}}
                <div style="margin-top:18px">
                    <label style="font-size:13px;font-weight:600;color:var(--text2);display:block;margin-bottom:10px">
                        Metode Pembayaran
                    </label>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                        <label for="bayar_transfer" style="cursor:pointer">
                            <input type="radio" id="bayar_transfer" name="metode_bayar"
                                   value="transfer" onchange="togglePaymentInfo()" checked style="display:none">
                            <div class="payment-option" id="opt_transfer"
                                 style="border:2px solid var(--accent);background:var(--accent-dim)">
                                <div style="font-size:28px;margin-bottom:8px">🏦</div>
                                <div style="font-weight:700;font-size:14px">Transfer Bank</div>
                                <div style="font-size:11px;color:var(--text3);margin-top:3px">BCA / Mandiri / BRI / BNI</div>
                            </div>
                        </label>
                        <label for="bayar_cod" style="cursor:pointer">
                            <input type="radio" id="bayar_cod" name="metode_bayar"
                                   value="cod" onchange="togglePaymentInfo()" style="display:none">
                            <div class="payment-option" id="opt_cod">
                                <div style="font-size:28px;margin-bottom:8px">💵</div>
                                <div style="font-weight:700;font-size:14px">COD</div>
                                <div style="font-size:11px;color:var(--text3);margin-top:3px">Bayar saat di bus</div>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Info Transfer --}}
                <div id="infoTransfer" style="margin-top:14px;background:rgba(59,130,246,.08);border:1px solid rgba(59,130,246,.2);border-radius:12px;padding:14px;font-size:13px">
                    <div style="font-weight:700;color:var(--blue);margin-bottom:8px">📋 Rekening Tujuan</div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;color:var(--text2)">
                        <div>🏦 BCA — <strong style="color:var(--text)">1234567890</strong></div>
                        <div>🏦 Mandiri — <strong style="color:var(--text)">0987654321</strong></div>
                        <div>🏦 BRI — <strong style="color:var(--text)">1122334455</strong></div>
                        <div>🏦 BNI — <strong style="color:var(--text)">5544332211</strong></div>
                    </div>
                    <div style="margin-top:8px;font-size:11px;color:var(--text3)">
                        a/n: <strong style="color:var(--text2)">PT BusGo Indonesia</strong> —
                        Upload bukti transfer setelah memesan.
                    </div>
                </div>

                {{-- Info COD --}}
                <div id="infoCOD" style="display:none;margin-top:14px;background:rgba(34,197,94,.08);border:1px solid rgba(34,197,94,.2);border-radius:12px;padding:14px;font-size:13px">
                    <div style="font-weight:700;color:var(--green);margin-bottom:6px">💵 Informasi COD</div>
                    <div style="color:var(--text2);line-height:1.7">
                        ✅ Bayar langsung kepada kondektur bus saat berangkat.<br>
                        ✅ Siapkan uang pas sesuai total pembayaran.<br>
                        ✅ Pesanan dikonfirmasi admin setelah keberangkatan.
                    </div>
                </div>

                {{-- Total --}}
                <div style="background:var(--accent-dim);border:1px solid rgba(249,115,22,.2);border-radius:12px;padding:14px;margin-top:16px">
                    <div id="rowDiskon" style="display:none;justify-content:space-between;align-items:center;margin-bottom:8px;padding-bottom:8px;border-bottom:1px solid rgba(249,115,22,.15)">
                        <span style="font-size:13px;color:var(--text2)">Harga asli</span>
                        <span id="hargaAsli" style="font-size:13px;color:var(--text3)">Rp 0</span>
                    </div>
                    <div id="rowPotongan" style="display:none;justify-content:space-between;align-items:center;margin-bottom:8px">
                        <span style="font-size:13px;color:var(--green)">Potongan promo (<span id="pctLabel">0</span>%)</span>
                        <span id="nilaiPotongan" style="font-size:13px;color:var(--green)">- Rp 0</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center">
                        <span style="font-size:14px;color:var(--text2)">Total Bayar</span>
                        <span id="totalHarga" style="font-family:'Syne',sans-serif;font-size:22px;font-weight:800;color:var(--accent)">Rp 0</span>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-ghost"
                    onclick="document.getElementById('modalPesan').classList.remove('open')">Batal</button>
                <button type="submit" class="btn btn-primary" id="btnPesan">
                    🏦 Pesan & Lanjut Transfer
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.payment-option {
    border: 2px solid var(--border);
    border-radius: 12px;
    padding: 16px;
    text-align: center;
    transition: all .2s;
    background: var(--surface2);
}
.payment-option:hover { border-color: var(--accent); background: var(--accent-dim); }
</style>

<script>
let busHarga   = 0;
let diskonPct  = 0;

function openPesan(bus) {
    busHarga = bus.harga;
    diskonPct = 0;
    document.getElementById('inputBusId').value  = bus.id;
    document.getElementById('modalBusName').textContent = '🎫 Pesan — ' + bus.nama;
    document.getElementById('infoBusRute').textContent  = bus.asal + ' → ' + bus.tujuan;
    document.getElementById('infoBusJam').textContent   = bus.jam_berangkat;
    document.getElementById('infoBusTipe').textContent  = bus.tipe;
    document.getElementById('infoBusHarga').textContent = 'Rp ' + Number(bus.harga).toLocaleString('id-ID');
    document.getElementById('inputNama').value          = '{{ auth()->user()->name }}';
    document.getElementById('inputKursi').value         = 1;
    document.getElementById('inputPromo').value         = '';
    document.getElementById('hiddenDiskon').value       = 0;
    document.getElementById('promoInfo').style.display  = 'none';
    document.getElementById('bayar_transfer').checked   = true;
    togglePaymentInfo();
    hitungTotal();
    document.getElementById('modalPesan').classList.add('open');
}

function hitungTotal() {
    const kursi     = parseInt(document.getElementById('inputKursi').value) || 1;
    const subtotal  = busHarga * kursi;
    const potongan  = Math.floor(subtotal * diskonPct / 100);
    const total     = subtotal - potongan;

    document.getElementById('totalHarga').textContent   = 'Rp ' + total.toLocaleString('id-ID');

    if (diskonPct > 0) {
        document.getElementById('hargaAsli').textContent    = 'Rp ' + subtotal.toLocaleString('id-ID');
        document.getElementById('nilaiPotongan').textContent = '- Rp ' + potongan.toLocaleString('id-ID');
        document.getElementById('pctLabel').textContent     = diskonPct;
        document.getElementById('rowDiskon').style.display  = 'flex';
        document.getElementById('rowPotongan').style.display= 'flex';
    } else {
        document.getElementById('rowDiskon').style.display  = 'none';
        document.getElementById('rowPotongan').style.display= 'none';
    }
}

async function cekPromo() {
    const kode = document.getElementById('inputPromo').value.trim();
    const info = document.getElementById('promoInfo');
    const btn  = document.getElementById('btnCekPromo');
    if (!kode) { info.style.display = 'none'; return; }

    btn.textContent = '...'; btn.disabled = true;

    try {
        const res  = await fetch('/api/promo/cek?kode=' + encodeURIComponent(kode));
        const data = await res.json();

        if (data.valid) {
            diskonPct = data.diskon;
            document.getElementById('hiddenDiskon').value = data.diskon;
            info.style.cssText = 'display:block;background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.2);border-radius:10px;padding:10px 14px;font-size:13px;color:var(--green)';
            info.innerHTML = '✅ Promo <strong>' + kode + '</strong> — Diskon <strong>' + data.diskon + '%</strong>! ' + (data.nama ?? '');
        } else {
            diskonPct = 0;
            document.getElementById('hiddenDiskon').value = 0;
            info.style.cssText = 'display:block;background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.2);border-radius:10px;padding:10px 14px;font-size:13px;color:var(--red)';
            info.innerHTML = '❌ ' + (data.message ?? 'Kode promo tidak valid atau sudah kedaluwarsa.');
        }
    } catch {
        info.style.cssText = 'display:block;background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.2);border-radius:10px;padding:10px 14px;font-size:13px;color:var(--red)';
        info.innerHTML = '❌ Gagal mengecek promo, coba lagi.';
    }

    btn.textContent = 'Cek'; btn.disabled = false;
    hitungTotal();
}

// Tekan Enter di input promo → langsung cek
document.getElementById('inputPromo')?.addEventListener('keydown', e => {
    if (e.key === 'Enter') { e.preventDefault(); cekPromo(); }
});

function togglePaymentInfo() {
    const isTransfer = document.getElementById('bayar_transfer').checked;
    document.getElementById('infoTransfer').style.display = isTransfer ? 'block' : 'none';
    document.getElementById('infoCOD').style.display      = isTransfer ? 'none'  : 'block';
    document.getElementById('opt_transfer').style.border     = isTransfer ? '2px solid var(--accent)' : '2px solid var(--border)';
    document.getElementById('opt_transfer').style.background = isTransfer ? 'var(--accent-dim)' : 'var(--surface2)';
    document.getElementById('opt_cod').style.border          = isTransfer ? '2px solid var(--border)' : '2px solid var(--green)';
    document.getElementById('opt_cod').style.background      = isTransfer ? 'var(--surface2)' : 'rgba(34,197,94,.1)';
    document.getElementById('btnPesan').textContent = isTransfer
        ? '🏦 Pesan & Lanjut Transfer'
        : '💵 Pesan dengan COD';
}

document.querySelectorAll('.modal-overlay').forEach(el => {
    el.addEventListener('click', e => { if (e.target === el) el.classList.remove('open'); });
});
</script>