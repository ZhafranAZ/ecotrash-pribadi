@extends('layouts.warga')

@section('title', 'Edukasi Lingkungan')

@section('header')
<div class="flex items-center gap-3 w-full justify-center">
    <span class="font-bold text-on-surface text-lg">Edukasi</span>
</div>
@endsection

@section('content')
<div class="p-4 md:p-0" x-data="{
    saved: {{ json_encode($bookmarkedIds) }},
    toggleBookmark(id) {
        fetch(`/warga/edukasi/${id}/bookmark`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'bookmarked') {
                this.saved.push(id);
            } else {
                this.saved = this.saved.filter(i => i !== id);
            }
            // Emit window event for showToast in layout
            window.dispatchEvent(new CustomEvent('show-toast', { detail: { message: data.message, type: 'success' } }));
        })
        .catch(err => {
            console.error(err);
            window.dispatchEvent(new CustomEvent('show-toast', { detail: { message: 'Gagal memproses bookmark', type: 'error' } }));
        });
    }
}">
    
    <!-- Header Desktop -->
    <div class="hidden md:flex flex-col mb-10">
        <h2 class="text-4xl font-black text-on-surface tracking-tight">Pusat Edukasi Lingkungan</h2>
        <p class="text-on-surface-variant mt-3 text-lg max-w-2xl">Temukan panduan praktis, tips daur ulang, dan cara terbaik menjaga kebersihan lingkungan dari rumah Anda.</p>
    </div>

    <!-- Search & Categories (Desktop Side-by-side or stacked) -->
    <div class="md:flex md:items-center md:justify-between md:mb-10 mb-6 space-y-4 md:space-y-0 md:gap-6">
        <!-- Search -->
        <form action="{{ route('warga.edukasi.index') }}" method="GET" class="relative w-full md:max-w-md shrink-0">
            @if(request('kategori'))
                <input type="hidden" name="kategori" value="{{ request('kategori') }}">
            @endif
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant text-[24px]">search</span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari tips, panduan..." class="w-full bg-white border border-outline rounded-2xl pl-12 pr-4 py-4 text-base focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all shadow-sm">
        </form>

        <!-- Categories -->
        <div class="flex gap-3 overflow-x-auto pb-3 md:pb-0 scrollbar-hide -mx-4 px-4 md:mx-0 md:px-0 w-full">
            <a href="{{ route('warga.edukasi.index', request()->except(['kategori', 'page'])) }}" 
               class="text-sm font-bold px-6 py-3 rounded-full shrink-0 shadow-sm transition-colors {{ !request('kategori') ? 'bg-primary text-white shadow-lg shadow-primary/20 hover:bg-primary-dark' : 'bg-white border border-outline text-on-surface hover:bg-surface-variant' }}">Semua</a>
            <a href="{{ route('warga.edukasi.index', ['kategori' => 'daur_ulang'] + request()->except(['kategori', 'page'])) }}" 
               class="text-sm font-bold px-6 py-3 rounded-full shrink-0 shadow-sm transition-colors {{ request('kategori') === 'daur_ulang' ? 'bg-primary text-white shadow-lg shadow-primary/20 hover:bg-primary-dark' : 'bg-white border border-outline text-on-surface hover:bg-surface-variant' }}">Daur Ulang</a>
            <a href="{{ route('warga.edukasi.index', ['kategori' => 'kompos'] + request()->except(['kategori', 'page'])) }}" 
               class="text-sm font-bold px-6 py-3 rounded-full shrink-0 shadow-sm transition-colors {{ request('kategori') === 'kompos' ? 'bg-primary text-white shadow-lg shadow-primary/20 hover:bg-primary-dark' : 'bg-white border border-outline text-on-surface hover:bg-surface-variant' }}">Kompos</a>
            <a href="{{ route('warga.edukasi.index', ['kategori' => 'b3'] + request()->except(['kategori', 'page'])) }}" 
               class="text-sm font-bold px-6 py-3 rounded-full shrink-0 shadow-sm transition-colors {{ request('kategori') === 'b3' ? 'bg-primary text-white shadow-lg shadow-primary/20 hover:bg-primary-dark' : 'bg-white border border-outline text-on-surface hover:bg-surface-variant' }}">B3</a>
            <a href="{{ route('warga.edukasi.index', ['kategori' => 'tips'] + request()->except(['kategori', 'page'])) }}" 
               class="text-sm font-bold px-6 py-3 rounded-full shrink-0 shadow-sm transition-colors {{ request('kategori') === 'tips' ? 'bg-primary text-white shadow-lg shadow-primary/20 hover:bg-primary-dark' : 'bg-white border border-outline text-on-surface hover:bg-surface-variant' }}">Tips</a>
        </div>
    </div>

    <!-- Article Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
        @forelse($artikels as $artikel)
            <div @click="window.location.href='{{ route('warga.edukasi.show', $artikel->id) }}'" class="bg-white border border-outline rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col relative group cursor-pointer">
                <div class="h-48 md:h-56 bg-surface-dim relative overflow-hidden">
                    <img src="{{ asset($artikel->gambar_thumbnail) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    
                    <button @click.stop="toggleBookmark({{ $artikel->id }})" class="absolute top-4 right-4 w-10 h-10 bg-white/20 backdrop-blur-md flex items-center justify-center rounded-full text-white hover:bg-white/40 hover:scale-110 transition-all shadow-sm">
                        <span class="material-symbols-outlined text-[24px]" :class="saved.includes({{ $artikel->id }}) ? 'text-amber-400' : ''" :style="saved.includes({{ $artikel->id }}) ? 'font-variation-settings: \'FILL\' 1;' : ''">bookmark</span>
                    </button>
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-[10px] md:text-xs font-bold text-primary bg-primary/10 border border-primary/20 px-3 py-1 rounded-md uppercase tracking-wider">
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
                        <span class="text-xs text-on-surface-variant flex items-center gap-1 font-medium"><span class="material-symbols-outlined text-[16px]">schedule</span> {{ $artikel->created_at->diffForHumans() }}</span>
                    </div>
                    <h3 class="font-black text-lg md:text-xl text-on-surface leading-tight mb-3 group-hover:text-primary transition-colors line-clamp-2">{{ $artikel->judul }}</h3>
                    <p class="text-sm text-on-surface-variant line-clamp-3 mb-6 flex-1">{{ strip_tags($artikel->konten_html) }}</p>
                    <div class="flex items-center gap-2 text-sm font-bold text-primary mt-auto">
                        Baca Artikel Lengkap <span class="material-symbols-outlined text-[20px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full flex flex-col items-center justify-center py-20 text-center">
                <div class="w-32 h-32 mb-6 opacity-50">
                    <span class="material-symbols-outlined text-[100px] text-on-surface-variant">search_off</span>
                </div>
                <h3 class="text-2xl font-black text-on-surface mb-2">Yah, artikel tidak ditemukan</h3>
                <p class="text-on-surface-variant text-lg">Coba gunakan kata kunci lain atau periksa kategori yang dipilih.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($artikels->hasPages())
        <div class="mt-10">
            {{ $artikels->links() }}
        </div>
    @endif
</div>

<style>
    /* Hide scrollbar for Chrome, Safari and Opera */
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    /* Hide scrollbar for IE, Edge and Firefox */
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endsection
