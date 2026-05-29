@extends('layouts.warga')

@section('title', 'Baca Artikel')

@section('header')
<div class="flex items-center gap-3 w-full">
    <button onclick="history.back()" class="p-2 -ml-2 rounded-full hover:bg-surface-variant text-on-surface-variant transition-colors">
        <span class="material-symbols-outlined">arrow_back</span>
    </button>
    <span class="font-bold text-on-surface">Artikel Edukasi</span>
</div>
@endsection

@section('content')
<div class="bg-white md:bg-transparent min-h-full">
    <!-- Hero Image -->
    <div class="w-full h-64 md:h-96 relative md:rounded-3xl overflow-hidden mb-6 md:mb-10 shadow-sm">
        <img src="{{ asset($artikel->gambar_thumbnail) }}" class="w-full h-full object-cover" alt="Thumbnail">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
        <div class="absolute bottom-6 left-6 right-6 md:bottom-10 md:left-10 md:right-10">
            <span class="text-xs font-bold text-primary bg-primary/20 backdrop-blur-md border border-primary/30 px-3 py-1 rounded-md uppercase tracking-wider mb-3 inline-block">
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
            <h1 class="text-2xl md:text-4xl lg:text-5xl font-black text-white leading-tight mb-2">{{ $artikel->judul }}</h1>
            <p class="text-white/80 text-sm md:text-base flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">schedule</span> 
                {{ $artikel->created_at->translatedFormat('d F Y') }}
            </p>
        </div>
    </div>

    <!-- Content -->
    <div class="px-6 md:px-0 max-w-3xl mx-auto pb-10">
        <article class="prose prose-slate md:prose-lg prose-headings:font-black prose-a:text-primary max-w-none text-on-surface-variant leading-relaxed">
            {!! $artikel->konten_html !!}
        </article>

        <div class="mt-12 pt-8 border-t border-outline flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="font-bold text-on-surface">Bagikan artikel ini:</p>
            <div class="flex gap-3" x-data="{ 
                saved: {{ $isBookmarked ? 'true' : 'false' }},
                toggleBookmark() {
                    fetch(`/warga/edukasi/{{ $artikel->id }}/bookmark`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.saved = (data.status === 'bookmarked');
                        window.dispatchEvent(new CustomEvent('show-toast', { detail: { message: data.message, type: 'success' } }));
                    })
                    .catch(err => {
                        console.error(err);
                        window.dispatchEvent(new CustomEvent('show-toast', { detail: { message: 'Gagal memproses bookmark', type: 'error' } }));
                    });
                }
            }">
                <button @click="navigator.clipboard.writeText(window.location.href); window.dispatchEvent(new CustomEvent('show-toast', { detail: { message: 'Tautan disalin ke clipboard!', type: 'success' } }))" class="w-10 h-10 rounded-full bg-surface-variant flex items-center justify-center text-on-surface hover:bg-primary hover:text-white transition-colors" title="Salin Tautan">
                    <span class="material-symbols-outlined text-[20px]">share</span>
                </button>
                <button @click="toggleBookmark()" class="w-10 h-10 rounded-full flex items-center justify-center text-white transition-colors shadow-md" :class="saved ? 'bg-amber-500 hover:bg-amber-600' : 'bg-surface-variant hover:bg-amber-500'" title="Simpan Bookmark">
                    <span class="material-symbols-outlined text-[20px]" :style="saved ? 'font-variation-settings: \'FILL\' 1;' : ''">bookmark</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
