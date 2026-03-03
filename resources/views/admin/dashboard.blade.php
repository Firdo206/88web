<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — {{ $title ?? 'Dashboard' }} | BusGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <x-styles />
</head>
<body>
<div style="display:flex; min-height:100vh">

    {{-- ═══════════════════════════════
         SIDEBAR
    ═══════════════════════════════ --}}
    <aside class="sidebar" id="sidebar">

        <div class="sidebar-header">
            <div class="logo-icon">🚌</div>
            <div class="logo-text">Bus<span>Go</span>&nbsp;<small style="font-size:10px;opacity:.5;font-weight:400">Admin</small></div>
            <button class="sidebar-toggle" onclick="toggleSidebar()">
                <svg id="toggleIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
            </button>
        </div>

        <nav class="sidebar-nav">

            <div class="nav-section">
                <div class="nav-label">UTAMA</div>

                <a href="{{ route('admin.dashboard') }}"
                   class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                   data-tooltip="Dashboard">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                            <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                        </svg>
                    </span>
                    <span class="nav-text">Dashboard</span>
                </a>

                <a href="{{ route('admin.bus.index') }}"
                   class="nav-item {{ request()->routeIs('admin.bus.*') ? 'active' : '' }}"
                   data-tooltip="Manajemen Bus">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="7" width="20" height="14" rx="2"/>
                            <path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/>
                            <line x1="12" y1="12" x2="12" y2="16"/>
                            <line x1="10" y1="14" x2="14" y2="14"/>
                        </svg>
                    </span>
                    <span class="nav-text">Manajemen Bus</span>
                </a>

                <a href="{{ route('admin.promo.index') }}"
                   class="nav-item {{ request()->routeIs('admin.promo.*') ? 'active' : '' }}"
                   data-tooltip="Promo">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/>
                            <line x1="7" y1="7" x2="7.01" y2="7"/>
                        </svg>
                    </span>
                    <span class="nav-text">Promo & Diskon</span>
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-label">PEMESANAN</div>

                <a href="{{ route('admin.orders.index') }}"
                   class="nav-item {{ request()->routeIs('admin.orders.index') || request()->routeIs('admin.orders.show') ? 'active' : '' }}"
                   data-tooltip="Pesanan Masuk">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                            <rect x="9" y="3" width="6" height="4" rx="1"/>
                        </svg>
                    </span>
                    <span class="nav-text">Pesanan Masuk</span>
                    @php $pendingCount = \App\Models\Order::where('status','pending')->count(); @endphp
                    @if($pendingCount > 0)
                        <span class="nav-badge">{{ $pendingCount }}</span>
                    @endif
                </a>

                <a href="{{ route('admin.orders.history') }}"
                   class="nav-item {{ request()->routeIs('admin.orders.history') ? 'active' : '' }}"
                   data-tooltip="Riwayat">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </span>
                    <span class="nav-text">Riwayat Pesanan</span>
                </a>
            </div>

        </nav>

        <div class="sidebar-user">
            <div class="sidebar-user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                <div class="sidebar-user-role">Super Admin</div>
            </div>
        </div>

    </aside>

    {{-- ═══════════════════════════════
         MAIN CONTENT
    ═══════════════════════════════ --}}
    <div class="main" id="mainContent">

        {{-- Topbar --}}
        <div class="topbar">
            <div class="topbar-title">
                {{ $title ?? 'Dashboard' }}
                @isset($subtitle)
                    <span>/ {{ $subtitle }}</span>
                @endisset
            </div>
            <div class="topbar-right">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-ghost btn-sm">Logout</button>
                </form>
                <div class="topbar-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </div>

        {{-- Content --}}
        <div class="content">

            @if(session('success'))
                <div class="alert alert-success" id="flashAlert">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error" id="flashAlert">❌ {{ session('error') }}</div>
            @endif

            {{ $slot }}

        </div>
    </div>

