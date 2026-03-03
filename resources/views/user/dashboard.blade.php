<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} | BusGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <x-styles />
    <style>
        /* ── User-specific styles ───────────── */
        .user-hero {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            border: 1px solid var(--border);
            border-radius: 20px; padding: 32px;
            margin-bottom: 24px;
            display: flex; align-items: center; gap: 24px;
            position: relative; overflow: hidden;
        }
        .user-hero::after {
            content: '🚌';
            position: absolute; right: 40px; top: 50%;
            transform: translateY(-50%);
            font-size: 80px; opacity: .1;
        }
        .user-avatar {
            width: 56px; height: 56px; border-radius: 14px;
            background: var(--accent);
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; font-weight: 800; flex-shrink: 0;
        }
        .promo-banner {
            background: linear-gradient(135deg, #f97316, #ea580c 50%, #c2410c);
            border-radius: 16px; padding: 24px 28px;
            display: flex; align-items: center; gap: 20px;
            margin-bottom: 24px; position: relative; overflow: hidden;
        }
        .promo-banner::before {
            content: '🎉';
            position: absolute; right: 20px; top: 50%;
            transform: translateY(-50%);
            font-size: 64px; opacity: .2;
        }
        .tabs {
            display: flex; gap: 4px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 22px;
        }
        .tab {
            padding: 10px 16px; font-size: 14px; font-weight: 500;
            color: var(--text3); border: none; background: none;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            margin-bottom: -1px; transition: all .2s;
            font-family: 'DM Sans', sans-serif;
            text-decoration: none; display: inline-block;
        }
        .tab.active { color: var(--accent); border-bottom-color: var(--accent); }
        .tab:hover  { color: var(--text2); }
    </style>
</head>
<body>
<div style="display:flex; min-height:100vh">

    {{-- ═══════════════════════════════
         SIDEBAR
    ═══════════════════════════════ --}}
    <aside class="sidebar" id="sidebar">

        <div class="sidebar-header">
            <div class="logo-icon">🚌</div>
            <div class="logo-text">Bus<span>Go</span></div>
            <button class="sidebar-toggle" onclick="toggleSidebar()">
                <svg id="toggleIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
            </button>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-label">MENU</div>

                <a href="{{ route('user.dashboard') }}"
                   class="nav-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}"
                   data-tooltip="Beranda">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                    </span>
                    <span class="nav-text">Beranda</span>
                </a>

                <a href="{{ route('user.bus') }}"
                   class="nav-item {{ request()->routeIs('user.bus') ? 'active' : '' }}"
                   data-tooltip="Cari Bus">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="m21 21-4.35-4.35"/>
                        </svg>
                    </span>
                    <span class="nav-text">Cari Bus</span>
                </a>

                <a href="{{ route('user.pesanan') }}"
                   class="nav-item {{ request()->routeIs('user.pesanan') ? 'active' : '' }}"
                   data-tooltip="Pesanan Saya">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                            <rect x="9" y="3" width="6" height="4" rx="1"/>
                        </svg>
                    </span>
                    <span class="nav-text">Pesanan Saya</span>
                </a>

                <a href="{{ route('user.riwayat') }}"
                   class="nav-item {{ request()->routeIs('user.riwayat') ? 'active' : '' }}"
                   data-tooltip="Riwayat">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </span>
                    <span class="nav-text">Riwayat Perjalanan</span>
                </a>

            </div>
        </nav>

        <div class="sidebar-user">
            <div class="sidebar-user-avatar" style="background:#3b82f6">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                <div class="sidebar-user-role">Penumpang</div>
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
                {{ $title ?? 'Beranda' }}
                @isset($subtitle)
                    <span>/ {{ $subtitle }}</span>
                @endisset
            </div>
            <div class="topbar-right">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-ghost btn-sm">Logout</button>
                </form>
                <div class="topbar-avatar" style="background:#3b82f6">
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

    localStorage.setItem('userSidebarCollapsed', isCollapsed);
}

document.addEventListener('DOMContentLoaded', () => {
    if (localStorage.getItem('userSidebarCollapsed') === 'true') {
        document.getElementById('sidebar').classList.add('collapsed');
        document.getElementById('mainContent').classList.add('collapsed');
        document.getElementById('toggleIcon').innerHTML = '<path d="M9 18l6-6-6-6"/>';
    }

    const alert = document.getElementById('flashAlert');
    if (alert) setTimeout(() => alert.style.display = 'none', 4000);

    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', e => {
            if (e.target === overlay) overlay.classList.remove('open');
        });
    });
});
</script>

{{ $scripts ?? '' }}

</body>
</html>