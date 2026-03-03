<x-admin-layout title="Manajemen Bus" subtitle="Kelola Armada">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 style="font-family:'Syne',sans-serif; font-size:20px; font-weight:800">Manajemen Bus</h2>
            <p class="text-muted text-sm" style="margin-top:4px">Kelola armada dan informasi bus</p>
        </div>
        <button class="btn btn-primary" onclick="document.getElementById('modalTambah').classList.add('open')">
            + Tambah Bus
        </button>
    </div>

    @if($buses->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">🚌</div>
            <p>Belum ada bus. Tambahkan bus pertama!</p>
        </div>
    @else
        <div class="bus-grid">
            @foreach($buses as $bus)
            <div class="bus-card">
                <div class="bus-card-img">
                    <span style="font-size:52px">{{ $bus->emoji }}</span>
                    @if($bus->promo)
                        <div class="bus-card-promo">{{ $bus->promo }}</div>
                    @endif
                    <div style="position:absolute; top:10px; left:10px">
                        <span class="badge {{ $bus->status === 'Aktif' ? 'badge-success' : 'badge-gray' }}">
                            {{ $bus->status }}
                        </span>
                    </div>
                </div>
                <div class="bus-card-body">
                    <div class="bus-card-name">{{ $bus->nama }}</div>
                    <div style="font-size:13px; color:var(--text2); margin-bottom:6px">
                        📍 {{ $bus->asal }} → {{ $bus->tujuan }}
                    </div>
                    <div style="font-size:12px; color:var(--text3); margin-bottom:6px">
                        🕐 {{ $bus->jam_berangkat }}
                        &nbsp;|&nbsp; 💺 {{ $bus->kapasitas }} kursi
                        &nbsp;|&nbsp; 🏷️ {{ $bus->tipe }}
                    </div>
                    <div style="font-size:12px; color:var(--text2); margin-bottom:8px">
                        🎯 {{ $bus->fasilitas }}
                    </div>
                    <div style="font-size:13px; color:var(--text2); line-height:1.5">
                        {{ Str::limit($bus->deskripsi, 80) }}
                    </div>
                </div>
                <div class="bus-card-footer">
                    <div class="bus-price">{{ $bus->harga_format }}</div>
                    <div style="display:flex; gap:6px">
                        <button class="btn btn-ghost btn-sm" onclick="openEditModal(
                            {{ $bus->id }},
                            '{{ addslashes($bus->nama) }}',
                            '{{ $bus->plat }}',
                            '{{ $bus->asal }}',
                            '{{ $bus->tujuan }}',
                            '{{ substr($bus->jam_berangkat, 0, 5) }}',
                            {{ $bus->harga }},
                            {{ $bus->kapasitas }},
                            '{{ $bus->tipe }}',
                            '{{ addslashes($bus->fasilitas) }}',
                            '{{ addslashes($bus->deskripsi) }}',
                            '{{ $bus->promo }}',
                            '{{ $bus->status }}'
                        )">✏️ Edit</button>

                        <form method="POST" action="{{ route('admin.bus.destroy', $bus) }}"
                              onsubmit="return confirm('Hapus bus {{ addslashes($bus->nama) }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">🗑️</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

    {{-- ── Modal Tambah Bus ── --}}
    <div class="modal-overlay" id="modalTambah">
        <div class="modal">
            <div class="modal-header">
                <span class="modal-title">🚌 Tambah Bus Baru</span>
                <button class="modal-close" onclick="document.getElementById('modalTambah').classList.remove('open')">✕</button>
            </div>
            <form method="POST" action="{{ route('admin.bus.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Nama Bus *</label>
                            <input name="nama" required placeholder="Sinar Jaya Eksekutif" value="{{ old('nama') }}">
                        </div>
                        <div class="form-group">
                            <label>Nomor Plat</label>
                            <input name="plat" placeholder="B 1234 XY" value="{{ old('plat') }}">
                        </div>
                        <div class="form-group">
                            <label>Kota Asal *</label>
                            <input name="asal" required placeholder="Jakarta" value="{{ old('asal') }}">
                        </div>
                        <div class="form-group">
                            <label>Kota Tujuan *</label>
                            <input name="tujuan" required placeholder="Bandung" value="{{ old('tujuan') }}">
                        </div>
                        <div class="form-group">
                            <label>Jam Berangkat</label>
                            <input type="time" name="jam_berangkat" value="{{ old('jam_berangkat', '08:00') }}">
                        </div>
                        <div class="form-group">
                            <label>Harga Tiket (Rp) *</label>
                            <input type="number" name="harga" required placeholder="150000" value="{{ old('harga') }}">
                        </div>
                        <div class="form-group">
                            <label>Kapasitas Kursi</label>
                            <input type="number" name="kapasitas" value="{{ old('kapasitas', 40) }}">
                        </div>
                        <div class="form-group">
                            <label>Tipe Bus</label>
                            <select name="tipe">
                                @foreach(['Ekonomi','Eksekutif','Super Eksekutif','Sleeper'] as $tipe)
                                    <option value="{{ $tipe }}" {{ old('tipe') === $tipe ? 'selected' : '' }}>{{ $tipe }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group full">
                            <label>Fasilitas</label>
                            <input name="fasilitas" placeholder="AC, WiFi, Toilet, Snack" value="{{ old('fasilitas') }}">
                        </div>
                        <div class="form-group full">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" placeholder="Deskripsi lengkap bus ini...">{{ old('deskripsi') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Kode Promo (opsional)</label>
                            <input name="promo" placeholder="HEMAT20%" value="{{ old('promo') }}">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status">
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost"
                        onclick="document.getElementById('modalTambah').classList.remove('open')">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Bus</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── Modal Edit Bus ── --}}
    <div class="modal-overlay" id="modalEdit">
        <div class="modal">
            <div class="modal-header">
                <span class="modal-title">✏️ Edit Bus</span>
                <button class="modal-close" onclick="document.getElementById('modalEdit').classList.remove('open')">✕</button>
            </div>
            <form method="POST" id="editBusForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Nama Bus</label>
                            <input name="nama" id="eNama" required>
                        </div>
                        <div class="form-group">
                            <label>Nomor Plat</label>
                            <input name="plat" id="ePlat">
                        </div>
                        <div class="form-group">
                            <label>Kota Asal</label>
                            <input name="asal" id="eAsal" required>
                        </div>
                        <div class="form-group">
                            <label>Kota Tujuan</label>
                            <input name="tujuan" id="eTujuan" required>
                        </div>
                        <div class="form-group">
                            <label>Jam Berangkat</label>
                            <input type="time" name="jam_berangkat" id="eJam">
                        </div>
                        <div class="form-group">
                            <label>Harga Tiket (Rp)</label>
                            <input type="number" name="harga" id="eHarga" required>
                        </div>
                        <div class="form-group">
                            <label>Kapasitas Kursi</label>
                            <input type="number" name="kapasitas" id="eKapasitas">
                        </div>
                        <div class="form-group">
                            <label>Tipe Bus</label>
                            <select name="tipe" id="eTipe">
                                @foreach(['Ekonomi','Eksekutif','Super Eksekutif','Sleeper'] as $tipe)
                                    <option value="{{ $tipe }}">{{ $tipe }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group full">
                            <label>Fasilitas</label>
                            <input name="fasilitas" id="eFasilitas">
                        </div>
                        <div class="form-group full">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" id="eDeskripsi"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Kode Promo</label>
                            <input name="promo" id="ePromo">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" id="eStatus">
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost"
                        onclick="document.getElementById('modalEdit').classList.remove('open')">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <x-slot name="scripts">
    <script>
    function openEditModal(id, nama, plat, asal, tujuan, jam, harga, kapasitas, tipe, fasilitas, deskripsi, promo, status) {
        document.getElementById('editBusForm').action = '/admin/bus/' + id;
        document.getElementById('eNama').value      = nama;
        document.getElementById('ePlat').value      = plat;
        document.getElementById('eAsal').value      = asal;
        document.getElementById('eTujuan').value    = tujuan;
        document.getElementById('eJam').value       = jam;
        document.getElementById('eHarga').value     = harga;
        document.getElementById('eKapasitas').value = kapasitas;
        document.getElementById('eTipe').value      = tipe;
        document.getElementById('eFasilitas').value = fasilitas;
        document.getElementById('eDeskripsi').value = deskripsi;
        document.getElementById('ePromo').value     = promo;
        document.getElementById('eStatus').value    = status;
        document.getElementById('modalEdit').classList.add('open');
    }
    </script>
    </x-slot>

</x-admin-layout>