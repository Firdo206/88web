<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek login dulu
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Cek role langsung dari atribut — lebih aman dari cached model
        $user = auth()->user()->fresh(); // fresh() paksa reload dari DB

        if ($user->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang diizinkan.');
        }

        return $next($request);
    }
}