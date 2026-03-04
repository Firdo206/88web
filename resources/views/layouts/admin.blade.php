<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin' }} | BusGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <x-styles />
</head>
<body>
<div class="flex">

    {{-- ═══════════ SIDEBAR ═══════════ --}}
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon">🚌</div>
            <div class="logo-text">Bus<span>Go</span></div>
            <button class="sidebar-toggle" id="sidebarToggle" title="Toggle sidebar">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-label">Menu Utama</div>

                <a href="{{ route('admin.dashboard') }}"
                   class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                   data-tooltip="Dashboard">
                    <span class="nav-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </span>
                    <span class="nav-text">Dashboard</span>
                </a>

                <a href="{{ route('admin.bus.index') }}"
                   class="nav-item {{ request()->routeIs('admin.bus.*') ? 'active' : '' }}"
                   data-tooltip="Manajemen Bus">
                    <span class="nav-icon">🚌</span>
                    <span class="nav-text">Manajemen Bus</span>
                </a>

                <a href="{{ route('admin.promo.index') }}"
                   class="nav-item {{ request()->routeIs('admin.promo.*') ? 'active' : '' }}"
                   data-tooltip="Promo">
                    <span class="nav-icon">🎁</span>
                    <span class="nav-text">Promo & Diskon</span>
                </a>

                <a href="{{ route('admin.orders.index') }}"
                   class="nav-item {{ request()->routeIs('admin.orders.index') || request()->routeIs('admin.orders.show') ? 'active' : '' }}"
                   data-tooltip="Pesanan">
                    <span class="nav-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </span>
                    <span class="nav-text">Pesanan Masuk</span>
                    @php $pending = \App\Models\Order::where('status','pending')->count(); @endphp
                    @if($pending > 0)
                        <span class="nav-badge">{{ $pending }}</span>
                    @endif
                </a>

                <a href="{{ route('admin.orders.history') }}"
                   class="nav-item {{ request()->routeIs('admin.orders.history') ? 'active' : '' }}"
                   data-tooltip="Riwayat">
                    <span class="nav-icon">📋</span>
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
                <div class="sidebar-user-role">Administrator</div>
            </div>
        </div>
    </aside>

    {{-- ═══════════ MAIN CONTENT ═══════════ --}}
    <div class="main" id="main">
        <header class="topbar">
            <div class="topbar-title">
                {{ $title ?? 'Dashboard' }}
                @isset($subtitle)
                    <span>/ {{ $subtitle }}</span>
                @endisset
            </div>
            <div class="topbar-right">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-ghost btn-sm">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </header>

        <main class="content">
            @if(session('success'))
                <div class="alert alert-success">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">❌ {{ session('error') }}</div>
            @endif

            {{ $slot }}
        </main>
    </div>
</div>

<script>
    const sidebar  = document.getElementById('sidebar');
    const main     = document.getElementById('main');
    const toggle   = document.getElementById('sidebarToggle');
    const STORAGE  = 'busgo_sidebar_collapsed';

    function applyState(collapsed) {
        sidebar.classList.toggle('collapsed', collapsed);
        main.classList.toggle('collapsed', collapsed);
        localStorage.setItem(STORAGE, collapsed);
    }

    // Restore on load
    applyState(localStorage.getItem(STORAGE) === 'true');

    toggle.addEventListener('click', () => {
        applyState(!sidebar.classList.contains('collapsed'));
    });
</script>
</body>
</html>