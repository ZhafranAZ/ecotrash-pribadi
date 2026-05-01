<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EcoTrash') }} - Petugas</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900 pb-20">
    <div class="min-h-screen max-w-md mx-auto bg-gray-50 shadow-2xl relative overflow-x-hidden">
        
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        <!-- Bottom Navigation -->
        <x-petugas.bottom-nav />
    </div>
</body>
</html>
