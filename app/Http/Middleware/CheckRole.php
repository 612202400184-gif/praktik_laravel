<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        $user = auth()->user();

        // Memeriksa apakah role pengguna saat ini termasuk dalam daftar role yang diizinkan
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika tidak sesuai, tampilkan error 403
        abort(403, 'Akses Ditolak: Anda tidak memiliki izin untuk melakukan tindakan ini.');
    }
}