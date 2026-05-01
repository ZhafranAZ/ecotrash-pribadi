@extends('layouts.admin')

@section('title', 'Dasbor Utama')
@section('subtitle', 'Ringkasan aktivitas dan metrik operasional EcoTrash hari ini.')

@push('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    #map { height: 400px; z-index: 1; border-radius: 0.75rem; }
</style>
@endpush

@section('content')
<!-- Stat Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl border border-outline-variant shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-[28px]">group</span>
        </div>
        <div>
            <p class="text-sm font-medium text-on-surface-variant">Total Warga</p>
            <p class="text-2xl font-bold text-on-surface">1,248</p>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-xl border border-outline-variant shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-primary/10 text-primary flex items-center justify-center">
            <span class="material-symbols-outlined text-[28px]">local_shipping</span>
        </div>
        <div>
            <p class="text-sm font-medium text-on-surface-variant">Pesanan Hari Ini</p>
            <p class="text-2xl font-bold text-on-surface">45</p>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-xl border border-outline-variant shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-red-50 text-red-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-[28px]">warning</span>
        </div>
        <div>
            <p class="text-sm font-medium text-on-surface-variant">Laporan Pending</p>
            <p class="text-2xl font-bold text-on-surface">12</p>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-xl border border-outline-variant shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-yellow-50 text-yellow-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-[28px]">monetization_on</span>
        </div>
        <div>
            <p class="text-sm font-medium text-on-surface-variant">Koin Beredar</p>
            <p class="text-2xl font-bold text-on-surface">54,300</p>
        </div>
    </div>
</div>

<!-- Map Section -->
<div class="bg-white rounded-xl border border-outline-variant shadow-sm mb-8 overflow-hidden">
    <div class="px-6 py-4 border-b border-outline-variant flex items-center justify-between">
        <h2 class="font-bold text-lg text-on-surface">Peta Operasional & Laporan Liar</h2>
        <div class="flex gap-4 text-sm">
            <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-blue-500"></span> TPS Komplek</span>
            <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-red-500"></span> Laporan Liar</span>
        </div>
    </div>
    <div class="p-4">
        <div id="map"></div>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div class="bg-white p-6 rounded-xl border border-outline-variant shadow-sm">
        <h2 class="font-bold text-lg text-on-surface mb-6">Tren Pesanan Pengangkutan (30 Hari)</h2>
        <div class="relative h-64 w-full">
            <canvas id="pesananChart"></canvas>
        </div>
    </div>
    <div class="bg-white p-6 rounded-xl border border-outline-variant shadow-sm">
        <h2 class="font-bold text-lg text-on-surface mb-6">Laporan Sampah Liar (Per Minggu)</h2>
        <div class="relative h-64 w-full">
            <canvas id="laporanChart"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- 1. Init Leaflet Map ---
        // Centered around a dummy coordinate (Bandung example)
        const map = L.map('map').setView([-6.914744, 107.609810], 13);
        
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        // Dummy Markers
        const markers = [
            { lat: -6.915, lng: 107.610, type: 'tps', title: 'TPS Komplek A' },
            { lat: -6.912, lng: 107.605, type: 'tps', title: 'TPS Komplek B' },
            { lat: -6.918, lng: 107.615, type: 'liar', title: 'Laporan: Sampah di selokan' },
            { lat: -6.920, lng: 107.608, type: 'liar', title: 'Laporan: Tumpukan di lahan kosong' },
        ];

        // Custom Icons
        const tpsIcon = L.divIcon({
            className: 'custom-icon',
            html: `<div style="background-color: #3b82f6; width: 16px; height: 16px; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 4px rgba(0,0,0,0.3);"></div>`,
            iconSize: [16, 16],
            iconAnchor: [8, 8]
        });

        const liarIcon = L.divIcon({
            className: 'custom-icon',
            html: `<div style="background-color: #ef4444; width: 16px; height: 16px; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 4px rgba(0,0,0,0.3); animation: pulse 2s infinite;"></div>`,
            iconSize: [16, 16],
            iconAnchor: [8, 8]
        });

        markers.forEach(m => {
            L.marker([m.lat, m.lng], { icon: m.type === 'tps' ? tpsIcon : liarIcon })
             .bindPopup(`<b>${m.title}</b>`)
             .addTo(map);
        });

        // --- 2. Init Chart.js ---
        // Theme colors from Tailwind config
        const primaryColor = '#10B981';
        const redColor = '#EF4444';

        // Pesanan Line Chart
        const ctxPesanan = document.getElementById('pesananChart').getContext('2d');
        new Chart(ctxPesanan, {
            type: 'line',
            data: {
                labels: ['1 Mei', '5 Mei', '10 Mei', '15 Mei', '20 Mei', '25 Mei', '30 Mei'],
                datasets: [{
                    label: 'Pesanan Selesai',
                    data: [12, 19, 15, 25, 22, 30, 45],
                    borderColor: primaryColor,
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f3f4f6' } },
                    x: { grid: { display: false } }
                }
            }
        });

        // Laporan Bar Chart
        const ctxLaporan = document.getElementById('laporanChart').getContext('2d');
        new Chart(ctxLaporan, {
            type: 'bar',
            data: {
                labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
                datasets: [{
                    label: 'Laporan Masuk',
                    data: [8, 12, 5, 15],
                    backgroundColor: redColor,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f3f4f6' } },
                    x: { grid: { display: false } }
                }
            }
        });
    });
</script>
@endpush
