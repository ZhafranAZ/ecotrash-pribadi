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

        <!-- Global Error Messages -->
        @if ($errors->any())
            <div class="mb-4 p-4 rounded-lg bg-red-50 border border-red-200">
                <ul class="list-disc list-inside text-red-600 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Warning if redirected -->
        @if (session('warning'))
            <div class="mb-4 p-4 rounded-lg bg-amber-50 border border-amber-200">
                <div class="flex items-center gap-2 text-amber-700 text-sm font-medium">
                    <span class="material-symbols-outlined text-[18px]">warning</span>
                    {{ session('warning') }}
                </div>
            </div>
        @endif

        <!-- Address Setup Card -->
        <div class="glass-panel rounded-2xl p-8">
            <form method="POST" action="{{ route('setup-address.post') }}" class="flex flex-col gap-5">
                @csrf

                <!-- Nama Komplek (Dropdown - Dynamic) -->
                <div class="flex flex-col gap-1.5">
                    <label for="komplek_id" class="block font-medium text-sm text-on-surface">Nama Komplek</label>
                    <div class="relative">
                        <select id="komplek_id" name="komplek_id" required
                            class="block w-full appearance-none rounded-lg border-outline-variant bg-white/50 px-4 py-2.5 text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 transition-colors @error('komplek_id') border-red-500 @enderror">
                            <option value="" disabled {{ old('komplek_id') ? '' : 'selected' }}>Pilih komplek perumahan</option>
                            @foreach ($komplek as $k)
                                <option value="{{ $k->id }}" {{ old('komplek_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_komplek }}</option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">expand_more</span>
                    </div>
                    @error('komplek_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Blok / Nomor Rumah -->
                <div class="flex flex-col gap-1.5">
                    <label for="blok_nomor_rumah" class="block font-medium text-sm text-on-surface">Blok / Nomor Rumah</label>
                    <input id="blok_nomor_rumah" type="text" name="blok_nomor_rumah" value="{{ old('blok_nomor_rumah') }}" required
                        class="block w-full rounded-lg border-outline-variant bg-white/50 px-4 py-2.5 text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 transition-colors @error('blok_nomor_rumah') border-red-500 @enderror"
                        placeholder="Contoh: Blok B4 No. 12">
                    @error('blok_nomor_rumah')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Detail Alamat (Opsional) -->
                <div class="flex flex-col gap-1.5">
                    <label for="detail_patokan" class="block font-medium text-sm text-on-surface">Detail Tambahan (Opsional)</label>
                    <textarea id="detail_patokan" name="detail_patokan" rows="3"
                        class="block w-full rounded-lg border-outline-variant bg-white/50 px-4 py-2 text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 transition-colors @error('detail_patokan') border-red-500 @enderror"
                        placeholder="Patokan rumah, warna pagar, atau instruksi khusus untuk petugas">{{ old('detail_patokan') }}</textarea>
                    @error('detail_patokan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4 flex flex-col gap-4">
                    <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-bold h-12 rounded-lg transition-all hover:-translate-y-1 shadow-[var(--shadow-soft)] hover:shadow-[var(--shadow-glow)] active:scale-[0.98] flex items-center justify-center gap-2">
                        Selesai & Masuk Beranda
                        <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    </button>
                    
                    <form method="POST" action="{{ route('logout') }}" class="text-center">
                        @csrf
                        <button type="submit" class="text-sm text-on-surface-variant hover:text-on-surface transition-colors">
                            Keluar dari akun
                        </button>
                    </form>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
