@extends('layouts.warga')

@section('title', 'Edukasi Tersimpan')

@section('header')
<div class="flex items-center gap-3 w-full">
    <a href="{{ route('warga.profil.index') }}" class="p-2 -ml-2 rounded-full hover:bg-surface-variant text-on-surface-variant transition-colors">
        <span class="material-symbols-outlined">arrow_back</span>
    </a>
    <span class="font-bold text-on-surface">Edukasi Tersimpan</span>
</div>
@endsection

@section('content')
<div class="p-4 md:p-0">
    <div class="mb-6 md:mb-8">
        <h2 class="text-2xl font-black text-on-surface">Artikel Tersimpan</h2>
        <p class="text-on-surface-variant mt-1">Lanjutkan membaca artikel dan panduan yang telah Anda simpan.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
        <!-- Card 1 -->
        <a href="{{ route('warga.edukasi.show', 1) }}" class="group bg-white border border-outline rounded-3xl overflow-hidden shadow-sm hover:shadow-xl hover:shadow-primary/10 transition-all flex flex-col h-full">
            <div class="h-40 md:h-48 relative overflow-hidden">
                <img src="https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=600&q=80" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center text-amber-500 shadow-sm z-10">
                    <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">bookmark</span>
                </div>
            </div>
            <div class="p-5 flex-1 flex flex-col">
                <span class="text-xs font-bold text-primary bg-primary/10 px-2.5 py-1 rounded-md w-max mb-3 uppercase tracking-wider">Daur Ulang</span>
                <h3 class="font-bold text-lg text-on-surface group-hover:text-primary transition-colors leading-tight mb-2">Cara Cerdas Memilah Sampah Plastik di Rumah Tangga</h3>
                <p class="text-sm text-on-surface-variant line-clamp-2 mt-auto">Pelajari cara yang benar untuk memilah sampah plastik dari sumbernya...</p>
            </div>
        </a>

        <!-- Card 2 -->
        <a href="{{ route('warga.edukasi.show', 2) }}" class="group bg-white border border-outline rounded-3xl overflow-hidden shadow-sm hover:shadow-xl hover:shadow-primary/10 transition-all flex flex-col h-full">
            <div class="h-40 md:h-48 relative overflow-hidden">
                <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=600&q=80" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center text-amber-500 shadow-sm z-10">
                    <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">bookmark</span>
                </div>
            </div>
            <div class="p-5 flex-1 flex flex-col">
                <span class="text-xs font-bold text-green-600 bg-green-100 px-2.5 py-1 rounded-md w-max mb-3 uppercase tracking-wider">Kompos</span>
                <h3 class="font-bold text-lg text-on-surface group-hover:text-primary transition-colors leading-tight mb-2">Membuat Kompos dari Sisa Dapur</h3>
                <p class="text-sm text-on-surface-variant line-clamp-2 mt-auto">Ubah sisa makanan Anda menjadi pupuk organik yang menyuburkan tanaman...</p>
            </div>
        </a>
    </div>
</div>
@endsection
