<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Ambil role user, misalnya dari kolom 'role'
        $user_role = $request->user()->role;

        // Jika role user ada di dalam list role yang diizinkan
        if (in_array($user_role, $roles)) {
            return $next($request);
        }

        // Kalau tidak punya akses
        abort(403, 'Forbidden. Kamu tidak punya akses ke halaman ini.');
    }
}
