{{-- resources/views/user/_modal_pesan.blade.php
     Include di view mana saja yang butuh modal pemesanan:
     @include('user._modal_pesan')
--}}

<div class="modal-overlay" id="modalPesan">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title">🎫 Pesan Tiket</span>
            <button class="modal-close"
                onclick="document.getElementById('modalPesan').classList.remove('open')">✕</button>
        </div>

        <form method="POST" action="{{ route('user.order.store') }}">
            @csrf
            <input type="hidden" name="bus_id" id="pesanBusId">

            <div class="modal-body">

                {{-- Info bus (diisi via JS) --}}
                <div id="pesanBusInfo"
                     style="background:var(--surface2); border-radius:12px; padding:14px; margin-bottom:18px">
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Nama Penumpang *</label>
                        <input name="nama_penumpang"
                               value="{{ auth()->user()->name }}"
                               required>
                    </div>
                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input name="telepon" placeholder="0812-xxxx-xxxx">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Berangkat *</label>
                        <input type="date" name="tanggal_berangkat" required
                               min="{{ date('Y-m-d') }}"
                               value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="form-group">
                        <label>Jumlah Kursi *</label>
                        <select name="jumlah_kursi">
                            @for($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}">{{ $i }} kursi</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group full">
                        <label>Catatan (opsional)</label>
                        <textarea name="catatan" placeholder="Permintaan khusus..."></textarea>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-ghost"
                    onclick="document.getElementById('modalPesan').classList.remove('open')">
                    Batal
                </button>
                <button type="submit" class="btn btn-primary">🎫 Beli Tiket</button>
            </div>
        </form>
    </div>
</div>

<x-slot name="scripts">
<script>
/**
 * Buka modal pemesanan dan isi info bus secara dinamis.
 * Dipanggil dari tombol "Pesan" di bus-card.
 */
function openPesanModal(id, nama, asal, tujuan, jam, harga, emoji) {
    document.getElementById('pesanBusId').value = id;
    document.getElementById('pesanBusInfo').innerHTML = `
        <div style="display:flex; align-items:center; gap:12px">
            <span style="font-size:36px">${emoji}</span>
            <div>
                <div style="font-family:'Syne',sans-serif; font-weight:700; font-size:15px">${nama}</div>
                <div style="font-size:13px; color:var(--text2)">
                    ${asal} → ${tujuan} &nbsp;|&nbsp; 🕐 ${jam}
                </div>
                <div style="font-size:14px; color:var(--accent); font-weight:700; margin-top:2px">
                    ${harga} / kursi
                </div>
            </div>
        </div>
    `;
    document.getElementById('modalPesan').classList.add('open');
}
</script>
</x-slot>