<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!in_array($user->role, $roles)) {
            // Redirect to appropriate dashboard based on actual role
            return match ($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'petugas' => redirect()->route('petugas.beranda'),
                'warga' => redirect()->route('warga.dashboard'),
                default => abort(403, 'Akses ditolak.'),
            };
        }

        return $next($request);
    }
}
