@extends('layouts.warga')

@section('title', 'Pesanan Berhasil')

@section('content')
<div class="min-h-[80vh] flex flex-col items-center justify-center p-6 text-center">
    <div class="w-32 h-32 bg-green-100 rounded-full flex items-center justify-center text-green-500 mb-6 relative">
        <span class="material-symbols-outlined text-[64px] animate-bounce">check_circle</span>
        <!-- Decorative particles -->
        <div class="absolute inset-0 w-full h-full animate-[spin_4s_linear_infinite]">
            <div class="absolute top-0 left-1/2 w-2 h-2 bg-green-400 rounded-full"></div>
            <div class="absolute bottom-0 left-1/2 w-3 h-3 bg-green-300 rounded-full"></div>
            <div class="absolute left-0 top-1/2 w-2.5 h-2.5 bg-green-500 rounded-full"></div>
            <div class="absolute right-0 top-1/2 w-2 h-2 bg-green-400 rounded-full"></div>
        </div>
    </div>
    
    <h1 class="text-3xl font-black text-on-surface mb-2">Pesanan Berhasil Dibuat!</h1>
    <p class="text-on-surface-variant mb-8 max-w-sm">Pesanan pengangkutan sampah Anda telah kami terima. Petugas terdekat akan segera menuju lokasi Anda sesuai jadwal.</p>
    
    <div class="bg-surface border border-outline rounded-2xl p-4 w-full max-w-sm mb-6 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-[20px]">local_shipping</span>
            </div>
            <div class="text-left">
                <p class="font-bold text-sm text-on-surface">No. Pesanan</p>
                <p class="text-xs text-on-surface-variant font-mono">{{ $pesanan->id }}</p>
            </div>
        </div>
        <span class="text-xs font-bold text-primary bg-primary/10 px-2 py-1 rounded-md border border-primary/20">{{ ucfirst($pesanan->status) }}</span>
    </div>

    <!-- Coin Reward Element -->
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 w-full max-w-sm mb-10 shadow-sm relative overflow-hidden flex items-center justify-between">
        <div class="absolute -right-4 -top-4 w-16 h-16 bg-amber-200 rounded-full opacity-50 blur-xl"></div>
        <div class="flex items-center gap-3 relative z-10">
            <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center text-amber-500 shadow-inner">
                <span class="material-symbols-outlined text-[28px]" style="font-variation-settings: 'FILL' 1;">generating_tokens</span>
            </div>
            <div class="text-left">
                <p class="font-bold text-amber-900">Bonus Koin Eco</p>
                <p class="text-xs text-amber-700 font-medium">Anda akan mendapatkan reward koin setelah pesanan selesai.</p>
            </div>
        </div>
        <span class="text-xl font-black text-amber-600 relative z-10">+{{ $pesanan->koin_didapat }}</span>
    </div>

    <div class="w-full max-w-sm space-y-3">
        <a href="{{ route('warga.aktivitas.index') }}" class="w-full bg-primary text-white font-bold py-4 rounded-xl shadow-lg shadow-primary/30 hover:bg-primary-dark transition-transform active:scale-95 block">
            Cek Status Pesanan
        </a>
        <a href="{{ route('warga.dashboard') }}" class="w-full bg-white border border-outline text-on-surface font-bold py-4 rounded-xl hover:bg-surface transition-colors block">
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
