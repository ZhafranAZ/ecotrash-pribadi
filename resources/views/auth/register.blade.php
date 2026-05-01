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

        <!-- Register Card -->
        <div class="glass-panel rounded-2xl p-8">
            <form method="POST" action="{{ route('register.post') }}" class="flex flex-col gap-5">
                @csrf

                <!-- Name -->
                <div class="flex flex-col gap-1.5">
                    <label for="name" class="block font-medium text-sm text-on-surface">Nama Lengkap</label>
                    <input id="name" type="text" name="name" required autofocus autocomplete="name"
                        class="block w-full rounded-lg border-outline-variant bg-white/50 px-4 py-2.5 text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 transition-colors"
                        placeholder="Masukkan nama lengkap Anda">
                </div>

                <!-- Email Address -->
                <div class="flex flex-col gap-1.5">
                    <label for="email" class="block font-medium text-sm text-on-surface">Email / Kontak</label>
                    <input id="email" type="email" name="email" required autocomplete="username"
                        class="block w-full rounded-lg border-outline-variant bg-white/50 px-4 py-2.5 text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 transition-colors"
                        placeholder="contoh@email.com">
                </div>

                <!-- Password -->
                <div class="flex flex-col gap-1.5">
                    <label for="password" class="block font-medium text-sm text-on-surface">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="block w-full rounded-lg border-outline-variant bg-white/50 px-4 py-2.5 text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 transition-colors"
                        placeholder="Buat password minimal 8 karakter">
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
                        <a href="/login" class="text-primary font-bold hover:text-primary-dark transition-colors">Masuk di sini</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
