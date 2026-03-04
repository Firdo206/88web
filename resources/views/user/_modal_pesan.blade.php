{{-- Modal Pesan Tiket (di-include di dashboard & bus) --}}
<div class="modal-overlay" id="modalPesan">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title" id="modalBusName">🎫 Pesan Tiket</div>
            <button class="modal-close" onclick="document.getElementById('modalPesan').classList.remove('open')">✕</button>
        </div>
        <form method="POST" action="{{ route('user.order.store') }}">
            @csrf
            <input type="hidden" name="bus_id" id="inputBusId">
            <div class="modal-body">

                {{-- Info Bus --}}
                <div id="busInfo" style="background:var(--surface2);border-radius:12px;padding:14px;margin-bottom:18px;font-size:13px">
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
                        <input name="nama_penumpang" value="{{ auth()->user()->name }}" required
                               placeholder="Nama lengkap penumpang">
                        @error('nama_penumpang')
                            <span style="color:var(--red);font-size:12px">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Nomor Telepon</label>
                        <input name="telepon" type="tel" placeholder="08xxxxxxxxxx">
                        @error('telepon')
                            <span style="color:var(--red);font-size:12px">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Tanggal Berangkat</label>
                        <input name="tanggal_berangkat" type="date"
                               min="{{ date('Y-m-d') }}" required>
                        @error('tanggal_berangkat')
                            <span style="color:var(--red);font-size:12px">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Jumlah Kursi</label>
                        <input name="jumlah_kursi" type="number" min="1" max="10" value="1"
                               required id="inputKursi" oninput="hitungTotal()">
                        @error('jumlah_kursi')
                            <span style="color:var(--red);font-size:12px">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group full">
                        <label>Catatan (opsional)</label>
                        <textarea name="catatan" placeholder="Permintaan khusus, kebutuhan kursi, dll..."></textarea>
                    </div>
                </div>

                {{-- Total --}}
                <div style="background:var(--accent-dim);border:1px solid rgba(249,115,22,.2);border-radius:12px;padding:14px;margin-top:4px;display:flex;justify-content:space-between;align-items:center">
                    <span style="font-size:14px;color:var(--text2)">Total Pembayaran</span>
                    <span id="totalHarga" style="font-family:'Syne',sans-serif;font-size:20px;font-weight:800;color:var(--accent)">Rp 0</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost"
                    onclick="document.getElementById('modalPesan').classList.remove('open')">Batal</button>
                <button type="submit" class="btn btn-primary">🎫 Konfirmasi Pesan</button>
            </div>
        </form>
    </div>
</div>

<script>
let busHarga = 0;

function openPesan(bus) {
    busHarga = bus.harga;
    document.getElementById('inputBusId').value  = bus.id;
    document.getElementById('modalBusName').textContent = '🎫 Pesan — ' + bus.nama;
    document.getElementById('infoBusRute').textContent  = bus.asal + ' → ' + bus.tujuan;
    document.getElementById('infoBusJam').textContent   = bus.jam_berangkat;
    document.getElementById('infoBusTipe').textContent  = bus.tipe;
    document.getElementById('infoBusHarga').textContent = 'Rp ' + Number(bus.harga).toLocaleString('id-ID');
    document.getElementById('inputKursi').value = 1;
    hitungTotal();
    document.getElementById('modalPesan').classList.add('open');
}

function hitungTotal() {
    const kursi = parseInt(document.getElementById('inputKursi').value) || 1;
    const total = busHarga * kursi;
    document.getElementById('totalHarga').textContent = 'Rp ' + total.toLocaleString('id-ID');
}

document.querySelectorAll('.modal-overlay').forEach(el => {
    el.addEventListener('click', e => { if(e.target === el) el.classList.remove('open'); });
});
</script>