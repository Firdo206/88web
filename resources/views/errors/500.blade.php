<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 — Server Error | BusGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@800&family=DM+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root{--bg:#0a0e1a;--surface:#111827;--accent:#f97316;--text:#f1f5f9;--text2:#94a3b8;--border:rgba(255,255,255,0.07)}
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;display:flex;align-items:center;justify-content:center;text-align:center;padding:24px}
        .wrap{max-width:480px}
        .code{font-family:'Syne',sans-serif;font-size:96px;font-weight:800;line-height:1;background:linear-gradient(135deg,#6366f1,#a78bfa);-webkit-background-clip:text;-webkit-text-fill-color:transparent;margin-bottom:16px}
        .icon{font-size:56px;margin-bottom:12px}
        h1{font-family:'Syne',sans-serif;font-size:24px;margin-bottom:10px}
        p{font-size:15px;color:var(--text2);line-height:1.6;margin-bottom:28px}
        .btns{display:flex;gap:12px;justify-content:center}
        .btn{padding:11px 22px;border-radius:10px;font-family:'DM Sans',sans-serif;font-size:14px;font-weight:600;text-decoration:none;transition:all .2s}
        .btn-p{background:var(--accent);color:#fff}.btn-p:hover{background:#fb923c}
        .btn-g{background:var(--surface);color:var(--text2);border:1px solid var(--border)}.btn-g:hover{color:var(--text)}
    </style>
</head>
<body>
    <div class="wrap">
        <div class="icon">💥</div>
        <div class="code">500</div>
        <h1>Terjadi Kesalahan Server</h1>
        <p>Server sedang mengalami gangguan. Tim kami sedang memperbaikinya.</p>
        <div class="btns">
            <a href="{{ url('/') }}" class="btn btn-p">🏠 Kembali</a>
            <a href="javascript:location.reload()" class="btn btn-g">🔄 Refresh</a>
        </div>
    </div>
</body>
</html>