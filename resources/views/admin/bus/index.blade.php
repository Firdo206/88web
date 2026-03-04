<x-admin-layout title="Manajemen Bus">

    <div class="card-header" style="background:var(--surface);border-radius:16px 16px 0 0;margin-bottom:0;border:1px solid var(--border);border-bottom:none">
        <div class="card-title">🚌 Daftar Armada Bus ({{ $buses->count() }})</div>
        <button class="btn btn-primary" onclick="document.getElementById('modalTambah').classList.add('open')">
            + Tambah Bus
        </button>
    </div>

    <div class="card" style="border-radius:0 0 16px 16px">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Bus</th>
                        <th>Rute</th>
                        <th>Berangkat</th>
                        <th>Harga</th>
                        <th>Tipe</th>
                        <th>Kapasitas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($buses as $bus)
                    <tr>
                        <td>
                            <div style="font-weight:600">{{ $bus->emoji }} {{ $bus->nama }}</div>
                            <div style="font-size:12px;color:var(--text3)">{{ $bus->plat }}</div>
                        </td>
                        <td>
                            <div style="font-size:13px">{{ $bus->asal }}</div>
                            <div style="font-size:12px;color:var(--text3)">→ {{ $bus->tujuan }}</div>
                        </td>
                        <td style="font-size:13px">{{ \Carbon\Carbon::parse($bus->jam_berangkat)->format('H:i') }}</td>
                        <td style="font-weight:700;color:var(--accent)">{{ $bus->harga_format }}</td>
                        <td><span class="badge badge-blue">{{ $bus->tipe }}</span></td>
                        <td style="font-size:13px">{{ $bus->kapasitas }} kursi</td>
                        <td>
                            <span class="badge {{ $bus->status === 'Aktif' ? 'badge-success' : 'badge-danger' }}">
                                {{ $bus->status }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;gap:6px">
                                <button class="btn btn-warning btn-sm"
                                    onclick="openEdit({{ $bus->toJson() }})">✏️</button>
                                <form method="POST" action="{{ route('admin.bus.destroy', $bus) }}"
                                      onsubmit="return confirm('Hapus bus {{ $bus->nama }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8">
                        <div class="empty-state">
                            <div class="empty-state-icon">🚌</div>
                            <div>Belum ada bus. Tambahkan sekarang!</div>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Tambah --}}
    <div class="modal-overlay" id="modalTambah">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title">➕ Tambah Bus Baru</div>
                <button class="modal-close" onclick="document.getElementById('modalTambah').classList.remove('open')">✕</button>
            </div>
            <form method="POST" action="{{ route('admin.bus.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Nama Bus</label>
                            <input name="nama" placeholder="Sinar Jaya Eksekutif" required>
                        </div>
                        <div class="form-group">
                            <label>Plat Nomor</label>
                            <input name="plat" placeholder="B 1234 SJ">
                        </div>
                        <div class="form-group">
                            <label>Kota Asal</label>
                            <input name="asal" placeholder="Jakarta" required>
                        </div>
                        <div class="form-group">
                            <label>Kota Tujuan</label>
                            <input name="tujuan" placeholder="Bandung" required>
                        </div>
                        <div class="form-group">
                            <label>Jam Berangkat</label>
                            <input name="jam_berangkat" type="time" required>
                        </div>
                        <div class="form-group">
                            <label>Harga (Rp)</label>
                            <input name="harga" type="number" placeholder="150000" required>
                        </div>
                        <div class="form-group">
                            <label>Kapasitas Kursi</label>
                            <input name="kapasitas" type="number" value="40" required>
                        </div>
                        <div class="form-group">
                            <label>Tipe Bus</label>
                            <select name="tipe" required>
                                <option value="Ekonomi">Ekonomi</option>
                                <option value="Eksekutif" selected>Eksekutif</option>
                                <option value="Super Eksekutif">Super Eksekutif</option>
                                <option value="Sleeper">Sleeper</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Label Promo</label>
                            <input name="promo" placeholder="HEMAT15%">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="form-group full">
                            <label>Fasilitas</label>
                            <input name="fasilitas" placeholder="AC, WiFi, Toilet, Snack">
                        </div>
                        <div class="form-group full">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" placeholder="Deskripsi singkat armada..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost"
                        onclick="document.getElementById('modalTambah').classList.remove('open')">Batal</button>
                    <button type="submit" class="btn btn-primary">💾 Simpan Bus</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal-overlay" id="modalEdit">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title">✏️ Edit Bus</div>
                <button class="modal-close" onclick="document.getElementById('modalEdit').classList.remove('open')">✕</button>
            </div>
            <form method="POST" id="formEdit">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Nama Bus</label>
                            <input name="nama" id="e_nama" required>
                        </div>
                        <div class="form-group">
                            <label>Plat Nomor</label>
                            <input name="plat" id="e_plat">
                        </div>
                        <div class="form-group">
                            <label>Kota Asal</label>
                            <input name="asal" id="e_asal" required>
                        </div>
                        <div class="form-group">
                            <label>Kota Tujuan</label>
                            <input name="tujuan" id="e_tujuan" required>
                        </div>
                        <div class="form-group">
                            <label>Jam Berangkat</label>
                            <input name="jam_berangkat" id="e_jam" type="time" required>
                        </div>
                        <div class="form-group">
                            <label>Harga (Rp)</label>
                            <input name="harga" id="e_harga" type="number" required>
                        </div>
                        <div class="form-group">
                            <label>Kapasitas Kursi</label>
                            <input name="kapasitas" id="e_kapasitas" type="number" required>
                        </div>
                        <div class="form-group">
                            <label>Tipe Bus</label>
                            <select name="tipe" id="e_tipe" required>
                                <option value="Ekonomi">Ekonomi</option>
                                <option value="Eksekutif">Eksekutif</option>
                                <option value="Super Eksekutif">Super Eksekutif</option>
                                <option value="Sleeper">Sleeper</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Label Promo</label>
                            <input name="promo" id="e_promo">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" id="e_status" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="form-group full">
                            <label>Fasilitas</label>
                            <input name="fasilitas" id="e_fasilitas">
                        </div>
                        <div class="form-group full">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" id="e_deskripsi"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost"
                        onclick="document.getElementById('modalEdit').classList.remove('open')">Batal</button>
                    <button type="submit" class="btn btn-primary">💾 Update Bus</button>
                </div>
            </form>
        </div>
    </div>

<script>
function openEdit(bus) {
    document.getElementById('formEdit').action = '/admin/bus/' + bus.id;
    document.getElementById('e_nama').value      = bus.nama;
    document.getElementById('e_plat').value      = bus.plat ?? '';
    document.getElementById('e_asal').value      = bus.asal;
    document.getElementById('e_tujuan').value    = bus.tujuan;
    document.getElementById('e_jam').value       = bus.jam_berangkat;
    document.getElementById('e_harga').value     = bus.harga;
    document.getElementById('e_kapasitas').value = bus.kapasitas;
    document.getElementById('e_tipe').value      = bus.tipe;
    document.getElementById('e_promo').value     = bus.promo ?? '';
    document.getElementById('e_status').value    = bus.status;
    document.getElementById('e_fasilitas').value = bus.fasilitas ?? '';
    document.getElementById('e_deskripsi').value = bus.deskripsi ?? '';
    document.getElementById('modalEdit').classList.add('open');
}

// Close on overlay click
document.querySelectorAll('.modal-overlay').forEach(el => {
    el.addEventListener('click', e => { if(e.target === el) el.classList.remove('open'); });
});
</script>

</x-admin-layout>