@extends('layouts.warga')

@section('title', 'Laporan Berhasil')

@section('content')
<div class="min-h-[80vh] flex flex-col items-center justify-center p-6 text-center">
    <div class="w-32 h-32 bg-orange-100 rounded-full flex items-center justify-center text-orange-500 mb-6 relative">
        <span class="material-symbols-outlined text-[64px] animate-bounce">assignment_turned_in</span>
        <!-- Decorative particles -->
        <div class="absolute inset-0 w-full h-full animate-[spin_4s_linear_infinite]">
            <div class="absolute top-0 left-1/2 w-2 h-2 bg-orange-400 rounded-full"></div>
            <div class="absolute bottom-0 left-1/2 w-3 h-3 bg-orange-300 rounded-full"></div>
            <div class="absolute left-0 top-1/2 w-2.5 h-2.5 bg-orange-500 rounded-full"></div>
            <div class="absolute right-0 top-1/2 w-2 h-2 bg-orange-400 rounded-full"></div>
        </div>
    </div>
    
    <h1 class="text-3xl font-black text-on-surface mb-2">Laporan Terkirim!</h1>
    <p class="text-on-surface-variant mb-8 max-w-sm">Terima kasih atas kepedulian Anda terhadap lingkungan. Laporan tumpukan sampah liar telah masuk ke antrean admin untuk ditinjau.</p>
    
    <div class="bg-surface border border-outline rounded-2xl p-4 w-full max-w-sm mb-10 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-orange-50 text-orange-500 flex items-center justify-center">
                <span class="material-symbols-outlined text-[20px]">report</span>
            </div>
            <div class="text-left">
                <p class="font-bold text-sm text-on-surface">No. Tiket</p>
                <p class="text-xs text-on-surface-variant font-mono">REP-260515-002</p>
            </div>
        </div>
        <span class="text-xs font-bold text-orange-600 bg-orange-50 px-2 py-1 rounded-md border border-orange-200">Menunggu</span>
    </div>

    <div class="w-full max-w-sm space-y-3">
        <a href="{{ route('warga.aktivitas.index') }}" class="w-full bg-orange-500 text-white font-bold py-4 rounded-xl shadow-lg shadow-orange-500/30 hover:bg-orange-600 transition-transform active:scale-95 block">
            Cek Status Laporan
        </a>
        <a href="{{ route('warga.dashboard') }}" class="w-full bg-white border border-outline text-on-surface font-bold py-4 rounded-xl hover:bg-surface transition-colors block">
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
