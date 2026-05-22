@extends('layouts.admin')

@section('title', 'Pengaturan Sistem')
@section('subtitle', 'Konfigurasi harga, jadwal, koin, dan data komplek.')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
@endpush

@section('content')
@if(session('success'))
<div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-medium flex items-center gap-2">
    <span class="material-symbols-outlined text-[20px]">check_circle</span>
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm font-medium flex items-center gap-2">
    <span class="material-symbols-outlined text-[20px]">error</span>
    {{ session('error') }}
</div>
@endif
<div class="bg-white rounded-xl border border-outline-variant shadow-sm overflow-hidden" x-data="{ activeTab: 'harga', showKomplekModal: false, showDeleteKomplekModal: false, isEditMode: false, selectedKomplek: { id: null, nama_komplek: '', lat: '', lng: '' }, deleteKomplekId: null }">
    
    <!-- Tabs Header -->
    <div class="flex overflow-x-auto border-b border-outline-variant bg-surface-dim px-4">
        <button @click="activeTab = 'harga'" :class="activeTab === 'harga' ? 'border-primary text-primary font-bold' : 'border-transparent text-on-surface-variant hover:text-on-surface'" class="px-6 py-4 border-b-2 whitespace-nowrap transition-colors flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px]">payments</span> Harga & Koin
        </button>
        <button @click="activeTab = 'jadwal'" :class="activeTab === 'jadwal' ? 'border-primary text-primary font-bold' : 'border-transparent text-on-surface-variant hover:text-on-surface'" class="px-6 py-4 border-b-2 whitespace-nowrap transition-colors flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px]">event</span> Jadwal & Kuota
        </button>
        <button @click="activeTab = 'komplek'" :class="activeTab === 'komplek' ? 'border-primary text-primary font-bold' : 'border-transparent text-on-surface-variant hover:text-on-surface'" class="px-6 py-4 border-b-2 whitespace-nowrap transition-colors flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px]">domain</span> Manajemen Komplek
        </button>
    </div>

    <!-- Tab 1: Harga & Koin -->
    <div x-show="activeTab === 'harga'" class="p-6 sm:p-8" style="display: none;">
        <h3 class="text-lg font-bold text-on-surface mb-6">Konfigurasi Nilai Tukar & Harga Dasar</h3>
        
        <form class="max-w-2xl flex flex-col gap-6">
            <div class="bg-surface-dim p-4 rounded-lg border border-outline-variant">
                <label class="block font-medium text-sm text-on-surface mb-2">Nilai Tukar Koin Reward</label>
                <div class="flex items-center gap-3">
                    <span class="font-bold text-yellow-600 bg-yellow-100 px-3 py-2 rounded-lg">1 Koin</span>
                    <span class="text-on-surface-variant font-bold">=</span>
                    <div class="relative w-full sm:w-48">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant font-medium">Rp</span>
                        <input type="number" value="100" class="pl-10 pr-4 py-2 border border-outline-variant rounded-lg w-full text-on-surface bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                    </div>
                </div>
                <p class="text-xs text-on-surface-variant mt-2">Digunakan untuk menghitung diskon warga saat melakukan pemesanan.</p>
            </div>

            <div>
                <label class="block font-medium text-sm text-on-surface mb-3">Harga Dasar Layanan (Berdasarkan Ukuran)</label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <!-- Kecil -->
                    <div class="border border-outline-variant rounded-lg p-4 bg-white">
                        <p class="text-sm font-semibold text-on-surface mb-2">Ukuran Kecil</p>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant font-medium">Rp</span>
                            <input type="number" value="10000" class="pl-10 pr-4 py-2 border border-outline-variant rounded-md w-full text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                        </div>
                    </div>
                    <!-- Sedang -->
                    <div class="border border-outline-variant rounded-lg p-4 bg-white">
                        <p class="text-sm font-semibold text-on-surface mb-2">Ukuran Sedang</p>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant font-medium">Rp</span>
                            <input type="number" value="20000" class="pl-10 pr-4 py-2 border border-outline-variant rounded-md w-full text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                        </div>
                    </div>
                    <!-- Besar -->
                    <div class="border border-outline-variant rounded-lg p-4 bg-white">
                        <p class="text-sm font-semibold text-on-surface mb-2">Ukuran Besar</p>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant font-medium">Rp</span>
                            <input type="number" value="35000" class="pl-10 pr-4 py-2 border border-outline-variant rounded-md w-full text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bonus Koin -->
            <div>
                <label class="block font-medium text-sm text-on-surface mb-3">Bonus Koin Reward Warga (Berdasarkan Ukuran)</label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <!-- Kecil -->
                    <div class="border border-outline-variant rounded-lg p-4 bg-white">
                        <p class="text-sm font-semibold text-on-surface mb-2">Ukuran Kecil</p>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-amber-500 font-medium material-symbols-outlined text-[18px]">generating_tokens</span>
                            <input type="number" value="10" class="pl-10 pr-4 py-2 border border-outline-variant rounded-md w-full text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                        </div>
                    </div>
                    <!-- Sedang -->
                    <div class="border border-outline-variant rounded-lg p-4 bg-white">
                        <p class="text-sm font-semibold text-on-surface mb-2">Ukuran Sedang</p>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-amber-500 font-medium material-symbols-outlined text-[18px]">generating_tokens</span>
                            <input type="number" value="20" class="pl-10 pr-4 py-2 border border-outline-variant rounded-md w-full text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                        </div>
                    </div>
                    <!-- Besar -->
                    <div class="border border-outline-variant rounded-lg p-4 bg-white">
                        <p class="text-sm font-semibold text-on-surface mb-2">Ukuran Besar</p>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-amber-500 font-medium material-symbols-outlined text-[18px]">generating_tokens</span>
                            <input type="number" value="35" class="pl-10 pr-4 py-2 border border-outline-variant rounded-md w-full text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-outline-variant">
                <button type="button" class="bg-primary hover:bg-primary-dark text-white px-6 py-2.5 rounded-lg font-bold transition-colors">Simpan Perubahan Harga</button>
            </div>
        </form>
    </div>

    <!-- Tab 2: Jadwal & Kuota -->
    <div x-show="activeTab === 'jadwal'" class="p-6 sm:p-8" style="display: none;">
        <h3 class="text-lg font-bold text-on-surface mb-6">Ketersediaan & Batas Pemesanan</h3>
        
        <form class="max-w-2xl flex flex-col gap-6">
            <div>
                <label class="block font-medium text-sm text-on-surface mb-3">Hari Operasional (Hari Kerja TPS)</label>
                <div class="flex flex-wrap gap-3">
                    <label class="flex items-center gap-2 bg-surface-variant px-4 py-2 rounded-lg cursor-pointer hover:bg-outline-variant transition-colors">
                        <input type="checkbox" checked class="rounded text-primary focus:ring-primary h-4 w-4 border-outline-variant">
                        <span class="text-sm font-medium">Senin</span>
                    </label>
                    <label class="flex items-center gap-2 bg-surface-variant px-4 py-2 rounded-lg cursor-pointer hover:bg-outline-variant transition-colors">
                        <input type="checkbox" checked class="rounded text-primary focus:ring-primary h-4 w-4 border-outline-variant">
                        <span class="text-sm font-medium">Selasa</span>
                    </label>
                    <label class="flex items-center gap-2 bg-surface-variant px-4 py-2 rounded-lg cursor-pointer hover:bg-outline-variant transition-colors opacity-60">
                        <input type="checkbox" class="rounded text-primary focus:ring-primary h-4 w-4 border-outline-variant">
                        <span class="text-sm font-medium">Rabu</span>
                    </label>
                    <label class="flex items-center gap-2 bg-surface-variant px-4 py-2 rounded-lg cursor-pointer hover:bg-outline-variant transition-colors">
                        <input type="checkbox" checked class="rounded text-primary focus:ring-primary h-4 w-4 border-outline-variant">
                        <span class="text-sm font-medium">Kamis</span>
                    </label>
                    <label class="flex items-center gap-2 bg-surface-variant px-4 py-2 rounded-lg cursor-pointer hover:bg-outline-variant transition-colors">
                        <input type="checkbox" checked class="rounded text-primary focus:ring-primary h-4 w-4 border-outline-variant">
                        <span class="text-sm font-medium">Jumat</span>
                    </label>
                    <label class="flex items-center gap-2 bg-surface-variant px-4 py-2 rounded-lg cursor-pointer hover:bg-outline-variant transition-colors">
                        <input type="checkbox" checked class="rounded text-primary focus:ring-primary h-4 w-4 border-outline-variant">
                        <span class="text-sm font-medium">Sabtu</span>
                    </label>
                    <label class="flex items-center gap-2 bg-surface-variant px-4 py-2 rounded-lg cursor-pointer hover:bg-outline-variant transition-colors opacity-60">
                        <input type="checkbox" class="rounded text-primary focus:ring-primary h-4 w-4 border-outline-variant">
                        <span class="text-sm font-medium">Minggu</span>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block font-medium text-sm text-on-surface mb-2">Batas Waktu Pemesanan (Cut-off Time)</label>
                    <div class="flex items-center gap-2">
                        <input type="time" value="20:00" class="px-4 py-2 border border-outline-variant rounded-lg text-on-surface bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                        <span class="text-sm text-on-surface-variant">WIB (H-1)</span>
                    </div>
                </div>
                <div>
                    <label class="block font-medium text-sm text-on-surface mb-2">Kuota Pesanan Maksimal Harian</label>
                    <div class="flex items-center gap-2">
                        <input type="number" value="100" class="px-4 py-2 border border-outline-variant rounded-lg w-24 text-on-surface bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                        <span class="text-sm text-on-surface-variant">Pesanan / Hari</span>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-outline-variant">
                <button type="button" class="bg-primary hover:bg-primary-dark text-white px-6 py-2.5 rounded-lg font-bold transition-colors">Simpan Jadwal & Kuota</button>
            </div>
        </form>
    </div>

    <!-- Tab 3: Manajemen Komplek -->
    <div x-show="activeTab === 'komplek'" class="p-0" style="display: none;">
        <div class="p-4 sm:p-6 border-b border-outline-variant flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h3 class="text-lg font-bold text-on-surface">Daftar Komplek Terdaftar</h3>
            <button @click="selectedKomplek = { id: null, nama_komplek: '', lat: '', lng: '' }; isEditMode = false; showKomplekModal = true; setTimeout(() => window.dispatchEvent(new Event('resize')), 100)" class="bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2 text-sm">
                <span class="material-symbols-outlined text-[20px]">add</span> Komplek Baru
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-dim text-on-surface-variant text-sm border-b border-outline-variant">
                        <th class="py-3 px-6 font-semibold">ID</th>
                        <th class="py-3 px-6 font-semibold">Nama Komplek</th>
                        <th class="py-3 px-6 font-semibold">Titik Kordinat (Pusat)</th>
                        <th class="py-3 px-6 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($kompleks as $k)
                    <tr class="border-b border-outline-variant hover:bg-surface-variant/50 transition-colors">
                        <td class="py-4 px-6 text-on-surface font-medium">#K-{{ str_pad($k->id, 2, '0', STR_PAD_LEFT) }}</td>
                        <td class="py-4 px-6 text-on-surface font-semibold">{{ $k->nama_komplek }}</td>
                        <td class="py-4 px-6 text-on-surface-variant font-mono text-xs">{{ $k->lat }}, {{ $k->lng }}</td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex justify-end gap-2">
                                <button @click="selectedKomplek = { id: {{ $k->id }}, nama_komplek: '{{ addslashes($k->nama_komplek) }}', lat: '{{ $k->lat }}', lng: '{{ $k->lng }}' }; isEditMode = true; showKomplekModal = true; setTimeout(() => window.dispatchEvent(new Event('resize')), 100)" class="text-blue-600 hover:bg-blue-50 p-1.5 rounded-md transition-colors" title="Edit"><span class="material-symbols-outlined text-[20px]">edit</span></button>
                                <button @click="deleteKomplekId = {{ $k->id }}; showDeleteKomplekModal = true" class="text-red-600 hover:bg-red-50 p-1.5 rounded-md transition-colors" title="Hapus"><span class="material-symbols-outlined text-[20px]">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-8 px-6 text-center text-on-surface-variant text-sm">Belum ada data komplek.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah/Edit Komplek -->
    <div x-show="showKomplekModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div x-show="showKomplekModal" x-transition.opacity class="fixed inset-0 bg-black/50 transition-opacity" @click="showKomplekModal = false"></div>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showKomplekModal" x-transition.scale class="relative bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-xl w-full">
                <form :action="isEditMode ? '{{ url('admin/pengaturan/komplek') }}/' + selectedKomplek.id : '{{ route('admin.pengaturan.komplek.store') }}'" method="POST">
                @csrf
                <template x-if="isEditMode"><input type="hidden" name="_method" value="PUT"></template>
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg leading-6 font-bold text-on-surface" x-text="isEditMode ? 'Edit Data Komplek' : 'Tambah Komplek Baru'"></h3>
                        <button type="button" @click="showKomplekModal = false" class="text-on-surface-variant hover:text-on-surface"><span class="material-symbols-outlined">close</span></button>
                    </div>
                    <div class="mb-4">
                        <div class="flex flex-col gap-4">
                            <div>
                                <label class="block font-medium text-sm text-on-surface mb-1">Nama Komplek</label>
                                <input type="text" name="nama_komplek" :value="isEditMode ? selectedKomplek.nama_komplek : ''" placeholder="Cth: Komplek Bumi Asri" class="w-full px-4 py-2 border border-outline-variant rounded-lg text-sm text-on-surface bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                                @error('nama_komplek')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-medium text-sm text-on-surface mb-1">Latitude</label>
                                    <input type="text" name="lat" id="lat-input" :value="isEditMode ? selectedKomplek.lat : ''" placeholder="-6.9147" class="w-full px-4 py-2 border border-outline-variant rounded-lg text-sm text-on-surface bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none font-mono">
                                    @error('lat')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block font-medium text-sm text-on-surface mb-1">Longitude</label>
                                    <input type="text" name="lng" id="lng-input" :value="isEditMode ? selectedKomplek.lng : ''" placeholder="107.6098" class="w-full px-4 py-2 border border-outline-variant rounded-lg text-sm text-on-surface bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none font-mono">
                                    @error('lng')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <!-- Peta Leaflet -->
                            <div class="relative w-full h-48 rounded-lg border border-outline-variant overflow-hidden z-0">
                                <div id="komplek-map" class="absolute inset-0 z-0"></div>
                            </div>
                            <p class="text-xs text-on-surface-variant mt-1">Geser pin pada peta untuk menyesuaikan koordinat secara otomatis.</p>
                        </div>
                    </div>
                </div>
                <div class="bg-surface-dim px-4 py-3 sm:px-6 flex flex-col sm:flex-row-reverse gap-2 border-t border-outline-variant">
                    <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-bold text-white hover:bg-primary-dark focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Simpan Komplek</button>
                    <button type="button" @click="showKomplekModal = false" class="mt-3 w-full inline-flex justify-center rounded-lg border border-outline-variant shadow-sm px-4 py-2 bg-white text-base font-bold text-on-surface hover:bg-surface-variant focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Hapus Komplek -->
    <div x-show="showDeleteKomplekModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div x-show="showDeleteKomplekModal" x-transition.opacity class="fixed inset-0 bg-black/50 transition-opacity" @click="showDeleteKomplekModal = false"></div>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showDeleteKomplekModal" x-transition.scale class="relative bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-md w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <span class="material-symbols-outlined text-red-600">warning</span>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-bold text-on-surface">Hapus Komplek</h3>
                            <div class="mt-2">
                                <p class="text-sm text-on-surface-variant">Apakah Anda yakin ingin menghapus Komplek ini? Seluruh data warga dan pesanan terkait komplek ini akan terpengaruh. Tindakan ini tidak dapat dibatalkan.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-surface-dim px-4 py-3 sm:px-6 flex flex-col sm:flex-row-reverse gap-2 border-t border-outline-variant">
                    <form :action="'{{ url('admin/pengaturan/komplek') }}/' + deleteKomplekId" method="POST" class="w-full sm:w-auto">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-bold text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Ya, Hapus Komplek</button>
                    </form>
                    <button type="button" @click="showDeleteKomplekModal = false" class="mt-3 w-full inline-flex justify-center rounded-lg border border-outline-variant shadow-sm px-4 py-2 bg-white text-base font-bold text-on-surface hover:bg-surface-variant focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let map = null;
        let marker = null;

        // Initialize map when window is resized (which we trigger when opening modal)
        window.addEventListener('resize', function() {
            // Check if map container exists and is visible
            const mapContainer = document.getElementById('komplek-map');
            if (mapContainer && mapContainer.offsetParent !== null) {
                if (!map) {
                    map = L.map('komplek-map').setView([-6.9147, 107.6098], 13);
                    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                        attribution: '&copy; OpenStreetMap'
                    }).addTo(map);

                    marker = L.marker([-6.9147, 107.6098], {draggable: true}).addTo(map);

                    // Sync marker drag to inputs
                    marker.on('dragend', function (e) {
                        const latLng = marker.getLatLng();
                        document.getElementById('lat-input').value = latLng.lat.toFixed(5);
                        document.getElementById('lng-input').value = latLng.lng.toFixed(5);
                    });

                    // Sync map click to marker and inputs
                    map.on('click', function(e) {
                        marker.setLatLng(e.latlng);
                        document.getElementById('lat-input').value = e.latlng.lat.toFixed(5);
                        document.getElementById('lng-input').value = e.latlng.lng.toFixed(5);
                    });
                }
                map.invalidateSize(); // Fix leafet rendering in modal
            }
        });
    });
</script>
@endpush
