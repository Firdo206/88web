<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Halaman Tidak Ditemukan | BusGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@800&family=DM+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root{--bg:#0a0e1a;--surface:#111827;--accent:#f97316;--text:#f1f5f9;--text2:#94a3b8;--border:rgba(255,255,255,0.07)}
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;display:flex;align-items:center;justify-content:center;text-align:center;padding:24px}
        .wrap{max-width:480px}
        .code{font-family:'Syne',sans-serif;font-size:96px;font-weight:800;line-height:1;background:linear-gradient(135deg,var(--accent),#fbbf24);-webkit-background-clip:text;-webkit-text-fill-color:transparent;margin-bottom:16px}
        .icon{font-size:56px;margin-bottom:12px}
        h1{font-family:'Syne',sans-serif;font-size:24px;margin-bottom:10px}
        p{font-size:15px;color:var(--text2);line-height:1.6;margin-bottom:28px}
        .btns{display:flex;gap:12px;justify-content:center;flex-wrap:wrap}
        .btn{padding:11px 22px;border-radius:10px;font-family:'DM Sans',sans-serif;font-size:14px;font-weight:600;text-decoration:none;transition:all .2s;display:inline-flex;align-items:center;gap:6px}
        .btn-p{background:var(--accent);color:#fff}.btn-p:hover{background:#fb923c}
        .btn-g{background:var(--surface);color:var(--text2);border:1px solid var(--border)}.btn-g:hover{color:var(--text)}
    </style>
</head>
<body>
    <div class="wrap">
        <div class="icon">🔍</div>
        <div class="code">404</div>
        <h1>Halaman Tidak Ditemukan</h1>
        <p>Halaman yang Anda cari tidak ada atau sudah dipindahkan.</p>
        <div class="btns">
            @auth
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard') }}" class="btn btn-p">🏠 Ke Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-p">🔑 Login</a>
            @endauth
            <a href="javascript:history.back()" class="btn btn-g">← Kembali</a>
        </div>
    </div>
</body>
</html>