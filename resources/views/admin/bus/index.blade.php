<x-user-layout title="Cari Bus" subtitle="Temukan Bus">

    {{-- Form Pencarian --}}
    <div class="card mb-6">
        <div class="card-header">
            <span class="card-title">🔍 Filter Bus</span>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('user.bus') }}">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Kota Asal</label>
                        <select name="asal">
                            <option value="">Semua Kota</option>
                            @foreach($kotaList as $kota)
                                <option value="{{ $kota }}" {{ request('asal') === $kota ? 'selected' : '' }}>
                                    {{ $kota }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kota Tujuan</label>
                        <select name="tujuan">
                            <option value="">Semua Kota</option>
                            @foreach($kotaList as $kota)
                                <option value="{{ $kota }}" {{ request('tujuan') === $kota ? 'selected' : '' }}>
                                    {{ $kota }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div style="margin-top:16px; display:flex; gap:8px">
                    <button type="submit" class="btn btn-primary">🔍 Cari</button>
                    @if(request()->hasAny(['asal','tujuan']))
                        <a href="{{ route('user.bus') }}" class="btn btn-ghost">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="flex items-center justify-between mb-4">
        <h3 style="font-family:'Syne',sans-serif; font-size:17px; font-weight:700">
            {{ $buses->count() }} Bus Tersedia
        </h3>
    </div>

    @if($buses->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">🔍</div>
            <p>Tidak ada bus untuk rute yang dicari.</p>
        </div>
    @else
        <div class="bus-grid">
            @foreach($buses as $bus)
            <div class="bus-card">
                <div class="bus-card-img">
                    <span style="font-size:52px">{{ $bus->emoji }}</span>
                    @if($bus->promo)<div class="bus-card-promo">{{ $bus->promo }}</div>@endif
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
                        {{ Str::limit($bus->deskripsi, 90) }}
                    </div>
                </div>
                <div class="bus-card-footer">
                    <div class="bus-price">{{ $bus->harga_format }}</div>
                    <button class="btn btn-primary btn-sm" onclick="openPesanModal(
                        {{ $bus->id }},
                        '{{ addslashes($bus->nama) }}',
                        '{{ $bus->asal }}',
                        '{{ $bus->tujuan }}',
                        '{{ substr($bus->jam_berangkat, 0, 5) }}',
                        '{{ $bus->harga_format }}',
                        '{{ $bus->emoji }}'
                    )">🎫 Pesan</button>
                </div>
            </div>
            @endforeach
        </div>
    @endif

    @include('user._modal_pesan')

</x-user-layout>