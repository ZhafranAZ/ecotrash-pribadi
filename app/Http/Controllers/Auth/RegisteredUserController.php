<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AlamatWarga;
use App\Models\Komplek;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration form (Tahap 1).
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle registration form submission (Tahap 1).
     * Creates user with role='warga', auto-login, redirect to setup-address.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'no_telepon' => ['required', 'string', 'min:10'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'no_telepon' => $validated['no_telepon'],
            'password' => $validated['password'],
            'role' => 'warga',
            'saldo_koin' => 0,
        ]);

        Auth::login($user);

        return redirect()->route('setup-address');
    }

    /**
     * Display the address setup form (Tahap 2).
     */
    public function showSetupAddress(): View
    {
        $komplek = Komplek::all();
        return view('auth.setup-address', compact('komplek'));
    }

    /**
     * Handle address setup form submission (Tahap 2).
     * Creates alamat_warga with is_utama=true, redirect to warga dashboard.
     */
    public function storeAddress(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'komplek_id' => ['required', 'exists:komplek,id'],
            'blok_nomor_rumah' => ['required', 'string', 'max:255'],
            'detail_patokan' => ['nullable', 'string', 'max:1000'],
        ]);

        AlamatWarga::create([
            'warga_id' => Auth::id(),
            'komplek_id' => $validated['komplek_id'],
            'nama_alamat' => 'Rumah Utama',
            'blok_nomor_rumah' => $validated['blok_nomor_rumah'],
            'detail_patokan' => $validated['detail_patokan'] ?? null,
            'is_utama' => true,
        ]);

        return redirect()->route('warga.dashboard');
    }
}
