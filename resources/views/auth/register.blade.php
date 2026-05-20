<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun - EcoTrash</title>

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
        <!-- Logo -->
        <div class="flex flex-col items-center justify-center mb-8 gap-3 text-center">
            <a href="/" class="flex items-center gap-2 text-primary hover:text-primary-dark transition-colors">
                <span class="material-symbols-outlined text-[40px]" style="font-variation-settings: 'FILL' 1;">eco</span>
            </a>
            <h1 class="font-display-lg text-2xl font-bold tracking-tight text-on-surface">Gabung Jadi Warga EcoTrash</h1>
            <p class="text-on-surface-variant text-sm px-4">Langkah awal untuk lingkungan komplek yang lebih bersih dan asri.</p>
        </div>

        <!-- Global Error Messages -->
        @if ($errors->any())
            <div class="mb-4 p-4 rounded-lg bg-red-50 border border-red-200">
                <div class="flex items-center gap-2 text-red-700 text-sm font-medium mb-1">
                    <span class="material-symbols-outlined text-[18px]">error</span>
                    Terjadi kesalahan:
                </div>
                <ul class="list-disc list-inside text-red-600 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Register Card -->
        <div class="glass-panel rounded-2xl p-8">
            <form method="POST" action="{{ route('register.post') }}" class="flex flex-col gap-5">
                @csrf

                <!-- Name -->
                <div class="flex flex-col gap-1.5">
                    <label for="nama" class="block font-medium text-sm text-on-surface">Nama Lengkap</label>
                    <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required autofocus autocomplete="name"
                        class="block w-full rounded-lg border-outline-variant bg-white/50 px-4 py-2.5 text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 transition-colors @error('nama') border-red-500 @enderror"
                        placeholder="Masukkan nama lengkap Anda">
                    @error('nama')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Number -->
                <div class="flex flex-col gap-1.5">
                    <label for="no_telepon" class="block font-medium text-sm text-on-surface">Nomor Telepon</label>
                    <input id="no_telepon" type="tel" name="no_telepon" value="{{ old('no_telepon') }}" required
                        class="block w-full rounded-lg border-outline-variant bg-white/50 px-4 py-2.5 text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 transition-colors @error('no_telepon') border-red-500 @enderror"
                        placeholder="Contoh: 081234567890">
                    <p class="text-xs text-on-surface-variant">Nomor telepon dapat diubah nanti melalui pengaturan profil.</p>
                    @error('no_telepon')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="flex flex-col gap-1.5">
                    <label for="email" class="block font-medium text-sm text-on-surface">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                        class="block w-full rounded-lg border-outline-variant bg-white/50 px-4 py-2.5 text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 transition-colors @error('email') border-red-500 @enderror"
                        placeholder="contoh@email.com">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="flex flex-col gap-1.5">
                    <label for="password" class="block font-medium text-sm text-on-surface">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="block w-full rounded-lg border-outline-variant bg-white/50 px-4 py-2.5 text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 transition-colors @error('password') border-red-500 @enderror"
                        placeholder="Buat password minimal 8 karakter">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="flex flex-col gap-1.5">
                    <label for="password_confirmation" class="block font-medium text-sm text-on-surface">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="block w-full rounded-lg border-outline-variant bg-white/50 px-4 py-2.5 text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 transition-colors"
                        placeholder="Ulangi password Anda">
                </div>

                <div class="mt-4 flex flex-col gap-4">
                    <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-bold h-12 rounded-lg transition-all hover:-translate-y-1 shadow-[var(--shadow-soft)] hover:shadow-[var(--shadow-glow)] active:scale-[0.98] flex items-center justify-center">
                        Daftar Sekarang
                    </button>
                    
                    <p class="text-center text-sm text-on-surface-variant mt-2">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-primary font-bold hover:text-primary-dark transition-colors">Masuk di sini</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
