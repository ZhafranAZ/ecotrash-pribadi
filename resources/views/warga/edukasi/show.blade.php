@extends('layouts.warga')

@section('title', 'Baca Artikel')

@push('styles')
<style>
    .ql-align-center { text-align: center; }
    .ql-align-right { text-align: right; }
    .ql-align-justify { text-align: justify; }
    .ql-align-left { text-align: left; }
    
    /* Pindahkan list counter reset ke root pembaca agar angka berlanjut meskipun ada paragraf di tengah */
    article.prose {
        counter-reset: list-0-decimal list-0-alpha list-0-uppercase list-0-roman list-1 list-2 list-3 list-4 list-5 list-6 list-7 list-8 list-9 !important;
    }
    article.prose ol {
        counter-reset: none !important;
    }
    
    /* 1. Aturan Rendering untuk Huruf Kecil (a, b, c) */
    article.prose ol li:not([class*="ql-indent-"]).ql-list-style-alpha {
        counter-increment: list-0-alpha !important;
    }
    article.prose ol li:not([class*="ql-indent-"]).ql-list-style-alpha::before {
        content: counter(list-0-alpha, lower-alpha) ". " !important;
    }

    /* 2. Aturan Rendering untuk Huruf Kapital (A, B, C) */
    article.prose ol li:not([class*="ql-indent-"]).ql-list-style-uppercase {
        counter-increment: list-0-uppercase !important;
    }
    article.prose ol li:not([class*="ql-indent-"]).ql-list-style-uppercase::before {
        content: counter(list-0-uppercase, upper-alpha) ". " !important;
    }

    /* 3. Aturan Rendering untuk Romawi Kecil (i, ii, iii) */
    article.prose ol li:not([class*="ql-indent-"]).ql-list-style-roman {
        counter-increment: list-0-roman !important;
    }
    article.prose ol li:not([class*="ql-indent-"]).ql-list-style-roman::before {
        content: counter(list-0-roman, lower-roman) ". " !important;
    }

    /* 4. Aturan Rendering untuk Angka Desimal Eksplisit (1, 2, 3) */
    article.prose ol li:not([class*="ql-indent-"]).ql-list-style-decimal {
        counter-increment: list-0-decimal !important;
        counter-set: list-0-alpha 0 list-0-uppercase 0 list-0-roman 0 !important;
    }
    article.prose ol li:not([class*="ql-indent-"]).ql-list-style-decimal::before {
        content: counter(list-0-decimal, decimal) ". " !important;
    }

    /* 5. Aturan Rendering untuk Angka Desimal Default (Tanpa class kustom) */
    article.prose ol li:not([class*="ql-indent-"]):not([class*="ql-list-style-"]) {
        counter-increment: list-0-decimal !important;
        counter-set: list-0-alpha 0 list-0-uppercase 0 list-0-roman 0 !important;
    }
    article.prose ol li:not([class*="ql-indent-"]):not([class*="ql-list-style-"])::before {
        content: counter(list-0-decimal, decimal) ". " !important;
    }

    /* Dukungan Indentasi dan Penomoran Quill untuk Warga */
    article.prose li.ql-indent-1 {
        padding-left: 2em !important;
        counter-reset: list-2 !important;
    }
    article.prose li.ql-indent-1::before {
        content: counter(list-1, lower-alpha) ". " !important;
        counter-increment: list-1;
    }
    article.prose li.ql-indent-2 {
        padding-left: 4em !important;
        counter-reset: list-3 !important;
    }
    article.prose li.ql-indent-2::before {
        content: counter(list-2, lower-roman) ". " !important;
        counter-increment: list-2;
    }
</style>
@endpush

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
