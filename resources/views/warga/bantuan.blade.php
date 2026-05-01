@extends('layouts.warga')

@section('title', 'Pusat Bantuan')

@section('header')
<div class="flex items-center gap-3 w-full">
    <a href="{{ route('warga.profil.index') }}" class="p-2 -ml-2 rounded-full hover:bg-surface-variant text-on-surface-variant transition-colors">
        <span class="material-symbols-outlined">arrow_back</span>
    </a>
    <span class="font-bold text-on-surface">Pusat Bantuan</span>
</div>
@endsection

@section('content')
<div class="p-4 md:p-0 max-w-3xl mx-auto space-y-6 md:space-y-8" x-data="{ activeAccordion: null }">
    
    <div class="text-center md:text-left">
        <div class="w-16 h-16 md:w-20 md:h-20 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto md:mx-0 mb-4 md:mb-6">
            <span class="material-symbols-outlined text-[36px] md:text-[40px]">support_agent</span>
        </div>
        <h2 class="text-2xl md:text-3xl font-black text-on-surface">Bagaimana kami bisa membantu?</h2>
        <p class="text-on-surface-variant mt-2 text-sm md:text-base">Temukan jawaban untuk pertanyaan umum seputar EcoTrash di bawah ini.</p>
    </div>

    <!-- FAQ Accordions -->
    <div class="bg-white border border-outline rounded-3xl overflow-hidden shadow-sm">
        
        <div class="border-b border-outline">
            <button @click="activeAccordion = activeAccordion === 1 ? null : 1" class="w-full flex items-center justify-between p-5 text-left hover:bg-surface-variant transition-colors">
                <span class="font-bold text-on-surface">Bagaimana cara memesan penjemputan sampah?</span>
                <span class="material-symbols-outlined text-on-surface-variant transition-transform" :class="activeAccordion === 1 ? 'rotate-180' : ''">expand_more</span>
            </button>
            <div x-show="activeAccordion === 1" x-collapse>
                <div class="px-5 pb-5 pt-0 text-sm md:text-base text-on-surface-variant leading-relaxed">
                    Anda bisa menekan menu "Pesan Pengangkutan" di Beranda. Lalu pilih alamat penjemputan, estimasi volume sampah, dan jadwalkan hari yang Anda inginkan.
                </div>
            </div>
        </div>
        
        <div class="border-b border-outline">
            <button @click="activeAccordion = activeAccordion === 2 ? null : 2" class="w-full flex items-center justify-between p-5 text-left hover:bg-surface-variant transition-colors">
                <span class="font-bold text-on-surface">Berapa biaya layanannya?</span>
                <span class="material-symbols-outlined text-on-surface-variant transition-transform" :class="activeAccordion === 2 ? 'rotate-180' : ''">expand_more</span>
            </button>
            <div x-show="activeAccordion === 2" x-collapse>
                <div class="px-5 pb-5 pt-0 text-sm md:text-base text-on-surface-variant leading-relaxed">
                    Biaya layanan bervariasi antara Rp15.000 hingga Rp40.000 tergantung dari volume sampah. Anda juga dapat menggunakan Saldo Koin Eco untuk mendapatkan potongan harga hingga 50%.
                </div>
            </div>
        </div>

        <div class="border-b border-outline">
            <button @click="activeAccordion = activeAccordion === 3 ? null : 3" class="w-full flex items-center justify-between p-5 text-left hover:bg-surface-variant transition-colors">
                <span class="font-bold text-on-surface">Apa itu Koin Eco dan bagaimana cara mendapatkannya?</span>
                <span class="material-symbols-outlined text-on-surface-variant transition-transform" :class="activeAccordion === 3 ? 'rotate-180' : ''">expand_more</span>
            </button>
            <div x-show="activeAccordion === 3" x-collapse>
                <div class="px-5 pb-5 pt-0 text-sm md:text-base text-on-surface-variant leading-relaxed">
                    Koin Eco adalah reward yang Anda terima setelah pesanan penjemputan selesai, terutama jika sampah Anda terpilah dengan baik. Koin ini bisa digunakan untuk memotong biaya penjemputan berikutnya.
                </div>
            </div>
        </div>

    </div>

    <!-- Contact Support -->
    <div class="bg-primary/5 border border-primary/20 rounded-3xl p-6 md:p-8 flex flex-col md:flex-row items-center gap-6 text-center md:text-left">
        <div class="w-16 h-16 rounded-full bg-primary/20 flex items-center justify-center text-primary shrink-0">
            <span class="material-symbols-outlined text-[32px]">chat</span>
        </div>
        <div>
            <h3 class="font-bold text-lg md:text-xl text-primary mb-1">Masih butuh bantuan?</h3>
            <p class="text-sm md:text-base text-primary/80 mb-4">Tim support kami siap membantu Anda setiap Senin-Jumat, 08:00 - 17:00.</p>
            <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center gap-2 bg-primary text-white font-bold px-6 py-3 rounded-xl shadow-lg shadow-primary/30 hover:bg-primary-dark transition-colors">
                <span class="material-symbols-outlined text-[20px]">forum</span> Chat WhatsApp
            </a>
        </div>
    </div>
</div>
@endsection
