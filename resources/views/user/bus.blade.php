<x-user-layout title="Cari Bus">

    {{-- Filter --}}
    <form method="GET" action="{{ route('user.bus') }}"
          style="background:var(--surface);border:1px solid var(--border);border-radius:16px;padding:20px;margin-bottom:24px">
        <div style="display:grid;grid-template-columns:1fr 1fr auto;gap:12px;align-items:end">
            <div class="form-group">
                <label>Kota Asal</label>
                <select name="asal">
                    <option value="">Semua Kota Asal</option>
                    @foreach($kotaList as $kota)
                        <option value="{{ $kota }}" {{ request('asal') == $kota ? 'selected' : '' }}>{{ $kota }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Kota Tujuan</label>
                <select name="tujuan">
                    <option value="">Semua Kota Tujuan</option>
                    @foreach($kotaList as $kota)
                        <option value="{{ $kota }}" {{ request('tujuan') == $kota ? 'selected' : '' }}>{{ $kota }}</option>
                    @endforeach
                </select>
            </div>
            <div style="display:flex;gap:8px">
                <button type="submit" class="btn btn-primary">🔍 Cari</button>
                <a href="{{ route('user.bus') }}" class="btn btn-ghost">Reset</a>
            </div>
        </div>
    </form>

    {{-- Hasil --}}
    <div style="margin-bottom:16px;font-size:14px;color:var(--text2)">
        Menampilkan <strong style="color:var(--text)">{{ $buses->count() }}</strong> bus tersedia
    </div>

    @if($buses->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">🔍</div>
            <div>Tidak ada bus untuk rute ini</div>
            <a href="{{ route('user.bus') }}" class="btn btn-ghost" style="margin-top:16px">Lihat Semua Bus</a>
        </div>
    @else
    <div class="bus-grid">
        @foreach($buses as $bus)
        <div class="bus-card">
            <div class="bus-card-img">
                {{ $bus->emoji }}
                @if($bus->promo)
                    <div class="bus-card-promo">{{ $bus->promo }}</div>
                @endif
            </div>
            <div class="bus-card-body">
                <div class="bus-card-name">{{ $bus->nama }}</div>
                <div style="font-size:13px;color:var(--text2);margin-bottom:8px">
                    {{ $bus->asal }} → {{ $bus->tujuan }}
                </div>
                <div style="font-size:12px;color:var(--text3);display:flex;gap:12px;flex-wrap:wrap">
                    <span>🕐 {{ \Carbon\Carbon::parse($bus->jam_berangkat)->format('H:i') }}</span>
                    <span>💺 {{ $bus->kapasitas }} kursi</span>
                    <span>🏷️ {{ $bus->tipe }}</span>
                </div>
                @if($bus->fasilitas)
                <div style="font-size:11px;color:var(--text3);margin-top:6px">✨ {{ $bus->fasilitas }}</div>
                @endif
                @if($bus->deskripsi)
                <div style="font-size:12px;color:var(--text3);margin-top:6px;line-height:1.5">{{ $bus->deskripsi }}</div>
                @endif
            </div>
            <div class="bus-card-footer">
                <div class="bus-price">{{ $bus->harga_format }}</div>
                <button class="btn btn-primary btn-sm"
                    onclick="openPesan({{ $bus->toJson() }})">Pesan</button>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    @include('user._modal_pesan')

</x-user-layout>