</div>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const main    = document.getElementById('mainContent');
    const icon    = document.getElementById('toggleIcon');

    sidebar.classList.toggle('collapsed');
    main.classList.toggle('collapsed');

    const isCollapsed = sidebar.classList.contains('collapsed');
    icon.innerHTML    = isCollapsed
        ? '<path d="M9 18l6-6-6-6"/>'
        : '<path d="M15 18l-6-6 6-6"/>';

    localStorage.setItem('adminSidebarCollapsed', isCollapsed);
}

// Restore sidebar state
document.addEventListener('DOMContentLoaded', () => {
    if (localStorage.getItem('adminSidebarCollapsed') === 'true') {
        document.getElementById('sidebar').classList.add('collapsed');
        document.getElementById('mainContent').classList.add('collapsed');
        document.getElementById('toggleIcon').innerHTML = '<path d="M9 18l6-6-6-6"/>';
    }

    // Auto-dismiss flash alert
    const alert = document.getElementById('flashAlert');
    if (alert) setTimeout(() => alert.style.display = 'none', 4000);

    // Close modal when clicking backdrop
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', e => {
            if (e.target === overlay) overlay.classList.remove('open');
        });
    });
});
</script>

{{ $scripts ?? '' }}


<x-admin-layout title="Dashboard" subtitle="Ringkasan">

    {{-- Stats Cards --}}
    <div class="stats-grid">
        <div class="stat-card orange">
            <div class="stat-icon orange">🚌</div>
            <div class="stat-value">{{ $totalBus }}</div>
            <div class="stat-label">Total Armada Bus</div>
        </div>
        <div class="stat-card green">
            <div class="stat-icon green">🎫</div>
            <div class="stat-value">{{ $totalPesanan }}</div>
            <div class="stat-label">Total Pesanan</div>
        </div>
        <div class="stat-card blue">
            <div class="stat-icon blue">💰</div>
            <div class="stat-value">Rp {{ number_format($pendapatan / 1000000, 1) }}jt</div>
            <div class="stat-label">Total Pendapatan</div>
        </div>
        <div class="stat-card yellow">
            <div class="stat-icon yellow">⏳</div>
            <div class="stat-value">{{ $pendingPesanan }}</div>
            <div class="stat-label">Menunggu Konfirmasi</div>
            @if($pendingPesanan > 0)
                <div class="stat-change down">↓ perlu segera dikonfirmasi</div>
            @endif
        </div>
    </div>

    {{-- Recent Orders & Popular Bus --}}
    <div class="grid-2">

        <div class="card">
            <div class="card-header">
                <span class="card-title">🎫 Pesanan Terbaru</span>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost btn-sm">Lihat Semua</a>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr><th>Penumpang</th><th>Rute</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td>
                                <div style="font-weight:600; font-size:13px">{{ $order->nama_penumpang }}</div>
                            </td>
                            <td style="font-size:12px; color:var(--text2)">
                                {{ $order->bus->asal }} → {{ $order->bus->tujuan }}
                            </td>
                            <td>
                                <span class="badge {{ $order->status_class }}">{{ $order->status_label }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" style="text-align:center; padding:24px; color:var(--text3)">
                                Belum ada pesanan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <span class="card-title">🚌 Bus Populer</span>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr><th>Nama Bus</th><th>Rute</th><th>Tiket</th></tr>
                    </thead>
                    <tbody>
                        @forelse($popularBus as $i => $bus)
                        <tr>
                            <td style="font-weight:600; font-size:13px">
                                {{ ['🥇','🥈','🥉','4️⃣','5️⃣'][$i] ?? ($i + 1).'.' }}
                                {{ $bus->nama }}
                            </td>
                            <td style="font-size:12px; color:var(--text2)">
                                {{ $bus->asal }} → {{ $bus->tujuan }}
                            </td>
                            <td style="font-weight:700; color:var(--green)">{{ $bus->orders_count }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" style="text-align:center; padding:24px; color:var(--text3)">
                                Belum ada data
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</x-admin-layout>
</body>
</html>