<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAddressSetup
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Only enforce for warga role
        if ($user && $user->role === 'warga') {
            // Skip if already on setup-address or logout route
            if (!$request->routeIs('setup-address', 'setup-address.post', 'logout')) {
                if (!$user->hasSetupAddress()) {
                    return redirect()->route('setup-address')
                        ->with('warning', 'Silakan lengkapi alamat Anda terlebih dahulu.');
                }
            }
        }

        return $next($request);
    }
}
