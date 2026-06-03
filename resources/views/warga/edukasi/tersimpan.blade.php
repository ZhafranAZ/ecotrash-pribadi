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
        @forelse($artikels as $artikel)
            <a href="{{ route('warga.edukasi.show', $artikel->id) }}" class="group bg-white border border-outline rounded-3xl overflow-hidden shadow-sm hover:shadow-xl hover:shadow-primary/10 transition-all flex flex-col h-full">
                <div class="h-40 md:h-48 relative overflow-hidden">
                    <img src="{{ asset($artikel->gambar_thumbnail) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Thumbnail">
                    <div class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center text-amber-500 shadow-sm z-10">
                        <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">bookmark</span>
                    </div>
                </div>
                <div class="p-5 flex-1 flex flex-col">
                    <span class="text-xs font-bold text-primary bg-primary/10 px-2.5 py-1 rounded-md w-max mb-3 uppercase tracking-wider">
                        @if($artikel->kategori === 'daur_ulang')
                            Daur Ulang
                        @elseif($artikel->kategori === 'kompos')
                            Kompos
                        @elseif($artikel->kategori === 'b3')
                            B3
                        @elseif($artikel->kategori === 'tips')
                            Tips Lingkungan
                        @else
                            {{ ucfirst($artikel->kategori) }}
                        @endif
                    </span>
                    <h3 class="font-bold text-lg text-on-surface group-hover:text-primary transition-colors leading-tight mb-2 line-clamp-2">{{ $artikel->judul }}</h3>
                    <p class="text-sm text-on-surface-variant line-clamp-2 mt-auto">{{ strip_tags($artikel->konten_html) }}</p>
                </div>
            </a>
        @empty
            <div class="col-span-full flex flex-col items-center justify-center py-20 text-center">
                <div class="w-32 h-32 mb-6 opacity-30">
                    <span class="material-symbols-outlined text-[100px] text-on-surface-variant">bookmark_border</span>
                </div>
                <h3 class="text-xl font-black text-on-surface mb-2">Belum ada artikel tersimpan</h3>
                <p class="text-on-surface-variant text-sm max-w-sm">Jelajahi pusat edukasi kami dan simpan artikel menarik untuk dibaca nanti.</p>
                <a href="{{ route('warga.edukasi.index') }}" class="mt-6 px-6 py-2.5 bg-primary hover:bg-primary-dark text-white font-bold text-sm rounded-xl transition-colors shadow-md">Jelajahi Artikel</a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($artikels->hasPages())
        <div class="mt-8">
            {{ $artikels->links() }}
        </div>
    @endif
</div>
@endsection
