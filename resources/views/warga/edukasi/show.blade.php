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
        <img src="https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=1200&q=80" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
        <div class="absolute bottom-6 left-6 right-6 md:bottom-10 md:left-10 md:right-10">
            <span class="text-xs font-bold text-primary bg-primary/20 backdrop-blur-md border border-primary/30 px-3 py-1 rounded-md uppercase tracking-wider mb-3 inline-block">Daur Ulang</span>
            <h1 class="text-2xl md:text-4xl lg:text-5xl font-black text-white leading-tight mb-2">Cara Cerdas Memilah Sampah Plastik di Rumah Tangga</h1>
            <p class="text-white/80 text-sm md:text-base flex items-center gap-2"><span class="material-symbols-outlined text-[18px]">schedule</span> 3 menit membaca &bull; 14 Mei 2026</p>
        </div>
    </div>

    <!-- Content -->
    <div class="px-6 md:px-0 max-w-3xl mx-auto pb-10">
        <article class="prose prose-slate md:prose-lg prose-headings:font-black prose-a:text-primary max-w-none">
            <p class="lead text-lg md:text-xl text-on-surface-variant font-medium mb-8">
                Memilah sampah plastik bisa dimulai dari langkah kecil. Kenali jenis-jenis plastik dan cara yang benar untuk mendaur ulangnya agar bernilai ekonomis dan menyelamatkan bumi.
            </p>
            
            <h2 class="text-xl md:text-2xl font-bold text-on-surface mt-8 mb-4">1. Kenali Jenis Plastik Anda</h2>
            <p class="text-on-surface-variant mb-4 leading-relaxed">
                Tidak semua plastik diciptakan sama. Perhatikan simbol segitiga di bawah kemasan. Plastik jenis PET (seperti botol air mineral) dan HDPE (botol sampo) adalah yang paling mudah didaur ulang dan memiliki nilai jual tertinggi di bank sampah.
            </p>

            <div class="bg-primary/5 border-l-4 border-primary p-5 rounded-r-2xl my-8">
                <p class="font-bold text-primary mb-1">Tips EcoTrash:</p>
                <p class="text-sm text-on-surface-variant">Pisahkan tutup botol dari botolnya karena biasanya terbuat dari jenis plastik yang berbeda.</p>
            </div>

            <h2 class="text-xl md:text-2xl font-bold text-on-surface mt-8 mb-4">2. Bersihkan Sebelum Disimpan</h2>
            <p class="text-on-surface-variant mb-4 leading-relaxed">
                Pastikan wadah plastik dalam keadaan kosong dan dibilas bersih. Sisa makanan atau minuman yang tertinggal dapat menyebabkan bau busuk dan mencemari tumpukan daur ulang lainnya, membuatnya ditolak oleh pengepul.
            </p>

            <h2 class="text-xl md:text-2xl font-bold text-on-surface mt-8 mb-4">3. Kumpulkan dan Setorkan</h2>
            <p class="text-on-surface-variant mb-4 leading-relaxed">
                Siapkan satu tempat sampah khusus untuk plastik di rumah. Setelah terkumpul cukup banyak (sekitar 1-2 kantong besar), Anda bisa menggunakan aplikasi EcoTrash untuk memesan layanan penjemputan langsung dari depan pintu rumah Anda!
            </p>
        </article>

        <div class="mt-12 pt-8 border-t border-outline flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="font-bold text-on-surface">Bagikan artikel ini:</p>
            <div class="flex gap-3" x-data="{ saved: true }">
                <button @click="showToast('Tautan disalin ke clipboard!', 'success')" class="w-10 h-10 rounded-full bg-surface-variant flex items-center justify-center text-on-surface hover:bg-primary hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-[20px]">share</span>
                </button>
                <button @click="if(saved) { saved = false; showToast('Dihapus dari Tersimpan', 'success') } else { saved = true; showToast('Artikel disimpan ke koleksi!', 'success') }" class="w-10 h-10 rounded-full flex items-center justify-center text-white transition-colors shadow-md" :class="saved ? 'bg-amber-500 hover:bg-amber-600' : 'bg-surface-variant hover:bg-amber-500'">
                    <span class="material-symbols-outlined text-[20px]" :style="saved ? 'font-variation-settings: \'FILL\' 1;' : ''">bookmark</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
