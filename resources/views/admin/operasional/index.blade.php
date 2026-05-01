@extends('layouts.admin')

@section('title', 'Penjemputan Harian')
@section('subtitle', 'Pantau dan atur penugasan petugas untuk pesanan hari ini.')

@section('content')
<div x-data="{ showAssignModal: false, showDetailModal: false, pesananStatus: 'Diproses' }">
    <!-- Filter/Action Bar -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-2 bg-white px-4 py-2 border border-outline rounded-lg shadow-sm">
            <span class="material-symbols-outlined text-on-surface-variant text-[20px]">calendar_today</span>
            <span class="text-sm font-medium text-on-surface">12 Mei 2026</span>
            <button class="ml-2 text-primary text-sm hover:underline">Ubah Tanggal</button>
        </div>
        <div class="flex gap-2">
            <button class="bg-surface-variant hover:bg-outline text-on-surface px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">print</span> Cetak Manifes
            </button>
        </div>
    </div>

    <!-- Komplek Group 1 -->
    <div class="bg-white rounded-xl border border-outline shadow-sm mb-6 overflow-hidden">
        <div class="bg-primary/5 p-4 border-b border-outline flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-primary text-[24px]">location_city</span>
                <div>
                    <h3 class="font-bold text-lg text-on-surface">Komplek Bunga Asri</h3>
                    <p class="text-sm text-on-surface-variant">Total: 15 Pesanan Hari Ini</p>
                </div>
            </div>
            <div class="flex items-center gap-3 bg-white px-3 py-1.5 rounded-lg border border-outline">
                <span class="text-sm text-on-surface-variant">Petugas:</span>
                <span class="text-sm font-semibold text-on-surface">Jajang, Asep</span>
                <button @click="showAssignModal = true" class="ml-2 text-primary hover:text-primary-dark text-sm underline">Ubah</button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-dim text-on-surface-variant text-sm border-b border-outline">
                        <th class="py-3 px-4 font-semibold">Resi</th>
                        <th class="py-3 px-4 font-semibold">Pemesan</th>
                        <th class="py-3 px-4 font-semibold">Blok/Nomor</th>
                        <th class="py-3 px-4 font-semibold">Kategori</th>
                        <th class="py-3 px-4 font-semibold">Status</th>
                        <th class="py-3 px-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    <tr class="border-b border-outline hover:bg-surface-variant/50 transition-colors">
                        <td class="py-3 px-4 text-on-surface font-medium">#TRX-100</td>
                        <td class="py-3 px-4 text-on-surface">Agus T.</td>
                        <td class="py-3 px-4 text-on-surface-variant">Blok B4 No. 15</td>
                        <td class="py-3 px-4"><span class="bg-surface-variant px-2 py-1 rounded text-xs">Sedang</span></td>
                        <td class="py-3 px-4"><span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-50 text-gray-700 ring-1 ring-inset ring-gray-600/20">Menunggu Pembayaran</span></td>
                        <td class="py-3 px-4 text-right">
                            <button @click="showDetailModal = true; pesananStatus = 'Menunggu Pembayaran'" class="text-primary hover:text-primary-dark p-1 rounded-md hover:bg-primary/10 transition-colors">
                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b border-outline hover:bg-surface-variant/50 transition-colors">
                        <td class="py-3 px-4 text-on-surface font-medium">#TRX-98</td>
                        <td class="py-3 px-4 text-on-surface">Budi W.</td>
                        <td class="py-3 px-4 text-on-surface-variant">Blok B4 No. 12</td>
                        <td class="py-3 px-4"><span class="bg-surface-variant px-2 py-1 rounded text-xs">Kecil</span></td>
                        <td class="py-3 px-4"><span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-green-50 text-green-700 ring-1 ring-inset ring-green-600/20">Selesai</span></td>
                        <td class="py-3 px-4 text-right">
                            <button @click="showDetailModal = true; pesananStatus = 'Selesai'" class="text-primary hover:text-primary-dark p-1 rounded-md hover:bg-primary/10 transition-colors">
                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-surface-variant/50 transition-colors">
                        <td class="py-3 px-4 text-on-surface font-medium">#TRX-99</td>
                        <td class="py-3 px-4 text-on-surface">Tono M.</td>
                        <td class="py-3 px-4 text-on-surface-variant">Blok C1 No. 5</td>
                        <td class="py-3 px-4"><span class="bg-surface-variant px-2 py-1 rounded text-xs font-semibold">Besar</span></td>
                        <td class="py-3 px-4"><span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-yellow-50 text-yellow-700 ring-1 ring-inset ring-yellow-600/20">Diproses</span></td>
                        <td class="py-3 px-4 text-right">
                            <button @click="showDetailModal = true; pesananStatus = 'Diproses'" class="text-primary hover:text-primary-dark p-1 rounded-md hover:bg-primary/10 transition-colors">
                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Komplek Group 2 -->
    <div class="bg-white rounded-xl border border-outline shadow-sm mb-6 overflow-hidden">
        <div class="bg-red-50 p-4 border-b border-outline flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-red-600 text-[24px]">location_city</span>
                <div>
                    <h3 class="font-bold text-lg text-red-900">Komplek Cemara Indah</h3>
                    <p class="text-sm text-red-700">Total: 8 Pesanan Hari Ini</p>
                </div>
            </div>
            <div class="flex items-center gap-3 bg-white px-3 py-1.5 rounded-lg border border-red-200">
                <span class="text-sm text-red-600 font-medium">Petugas Belum Ditugaskan!</span>
                <button @click="showAssignModal = true" class="ml-2 bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1 rounded text-sm font-bold transition-colors">Tugaskan Sekarang</button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-dim text-on-surface-variant text-sm border-b border-outline">
                        <th class="py-3 px-4 font-semibold">Resi</th>
                        <th class="py-3 px-4 font-semibold">Pemesan</th>
                        <th class="py-3 px-4 font-semibold">Blok/Nomor</th>
                        <th class="py-3 px-4 font-semibold">Kategori</th>
                        <th class="py-3 px-4 font-semibold">Status</th>
                        <th class="py-3 px-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    <tr class="hover:bg-surface-variant/50 transition-colors">
                        <td class="py-3 px-4 text-on-surface font-medium">#TRX-97</td>
                        <td class="py-3 px-4 text-on-surface">Rina S.</td>
                        <td class="py-3 px-4 text-on-surface-variant">Blok A2 No. 8</td>
                        <td class="py-3 px-4"><span class="bg-surface-variant px-2 py-1 rounded text-xs">Sedang</span></td>
                        <td class="py-3 px-4"><span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-surface-variant text-on-surface-variant ring-1 ring-inset ring-outline">Menunggu</span></td>
                        <td class="py-3 px-4 text-right">
                            <button @click="showDetailModal = true; pesananStatus = 'Menunggu'" class="text-primary hover:text-primary-dark p-1 rounded-md hover:bg-primary/10 transition-colors">
                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                            </button>
                        </td>
                    </tr>
                    <!-- Empty State -->
                    <tr x-show="false">
                        <td colspan="6" class="py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-on-surface-variant">
                                <span class="material-symbols-outlined text-[48px] opacity-40">inbox</span>
                                <p class="font-medium">Tidak ada pesanan di komplek ini hari ini.</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tugaskan Petugas -->
    <div x-show="showAssignModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div x-show="showAssignModal" x-transition.opacity class="fixed inset-0 bg-black/50" @click="showAssignModal = false"></div>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 sm:p-0">
            <div x-show="showAssignModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="relative bg-white rounded-xl text-left overflow-hidden shadow-xl sm:my-8 sm:max-w-md w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg leading-6 font-bold text-on-surface">Tugaskan Petugas</h3>
                        <button @click="showAssignModal = false"><span class="material-symbols-outlined text-on-surface-variant">close</span></button>
                    </div>
                    <p class="text-sm text-on-surface-variant mb-4">Pilih petugas (maks. 2) untuk komplek ini.</p>
                    <div class="flex flex-col gap-2">
                        <label class="flex items-center justify-between p-3 border border-outline rounded-lg cursor-pointer hover:bg-surface-variant/50">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" checked class="w-4 h-4 text-primary rounded">
                                <div><p class="text-sm font-semibold">Jajang Suryana</p><p class="text-xs text-on-surface-variant">Tersedia</p></div>
                            </div>
                            <span class="material-symbols-outlined text-primary text-[20px]">check_circle</span>
                        </label>
                        <label class="flex items-center justify-between p-3 border border-outline rounded-lg cursor-pointer hover:bg-surface-variant/50">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" class="w-4 h-4 text-primary rounded">
                                <div><p class="text-sm font-semibold">Udin Sedunia</p><p class="text-xs text-on-surface-variant">Tersedia</p></div>
                            </div>
                        </label>
                        <label class="flex items-center justify-between p-3 border border-outline rounded-lg opacity-50 cursor-not-allowed">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" disabled class="w-4 h-4 rounded">
                                <div><p class="text-sm font-semibold">Asep Sunandar</p><p class="text-xs text-red-600 font-medium">Berhalangan</p></div>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="bg-surface-dim px-4 py-3 sm:px-6 flex flex-col sm:flex-row-reverse gap-2 border-t border-outline">
                    <button @click="showAssignModal = false; $dispatch('show-toast', { message: '✅ Penugasan petugas berhasil disimpan!', type: 'success' })" class="w-full inline-flex justify-center rounded-lg px-4 py-2 bg-primary text-sm font-bold text-white hover:bg-primary-dark sm:w-auto">Simpan Penugasan</button>
                    <button @click="showAssignModal = false" class="w-full inline-flex justify-center rounded-lg px-4 py-2 border border-outline text-sm font-bold text-on-surface hover:bg-surface-variant sm:w-auto">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Pesanan -->
    <div x-show="showDetailModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div x-show="showDetailModal" x-transition.opacity class="fixed inset-0 bg-black/50" @click="showDetailModal = false"></div>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 sm:p-0">
            <div x-show="showDetailModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="relative bg-white rounded-xl text-left overflow-hidden shadow-xl sm:my-8 sm:max-w-lg w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg leading-6 font-bold text-on-surface">Detail Pesanan #TRX-98</h3>
                        <button @click="showDetailModal = false"><span class="material-symbols-outlined text-on-surface-variant">close</span></button>
                    </div>
                    <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                        <div><p class="text-on-surface-variant font-medium">Pemesan</p><p class="text-on-surface font-semibold">Budi W.</p></div>
                        <div>
                            <p class="text-on-surface-variant font-medium">Status Saat Ini</p>
                            <span x-text="pesananStatus"
                                :class="{
                                    'text-green-700': pesananStatus === 'Selesai',
                                    'text-yellow-700': pesananStatus === 'Diproses',
                                    'text-gray-600': pesananStatus === 'Menunggu Pembayaran',
                                    'text-on-surface-variant': pesananStatus === 'Menunggu'
                                }"
                                class="font-semibold text-sm"></span>
                        </div>
                        <div class="col-span-2"><p class="text-on-surface-variant font-medium">Alamat Spesifik</p><p class="text-on-surface font-semibold">Komplek Bunga Asri, Blok B4 No. 12</p></div>
                        <div class="col-span-2"><p class="text-on-surface-variant font-medium">Kategori Ukuran</p><p class="text-on-surface font-semibold">Kecil (Maks. 2 Kantong)</p></div>
                        <div class="col-span-2">
                            <p class="text-on-surface-variant font-medium">Catatan Warga</p>
                            <p class="text-on-surface bg-surface-dim p-3 rounded-lg border border-outline mt-1">"Tolong sampahnya ada di depan pagar ya pak, di keranjang hijau."</p>
                        </div>
                    </div>

                    <!-- Conditional Action Buttons based on status -->
                    <div class="flex flex-col sm:flex-row-reverse gap-2 border-t border-outline pt-4">
                        <!-- Jika Menunggu -->
                        <template x-if="pesananStatus === 'Menunggu'">
                            <button @click="pesananStatus = 'Diproses'; $dispatch('show-toast', { message: 'Status diperbarui: Sedang Diproses', type: 'success' })" class="w-full inline-flex justify-center rounded-lg px-4 py-2 bg-primary text-sm font-bold text-white hover:bg-primary-dark sm:w-auto">Tandai Sedang Diproses</button>
                        </template>
                        <!-- Jika Menunggu Pembayaran -->
                        <template x-if="pesananStatus === 'Menunggu Pembayaran'">
                            <p class="text-sm text-on-surface-variant italic sm:my-auto">Menunggu verifikasi pembayaran warga.</p>
                        </template>
                        <!-- Jika Diproses -->
                        <template x-if="pesananStatus === 'Diproses'">
                            <div class="flex flex-col sm:flex-row-reverse gap-2 w-full">
                                <button @click="pesananStatus = 'Selesai'; showDetailModal = false; $dispatch('show-toast', { message: '✅ Pesanan ditandai Selesai!', type: 'success' })" class="w-full inline-flex justify-center rounded-lg px-4 py-2 bg-primary text-sm font-bold text-white hover:bg-primary-dark sm:w-auto">Tandai Selesai</button>
                                <button @click="showDetailModal = false; $dispatch('show-toast', { message: 'Pesanan dibatalkan.', type: 'error' })" class="w-full inline-flex justify-center rounded-lg px-4 py-2 bg-red-50 text-sm font-bold text-red-700 border border-red-200 hover:bg-red-100 sm:w-auto">Batalkan Pesanan</button>
                            </div>
                        </template>
                        <!-- Jika Selesai/Batal -->
                        <template x-if="pesananStatus === 'Selesai' || pesananStatus === 'Batal'">
                            <p class="text-sm text-on-surface-variant italic">Pesanan ini sudah selesai, tidak ada aksi tersedia.</p>
                        </template>
                        <button @click="showDetailModal = false" class="w-full inline-flex justify-center rounded-lg px-4 py-2 border border-outline text-sm font-bold text-on-surface hover:bg-surface-variant sm:w-auto">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
