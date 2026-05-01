<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atur Alamat - EcoTrash</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface-dim text-on-surface font-body-md antialiased min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    
    <!-- Decorative Background -->
    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-primary/10 rounded-full blur-[80px] pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-accent/10 rounded-full blur-[80px] pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10 py-8">
        <!-- Progress Indicator -->
        <div class="flex justify-center mb-8 gap-2">
            <div class="w-12 h-1.5 rounded-full bg-primary/20"></div>
            <div class="w-12 h-1.5 rounded-full bg-primary shadow-[0_0_10px_rgba(16,185,129,0.5)]"></div>
        </div>

        <!-- Header -->
        <div class="flex flex-col items-center justify-center mb-8 gap-3 text-center">
            <span class="material-symbols-outlined text-[48px] text-primary" style="font-variation-settings: 'FILL' 1;">location_on</span>
            <h1 class="font-display-lg text-2xl font-bold tracking-tight text-on-surface">Atur Alamat Utama</h1>
            <p class="text-on-surface-variant text-sm px-4">Bantu kami mengetahui lokasi rumah Anda untuk penjemputan sampah yang akurat.</p>
        </div>

        <!-- Address Setup Card -->
        <div class="glass-panel rounded-2xl p-8">
            <form method="POST" action="{{ route('setup-address.post') }}" class="flex flex-col gap-5">
                @csrf

                <!-- Nama Komplek (Dropdown) -->
                <div class="flex flex-col gap-1.5">
                    <label for="komplek" class="block font-medium text-sm text-on-surface">Nama Komplek</label>
                    <div class="relative">
                        <select id="komplek" name="komplek" required
                            class="block w-full appearance-none rounded-lg border-outline-variant bg-white/50 px-4 py-2.5 text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 transition-colors">
                            <option value="" disabled selected>Pilih komplek perumahan</option>
                            <option value="1">Green Valley Residence</option>
                            <option value="2">Permata Hijau Permai</option>
                            <option value="3">Bukit Asri Cluster</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">expand_more</span>
                    </div>
                </div>

                <!-- Blok / Nomor Rumah -->
                <div class="flex flex-col gap-1.5">
                    <label for="blok_nomor" class="block font-medium text-sm text-on-surface">Blok / Nomor Rumah</label>
                    <input id="blok_nomor" type="text" name="blok_nomor" required
                        class="block w-full rounded-lg border-outline-variant bg-white/50 px-4 py-2.5 text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 transition-colors"
                        placeholder="Contoh: Blok B4 No. 12">
                </div>

                <!-- Detail Alamat (Opsional) -->
                <div class="flex flex-col gap-1.5">
                    <label for="detail" class="block font-medium text-sm text-on-surface">Detail Tambahan (Opsional)</label>
                    <textarea id="detail" name="detail" rows="3"
                        class="block w-full rounded-lg border-outline-variant bg-white/50 px-4 py-2 text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 transition-colors"
                        placeholder="Patokan rumah, warna pagar, atau instruksi khusus untuk petugas"></textarea>
                </div>

                <div class="mt-4 flex flex-col gap-4">
                    <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-bold h-12 rounded-lg transition-all hover:-translate-y-1 shadow-[var(--shadow-soft)] hover:shadow-[var(--shadow-glow)] active:scale-[0.98] flex items-center justify-center gap-2">
                        Selesai & Masuk Beranda
                        <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    </button>
                    
                    <button type="button" onclick="history.back()" class="text-center text-sm text-on-surface-variant hover:text-on-surface transition-colors">
                        Kembali ke pendaftaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
