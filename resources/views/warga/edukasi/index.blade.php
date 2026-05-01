@extends('layouts.warga')

@section('title', 'Edukasi Lingkungan')

@section('header')
<div class="flex items-center gap-3 w-full justify-center">
    <span class="font-bold text-on-surface text-lg">Edukasi</span>
</div>
@endsection

@section('content')
<div class="p-4 md:p-0" x-data="{ saved: [], searchQuery: '' }">
    
    <!-- Header Desktop -->
    <div class="hidden md:flex flex-col mb-10">
        <h2 class="text-4xl font-black text-on-surface tracking-tight">Pusat Edukasi Lingkungan</h2>
        <p class="text-on-surface-variant mt-3 text-lg max-w-2xl">Temukan panduan praktis, tips daur ulang, dan cara terbaik menjaga kebersihan lingkungan dari rumah Anda.</p>
    </div>

    <!-- Search & Categories (Desktop Side-by-side or stacked) -->
    <div class="md:flex md:items-center md:justify-between md:mb-10 mb-6 space-y-4 md:space-y-0 md:gap-6">
        <!-- Search -->
        <div class="relative w-full md:max-w-md shrink-0">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant text-[24px]">search</span>
            <input type="text" x-model="searchQuery" placeholder="Cari tips, panduan..." class="w-full bg-white border border-outline rounded-2xl pl-12 pr-4 py-4 text-base focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all shadow-sm">
        </div>

        <!-- Categories -->
        <div class="flex gap-3 overflow-x-auto pb-3 md:pb-0 scrollbar-hide -mx-4 px-4 md:mx-0 md:px-0 w-full">
            <button class="bg-primary text-white text-sm font-bold px-6 py-3 rounded-full shrink-0 shadow-lg shadow-primary/20 hover:bg-primary-dark transition-colors">Semua</button>
            <button class="bg-white border border-outline text-on-surface text-sm font-bold px-6 py-3 rounded-full shrink-0 hover:bg-surface-variant transition-colors shadow-sm">Daur Ulang</button>
            <button class="bg-white border border-outline text-on-surface text-sm font-bold px-6 py-3 rounded-full shrink-0 hover:bg-surface-variant transition-colors shadow-sm">Kompos</button>
            <button class="bg-white border border-outline text-on-surface text-sm font-bold px-6 py-3 rounded-full shrink-0 hover:bg-surface-variant transition-colors shadow-sm">B3</button>
        </div>
    </div>

    <!-- Article Grid -->
    <div x-show="searchQuery.toLowerCase() !== 'xxx'" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
        <!-- Article 1 -->
        <div @click="window.location.href='{{ route('warga.edukasi.show', 1) }}'" class="bg-white border border-outline rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col relative group cursor-pointer">
            <div class="h-48 md:h-56 bg-surface-dim relative overflow-hidden">
                <img src="https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=600&q=80" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                <button @click.stop="if(saved.includes(1)) { saved = saved.filter(i => i !== 1); showToast('Dihapus dari Tersimpan', 'success') } else { saved.push(1); showToast('Artikel disimpan ke koleksi', 'success') }" class="absolute top-4 right-4 w-10 h-10 bg-white/20 backdrop-blur-md flex items-center justify-center rounded-full text-white hover:bg-white/40 hover:scale-110 transition-all shadow-sm">
                    <span class="material-symbols-outlined text-[24px]" :class="saved.includes(1) ? 'text-amber-400' : ''" :style="saved.includes(1) ? 'font-variation-settings: \'FILL\' 1;' : ''">bookmark</span>
                </button>
            </div>
            <div class="p-6 flex flex-col flex-1">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] md:text-xs font-bold text-primary bg-primary/10 border border-primary/20 px-3 py-1 rounded-md uppercase tracking-wider">Daur Ulang</span>
                    <span class="text-xs text-on-surface-variant flex items-center gap-1 font-medium"><span class="material-symbols-outlined text-[16px]">schedule</span> 3 min read</span>
                </div>
                <h3 class="font-black text-lg md:text-xl text-on-surface leading-tight mb-3 group-hover:text-primary transition-colors">Cara Cerdas Memilah Sampah Plastik di Rumah Tangga</h3>
                <p class="text-sm text-on-surface-variant line-clamp-3 mb-6 flex-1">Memilah sampah plastik bisa dimulai dari langkah kecil. Kenali jenis-jenis plastik dan cara yang benar untuk mendaur ulangnya agar bernilai ekonomis.</p>
                <div class="flex items-center gap-2 text-sm font-bold text-primary mt-auto">
                    Baca Artikel Lengkap <span class="material-symbols-outlined text-[20px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </div>
            </div>
        </div>

        <!-- Article 2 -->
        <div @click="window.location.href='{{ route('warga.edukasi.show', 2) }}'" class="bg-white border border-outline rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col relative group cursor-pointer">
            <div class="h-48 md:h-56 bg-surface-dim relative overflow-hidden">
                <img src="https://images.unsplash.com/photo-1581056771107-24ca5f033842?w=600&q=80" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                <button @click.stop="if(saved.includes(2)) { saved = saved.filter(i => i !== 2); showToast('Dihapus dari Tersimpan', 'success') } else { saved.push(2); showToast('Artikel disimpan ke koleksi', 'success') }" class="absolute top-4 right-4 w-10 h-10 bg-white/20 backdrop-blur-md flex items-center justify-center rounded-full text-white hover:bg-white/40 hover:scale-110 transition-all shadow-sm">
                    <span class="material-symbols-outlined text-[24px]" :class="saved.includes(2) ? 'text-amber-400' : ''" :style="saved.includes(2) ? 'font-variation-settings: \'FILL\' 1;' : ''">bookmark</span>
                </button>
            </div>
            <div class="p-6 flex flex-col flex-1">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] md:text-xs font-bold text-green-600 bg-green-50 border border-green-200 px-3 py-1 rounded-md uppercase tracking-wider">Kompos</span>
                    <span class="text-xs text-on-surface-variant flex items-center gap-1 font-medium"><span class="material-symbols-outlined text-[16px]">schedule</span> 5 min read</span>
                </div>
                <h3 class="font-black text-lg md:text-xl text-on-surface leading-tight mb-3 group-hover:text-green-600 transition-colors">Panduan Lengkap Membuat Pupuk Kompos Sendiri</h3>
                <p class="text-sm text-on-surface-variant line-clamp-3 mb-6 flex-1">Ubah sisa makanan organik Anda menjadi nutrisi super untuk tanaman hijau di halaman. Pelajari bahan apa saja yang bisa dan tidak bisa dijadikan kompos.</p>
                <div class="flex items-center gap-2 text-sm font-bold text-green-600 mt-auto">
                    Baca Artikel Lengkap <span class="material-symbols-outlined text-[20px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Empty State -->
    <div x-show="searchQuery.toLowerCase() === 'xxx'" class="flex flex-col items-center justify-center py-20 text-center" style="display:none;">
        <div class="w-32 h-32 mb-6 opacity-50">
            <span class="material-symbols-outlined text-[100px] text-on-surface-variant">search_off</span>
        </div>
        <h3 class="text-2xl font-black text-on-surface mb-2">Yah, artikel tidak ditemukan</h3>
        <p class="text-on-surface-variant text-lg">Coba gunakan kata kunci lain seperti "Plastik" atau "Kompos".</p>
    </div>
</div>

<style>
    /* Hide scrollbar for Chrome, Safari and Opera */
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    /* Hide scrollbar for IE, Edge and Firefox */
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endsection
