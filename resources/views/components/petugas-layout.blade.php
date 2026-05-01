@props(['hideNav' => false])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EcoTrash') }} - Petugas</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('styles')

    <style>
        /* Safe area for mobile devices */
        .pb-safe { padding-bottom: env(safe-area-inset-bottom); }
        .pt-safe { padding-top: env(safe-area-inset-top); }
    </style>
</head>
<body class="font-body-md antialiased bg-surface-dim min-h-screen text-on-surface pb-20 pb-safe">
    <div class="min-h-screen max-w-md mx-auto bg-surface-dim relative overflow-x-hidden md:border-x md:border-outline md:shadow-xl">
        
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        @if(!$hideNav)
        <!-- Bottom Navigation -->
        <x-petugas.bottom-nav />
        @endif
    </div>

    @stack('scripts')
</body>
</html>
