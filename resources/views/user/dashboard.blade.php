<x-user-layout title="Beranda">

    {{-- Banner Promo --}}
    @if($activePromo)
    <div style="background:linear-gradient(135deg,rgba(249,115,22,.2),rgba(251,146,60,.1));border:1px solid rgba(249,115,22,.3);border-radius:16px;padding:20px 24px;margin-bottom:24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px">
        <div>
            <div style="font-size:12px;font-weight:700;color:var(--accent);letter-spacing:1px;text-transform:uppercase;margin-bottom:4px">🔥 Promo Aktif</div>
            <div style="font-family:'Syne',sans-serif;font-size:20px;font-weight:800">{{ $activePromo->nama }}</div>
            <div style="font-size:13px;color:var(--text2);margin-top:2px">{{ $activePromo->deskripsi }} — berlaku hingga {{ $activePromo->berlaku_hingga->format('d M Y') }}</div>
        </div>
        <div style="text-align:center">
            <div style="font-family:'Syne',sans-serif;font-size:40px;font-weight:800;color:var(--accent);line-height:1">{{ $activePromo->diskon }}%</div>
            <div style="font-size:12px;color:var(--text2)">DISKON</div>
            <code style="background:var(--surface);padding:4px 10px;border-radius:8px;font-size:13px;font-weight:700;color:var(--accent);border:1px solid var(--border)">{{ $activePromo->kode }}</code>
        </div>
    </div>
    @endif

    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px">
        <div>
            <h2 style="font-family:'Syne',sans-serif;font-size:20px;font-weight:800">
                Hai, {{ auth()->user()->name }}! 👋
            </h2>
            <p style="font-size:14px;color:var(--text3);margin-top:2px">Bus tersedia hari ini — pilih & pesan tiket Anda</p>
        </div>
        <a href="{{ route('user.bus') }}" class="btn btn-primary">🔍 Cari Bus Lainnya</a>
    </div>

    {{-- Bus Grid --}}
    @if($buses->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">🚌</div>
            <div>Belum ada bus tersedia saat ini</div>
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