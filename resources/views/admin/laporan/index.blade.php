@extends('layouts.admin')

@section('title', 'Laporan Sampah Liar')
@section('subtitle', 'Kelola dan verifikasi laporan tumpukan sampah dari warga.')

@section('content')
<div x-data="{ showModal: false, isApproving: false, isRejecting: false, isMerging: false }">
    <div class="bg-white rounded-xl border border-outline shadow-sm overflow-hidden flex flex-col mb-8">
        <!-- Header/Filter -->
        <div class="p-4 border-b border-outline flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex gap-2">
                <select class="border border-outline rounded-lg px-3 py-2 text-sm text-on-surface bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                    <option value="">Semua Status</option>
                    <option value="pending">Menunggu</option>
                    <option value="approved">Disetujui</option>
                    <option value="rejected">Ditolak</option>
                </select>
            </div>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[18px]">search</span>
                <input type="text" placeholder="Cari ID atau nama pelapor..." class="pl-9 pr-4 py-2 border border-outline rounded-lg text-sm w-full sm:w-64 focus:border-primary focus:ring-1 focus:ring-primary outline-none">
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-dim text-on-surface-variant text-sm border-b border-outline">
                        <th class="py-3 px-4 font-semibold">ID Laporan</th>
                        <th class="py-3 px-4 font-semibold">Tanggal</th>
                        <th class="py-3 px-4 font-semibold">Pelapor</th>
                        <th class="py-3 px-4 font-semibold">Lokasi</th>
                        <th class="py-3 px-4 font-semibold">Foto</th>
                        <th class="py-3 px-4 font-semibold">Status</th>
                        <th class="py-3 px-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    <tr class="border-b border-outline hover:bg-surface-variant/50 transition-colors">
                        <td class="py-3 px-4 text-on-surface font-medium">#LP-20260510-01</td>
                        <td class="py-3 px-4 text-on-surface-variant">10 Mei 2026</td>
                        <td class="py-3 px-4 text-on-surface">Budi Santoso</td>
                        <td class="py-3 px-4 text-on-surface-variant truncate max-w-[150px]">Jl. Mawar Gg. 2</td>
                        <td class="py-3 px-4">
                            <div class="w-10 h-10 bg-surface-variant rounded flex items-center justify-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-[20px]">image</span>
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-yellow-50 text-yellow-700 ring-1 ring-inset ring-yellow-600/20">Menunggu</span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <button @click="showModal = true; isApproving = false; isRejecting = false; isMerging = false" class="text-primary hover:text-primary-dark p-1 rounded-md hover:bg-primary/10 transition-colors" title="Lihat Detail">
                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b border-outline hover:bg-surface-variant/50 transition-colors">
                        <td class="py-3 px-4 text-on-surface font-medium">#LP-20260509-12</td>
                        <td class="py-3 px-4 text-on-surface-variant">09 Mei 2026</td>
                        <td class="py-3 px-4 text-on-surface">Siti Aminah</td>
                        <td class="py-3 px-4 text-on-surface-variant truncate max-w-[150px]">Lahan kosong Blok C</td>
                        <td class="py-3 px-4">
                            <div class="w-10 h-10 bg-surface-variant rounded flex items-center justify-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-[20px]">image</span>
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-green-50 text-green-700 ring-1 ring-inset ring-green-600/20">Disetujui</span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <button @click="showModal = true; isApproving = false; isRejecting = false; isMerging = false" class="text-primary hover:text-primary-dark p-1 rounded-md hover:bg-primary/10 transition-colors">
                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b border-outline hover:bg-surface-variant/50 transition-colors">
                        <td class="py-3 px-4 text-on-surface font-medium">#LP-20260508-05</td>
                        <td class="py-3 px-4 text-on-surface-variant">08 Mei 2026</td>
                        <td class="py-3 px-4 text-on-surface">Joko Widodo</td>
                        <td class="py-3 px-4 text-on-surface-variant truncate max-w-[150px]">Depan taman bermain</td>
                        <td class="py-3 px-4">
                            <div class="w-10 h-10 bg-surface-variant rounded flex items-center justify-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-[20px]">image</span>
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-red-50 text-red-700 ring-1 ring-inset ring-red-600/10">Ditolak</span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <button @click="showModal = true; isApproving = false; isRejecting = false; isMerging = false" class="text-primary hover:text-primary-dark p-1 rounded-md hover:bg-primary/10 transition-colors">
                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                            </button>
                        </td>
                    </tr>

                    <!-- Empty State Row (hidden when there's data) -->
                    <tr x-show="false" class="hover:bg-transparent">
                        <td colspan="7" class="py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-on-surface-variant">
                                <span class="material-symbols-outlined text-[48px] opacity-40">inbox</span>
                                <p class="font-medium">Belum ada laporan masuk</p>
                                <p class="text-sm">Laporan dari warga akan muncul di sini.</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-4 border-t border-outline flex items-center justify-between">
            <p class="text-sm text-on-surface-variant">Menampilkan <span class="font-medium text-on-surface">1</span> sampai <span class="font-medium text-on-surface">3</span> dari <span class="font-medium text-on-surface">12</span> data</p>
            <div class="flex gap-1">
                <button class="px-3 py-1 border border-outline rounded-md text-sm text-on-surface-variant hover:bg-surface-variant disabled:opacity-50" disabled>Sebelumnya</button>
                <button class="px-3 py-1 border border-primary bg-primary text-white rounded-md text-sm font-medium">1</button>
                <button class="px-3 py-1 border border-outline rounded-md text-sm text-on-surface hover:bg-surface-variant">2</button>
                <button class="px-3 py-1 border border-outline rounded-md text-sm text-on-surface hover:bg-surface-variant">Selanjutnya</button>
            </div>
        </div>
    </div>

    <!-- Modal Detail Laporan -->
    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-black/50" @click="showModal = false"></div>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="relative bg-white rounded-xl text-left overflow-hidden shadow-xl sm:my-8 sm:max-w-lg w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg leading-6 font-bold text-on-surface">Detail Laporan #LP-20260510-01</h3>
                        <button @click="showModal = false" class="text-on-surface-variant hover:text-on-surface"><span class="material-symbols-outlined">close</span></button>
                    </div>

                    <!-- Default View -->
                    <div x-show="!isApproving && !isRejecting && !isMerging">
                        <div class="w-full h-48 bg-surface-variant rounded-lg border border-outline relative overflow-hidden mb-4 z-10">
                            <!-- Map Container -->
                            <div id="admin-map" class="w-full h-full"></div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                            <div><p class="text-on-surface-variant font-medium">Pelapor</p><p class="text-on-surface font-semibold">Budi Santoso</p></div>
                            <div><p class="text-on-surface-variant font-medium">Tanggal</p><p class="text-on-surface font-semibold">10 Mei 2026</p></div>
                            <div class="col-span-2"><p class="text-on-surface-variant font-medium">Titik Lokasi</p><p class="text-on-surface font-semibold">Jl. Mawar Gg. 2, Dekat tiang listrik lama</p></div>
                            <div class="col-span-2">
                                <p class="text-on-surface-variant font-medium">Deskripsi Warga</p>
                                <p class="text-on-surface bg-surface-dim p-3 rounded-lg border border-outline mt-1">"Ada tumpukan sampah plastik dan sisa makanan yang baunya mengganggu jalanan sejak 2 hari lalu."</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-on-surface-variant font-medium">Status Pekerjaan Lapangan (Petugas)</p>
                                <div class="bg-primary/10 border border-primary/20 p-3 rounded-lg mt-1 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary">engineering</span>
                                    <div>
                                        <p class="text-primary-dark font-bold">Sedang Dibersihkan</p>
                                        <p class="text-[10px] text-primary">Petugas: Udin Sedunia</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row-reverse gap-2 border-t border-outline pt-4">
                            <button @click="isApproving = true" class="w-full inline-flex justify-center rounded-lg px-4 py-2 bg-primary text-sm font-bold text-white hover:bg-primary-dark sm:w-auto">Setujui Laporan</button>
                            <button @click="isMerging = true" class="w-full inline-flex justify-center rounded-lg px-4 py-2 bg-amber-500 text-sm font-bold text-white hover:bg-amber-600 sm:w-auto">Tandai Duplikat</button>
                            <button @click="isRejecting = true" class="w-full inline-flex justify-center rounded-lg px-4 py-2 bg-red-50 text-sm font-bold text-red-700 hover:bg-red-100 border border-red-200 sm:w-auto">Tolak Laporan</button>
                        </div>
                    </div>

                    <!-- Approve Form -->
                    <div x-show="isApproving" style="display: none;">
                        <div class="bg-primary/10 p-3 rounded-lg mb-4 flex gap-2 text-sm text-primary-dark">
                            <span class="material-symbols-outlined text-primary text-[18px] shrink-0 mt-0.5">info</span>
                            Tugaskan petugas dan tentukan koin bonus sebelum mengkonfirmasi persetujuan.
                        </div>
                        <div class="flex flex-col gap-4 mb-4">
                            <div>
                                <label class="block font-medium text-sm text-on-surface mb-1">Tugaskan Petugas Lapangan</label>
                                <select class="w-full px-4 py-2 border border-outline rounded-lg text-sm text-on-surface bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                                    <option value="">Pilih Petugas...</option>
                                    <option>Jajang Suryana</option>
                                    <option>Udin Sedunia</option>
                                </select>
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-on-surface mb-1">Koin Bonus untuk Pelapor</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-yellow-500 text-[20px]">monetization_on</span>
                                    <input type="number" value="10" class="pl-10 pr-4 py-2 border border-outline rounded-lg w-full text-sm font-bold text-yellow-600 focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                                </div>
                                <p class="text-xs text-on-surface-variant mt-1">Default 10 koin. Bisa disesuaikan.</p>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row-reverse gap-2 border-t border-outline pt-4">
                            <button @click="showModal = false; $dispatch('show-toast', { message: '✅ Laporan disetujui & petugas ditugaskan!', type: 'success' })" class="w-full inline-flex justify-center rounded-lg px-4 py-2 bg-primary text-sm font-bold text-white hover:bg-primary-dark sm:w-auto">Konfirmasi & Tugaskan</button>
                            <button @click="isApproving = false" class="w-full inline-flex justify-center rounded-lg px-4 py-2 border border-outline text-sm font-bold text-on-surface hover:bg-surface-variant sm:w-auto">Kembali</button>
                        </div>
                    </div>

                    <!-- Reject Form -->
                    <div x-show="isRejecting" style="display: none;">
                        <div class="bg-red-50 p-3 rounded-lg mb-4 flex gap-2 text-sm text-red-700 border border-red-200">
                            <span class="material-symbols-outlined text-red-600 text-[18px] shrink-0 mt-0.5">warning</span>
                            Penolakan akan dikirimkan ke pelapor. Pastikan alasan penolakan jelas.
                        </div>
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-on-surface mb-1">Alasan Penolakan <span class="text-red-500">*</span></label>
                            <textarea rows="4" placeholder="Contoh: Foto tidak jelas, lokasi tidak sesuai deskripsi, dsb." class="w-full px-4 py-2 border border-outline rounded-lg text-sm text-on-surface bg-white focus:border-red-400 focus:ring-1 focus:ring-red-400 outline-none resize-none"></textarea>
                        </div>
                        <div class="flex flex-col sm:flex-row-reverse gap-2 border-t border-outline pt-4">
                            <button @click="showModal = false; $dispatch('show-toast', { message: 'Laporan berhasil ditolak.', type: 'error' })" class="w-full inline-flex justify-center rounded-lg px-4 py-2 bg-red-600 text-sm font-bold text-white hover:bg-red-700 sm:w-auto">Konfirmasi Penolakan</button>
                            <button @click="isRejecting = false" class="w-full inline-flex justify-center rounded-lg px-4 py-2 border border-outline text-sm font-bold text-on-surface hover:bg-surface-variant sm:w-auto">Kembali</button>
                        </div>
                    </div>

                    <!-- Merge Form -->
                    <div x-show="isMerging" style="display: none;">
                        <div class="bg-amber-50 p-3 rounded-lg mb-4 flex gap-2 text-sm text-amber-800 border border-amber-200">
                            <span class="material-symbols-outlined text-amber-600 text-[18px] shrink-0 mt-0.5">merge</span>
                            Pilih laporan yang akan digabungkan. Koin reward hanya diberikan ke pelapor pertama (laporan ini).
                        </div>
                        <div class="flex flex-col gap-2 mb-4">
                            <label class="flex items-center gap-3 p-3 border border-outline rounded-lg cursor-pointer hover:bg-surface-variant/50">
                                <input type="checkbox" class="w-4 h-4 text-amber-500 rounded focus:ring-amber-400">
                                <div>
                                    <p class="text-sm font-semibold">#LP-20260510-03 — Siti Rahayu</p>
                                    <p class="text-xs text-on-surface-variant">Jl. Mawar Gg. 3 · 10 Mei 2026</p>
                                </div>
                            </label>
                            <label class="flex items-center gap-3 p-3 border border-outline rounded-lg cursor-pointer hover:bg-surface-variant/50">
                                <input type="checkbox" class="w-4 h-4 text-amber-500 rounded focus:ring-amber-400">
                                <div>
                                    <p class="text-sm font-semibold">#LP-20260511-01 — Wahyu P.</p>
                                    <p class="text-xs text-on-surface-variant">Jl. Mawar RT 02 · 11 Mei 2026</p>
                                </div>
                            </label>
                        </div>
                        <div class="flex flex-col sm:flex-row-reverse gap-2 border-t border-outline pt-4">
                            <button @click="showModal = false; $dispatch('show-toast', { message: 'Laporan berhasil digabungkan.', type: 'warning' })" class="w-full inline-flex justify-center rounded-lg px-4 py-2 bg-amber-500 text-sm font-bold text-white hover:bg-amber-600 sm:w-auto">Gabungkan Laporan</button>
                            <button @click="isMerging = false" class="w-full inline-flex justify-center rounded-lg px-4 py-2 border border-outline text-sm font-bold text-on-surface hover:bg-surface-variant sm:w-auto">Kembali</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush
@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('alpine:init', () => {
        // Initialize map when Alpine is ready
        let adminMap = null;
        
        // Listen to modal open event (using Alpine $watch or just simple timeout for mockup)
        // Since we are showing modal using @click="showModal = true", we can just init map and invalidate it later
        setTimeout(() => {
            if(!document.getElementById('admin-map')) return;
            adminMap = L.map('admin-map', {zoomControl: false}).setView([-6.9730, 107.6300], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OSM'
            }).addTo(adminMap);
            
            // Add Native Marker
            L.marker([-6.9730, 107.6300]).addTo(adminMap);
        }, 500);

        // A trick to fix Leaflet map size inside Alpine x-show
        Alpine.effect(() => {
            // we'd need to know if showModal is true to call invalidateSize, 
            // since this is a mockup, clicking the button triggers it.
            if(adminMap) {
                setTimeout(() => adminMap.invalidateSize(), 100);
            }
        });
    });
</script>
@endpush
@endsection
