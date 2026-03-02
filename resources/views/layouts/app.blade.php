<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand">Laravel Multi Role</span>

        @auth
        <form method="POST" action="/logout">
            @csrf
            <button class="btn btn-danger btn-sm">Logout</button>
        </form>
        @endauth
    </div>
</nav>

<div class="container mt-5">
    @yield('content')
</div>

</body>
</html>