<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar | BusGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <x-styles />
    <style>
        body { display:flex; align-items:center; justify-content:center; min-height:100vh; padding:24px; }
        .card { background:var(--surface); border:1px solid var(--border); border-radius:24px; padding:40px; width:100%; max-width:420px; box-shadow:0 24px 80px rgba(0,0,0,.4); }
        .logo { display:flex; align-items:center; gap:10px; margin-bottom:32px; }
        .logo-icon-big { width:44px; height:44px; background:var(--accent); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:22px; }
        .logo-name { font-family:'Syne',sans-serif; font-size:24px; font-weight:800; }
        .logo-name span { color:var(--accent); }
        h1 { font-family:'Syne',sans-serif; font-size:22px; margin-bottom:6px; }
        .sub { font-size:14px; color:var(--text3); margin-bottom:28px; }
        .link-area { text-align:center; font-size:14px; color:var(--text2); margin-top:20px; }
        .link-area a { color:var(--accent); text-decoration:none; font-weight:600; }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">
            <div class="logo-icon-big">🚌</div>
            <div class="logo-name">Bus<span>Go</span></div>
        </div>

        <h1>Buat Akun Baru</h1>
        <p class="sub">Daftar dan mulai pesan tiket bus.</p>

        <form method="POST" action="{{ route('register.post') }}">
            @csrf
            <div class="form-group" style="margin-bottom:14px">
                <label>Nama Lengkap</label>
                <input name="name" value="{{ old('name') }}" placeholder="Budi Santoso" required autofocus>
                @error('name')
                    <span style="color:var(--red);font-size:12px;margin-top:4px;display:block">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group" style="margin-bottom:14px">
                <label>Email</label>
                <input name="email" type="email" value="{{ old('email') }}" placeholder="budi@email.com" required>
                @error('email')
                    <span style="color:var(--red);font-size:12px;margin-top:4px;display:block">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group" style="margin-bottom:14px">
                <label>Password</label>
                <input name="password" type="password" placeholder="Minimal 8 karakter" required>
                @error('password')
                    <span style="color:var(--red);font-size:12px;margin-top:4px;display:block">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group" style="margin-bottom:20px">
                <label>Konfirmasi Password</label>
                <input name="password_confirmation" type="password" placeholder="Ulangi password" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:12px">
                Daftar Sekarang
            </button>
        </form>

        <div class="link-area">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
        </div>
    </div>
</body>
</html>