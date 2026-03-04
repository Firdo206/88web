<x-admin-layout title="Promo & Diskon">

    <div class="card-header" style="background:var(--surface);border-radius:16px 16px 0 0;border:1px solid var(--border);border-bottom:none">
        <div class="card-title">🎁 Daftar Promo ({{ $promos->count() }})</div>
        <button class="btn btn-primary" onclick="document.getElementById('modalTambah').classList.add('open')">
            + Tambah Promo
        </button>
    </div>

    <div class="card" style="border-radius:0 0 16px 16px">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nama Promo</th>
                        <th>Kode</th>
                        <th>Diskon</th>
                        <th>Berlaku Hingga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($promos as $promo)
                    <tr>
                        <td>
                            <div style="font-weight:600">{{ $promo->nama }}</div>
                            <div style="font-size:12px;color:var(--text3)">{{ $promo->deskripsi }}</div>
                        </td>
                        <td>
                            <code style="background:var(--surface2);padding:3px 8px;border-radius:6px;font-size:12px;color:var(--accent)">
                                {{ $promo->kode }}
                            </code>
                        </td>
                        <td>
                            <span style="font-family:'Syne',sans-serif;font-size:18px;font-weight:800;color:var(--green)">
                                {{ $promo->diskon }}%
                            </span>
                        </td>
                        <td style="font-size:13px">
                            {{ $promo->berlaku_hingga->format('d M Y') }}
                            @if($promo->berlaku_hingga->isPast())
                                <div style="color:var(--red);font-size:11px">⚠️ Sudah kedaluwarsa</div>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $promo->status === 'Aktif' ? 'badge-success' : 'badge-danger' }}">
                                {{ $promo->status }}
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.promo.destroy', $promo) }}"
                                  onsubmit="return confirm('Hapus promo {{ $promo->nama }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">🗑️ Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6">
                        <div class="empty-state">
                            <div class="empty-state-icon">🎁</div>
                            <div>Belum ada promo. Tambahkan sekarang!</div>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Tambah Promo --}}
    <div class="modal-overlay" id="modalTambah">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title">➕ Tambah Promo Baru</div>
                <button class="modal-close" onclick="document.getElementById('modalTambah').classList.remove('open')">✕</button>
            </div>
            <form method="POST" action="{{ route('admin.promo.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Nama Promo</label>
                            <input name="nama" placeholder="Flash Sale Lebaran" required>
                        </div>
                        <div class="form-group">
                            <label>Kode Promo</label>
                            <input name="kode" placeholder="LEBARAN26" required>
                        </div>
                        <div class="form-group">
                            <label>Diskon (%)</label>
                            <input name="diskon" type="number" min="1" max="100" placeholder="20" required>
                        </div>
                        <div class="form-group">
                            <label>Berlaku Hingga</label>
                            <input name="berlaku_hingga" type="date" required>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="form-group full">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" placeholder="Keterangan promo..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost"
                        onclick="document.getElementById('modalTambah').classList.remove('open')">Batal</button>
                    <button type="submit" class="btn btn-primary">💾 Simpan Promo</button>
                </div>
            </form>
        </div>
    </div>

<script>
document.querySelectorAll('.modal-overlay').forEach(el => {
    el.addEventListener('click', e => { if(e.target === el) el.classList.remove('open'); });
});
</script>

</x-admin-layout>