@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')
@section('subtitle', 'Pantau akun warga dan kelola akun petugas lapangan.')

@section('content')
<div x-data="{ activeTab: 'warga', showAddModal: false, showEditModal: false, showDeleteModal: false, showProfilModal: false }">
    <div class="bg-white rounded-xl border border-outline-variant shadow-sm overflow-hidden mb-8">
        
        <!-- Tabs Header -->
        <div class="flex overflow-x-auto border-b border-outline-variant bg-surface-dim px-4 justify-between items-center">
            <div class="flex">
                <button @click="activeTab = 'warga'" :class="activeTab === 'warga' ? 'border-primary text-primary font-bold' : 'border-transparent text-on-surface-variant hover:text-on-surface'" class="px-6 py-4 border-b-2 whitespace-nowrap transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">groups</span> Data Warga
                </button>
                <button @click="activeTab = 'petugas'" :class="activeTab === 'petugas' ? 'border-primary text-primary font-bold' : 'border-transparent text-on-surface-variant hover:text-on-surface'" class="px-6 py-4 border-b-2 whitespace-nowrap transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">badge</span> Akun Petugas
                </button>
            </div>
            <div x-show="activeTab === 'petugas'" style="display: none;">
                <button @click="showAddModal = true" class="bg-primary hover:bg-primary-dark text-white px-4 py-1.5 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">person_add</span> Tambah Petugas
                </button>
            </div>
        </div>

        <!-- Tab 1: Warga -->
        <div x-show="activeTab === 'warga'" class="p-0">
            <div class="p-4 border-b border-outline-variant flex justify-end">
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[18px]">search</span>
                    <input type="text" placeholder="Cari nama atau ID Warga..." class="pl-9 pr-4 py-2 border border-outline-variant rounded-lg text-sm w-full sm:w-64 focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-dim text-on-surface-variant text-sm border-b border-outline-variant">
                            <th class="py-3 px-6 font-semibold">ID Warga</th>
                            <th class="py-3 px-6 font-semibold">Nama Warga</th>
                            <th class="py-3 px-6 font-semibold">Email / Kontak</th>
                            <th class="py-3 px-6 font-semibold">Saldo Koin</th>
                            <th class="py-3 px-6 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        <tr class="border-b border-outline-variant hover:bg-surface-variant/50 transition-colors">
                            <td class="py-3 px-6 text-on-surface font-medium">#W-001</td>
                            <td class="py-3 px-6 text-on-surface font-semibold">Budi Santoso</td>
                            <td class="py-3 px-6 text-on-surface-variant">budi@email.com<br><span class="text-xs">08123456789</span></td>
                            <td class="py-3 px-6"><span class="inline-flex items-center gap-1 font-bold text-yellow-600 bg-yellow-50 px-2 py-1 rounded-md border border-yellow-200"><span class="material-symbols-outlined text-[16px]">monetization_on</span> 450</span></td>
                            <td class="py-3 px-6 text-right">
                                <button @click="showProfilModal = true" class="text-primary hover:bg-primary/10 p-1.5 rounded-md transition-colors" title="Lihat Profil"><span class="material-symbols-outlined text-[20px]">visibility</span></button>
                            </td>
                        </tr>
                        <tr class="hover:bg-surface-variant/50 transition-colors">
                            <td class="py-3 px-6 text-on-surface font-medium">#W-002</td>
                            <td class="py-3 px-6 text-on-surface font-semibold">Siti Aminah</td>
                            <td class="py-3 px-6 text-on-surface-variant">siti@email.com<br><span class="text-xs">08155555555</span></td>
                            <td class="py-3 px-6"><span class="inline-flex items-center gap-1 font-bold text-yellow-600 bg-yellow-50 px-2 py-1 rounded-md border border-yellow-200"><span class="material-symbols-outlined text-[16px]">monetization_on</span> 120</span></td>
                            <td class="py-3 px-6 text-right">
                                <button @click="showProfilModal = true" class="text-primary hover:bg-primary/10 p-1.5 rounded-md transition-colors" title="Lihat Profil"><span class="material-symbols-outlined text-[20px]">visibility</span></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Pagination Placeholder -->
            <div class="p-4 border-t border-outline-variant text-center text-sm text-on-surface-variant">
                Menampilkan 1-2 dari 120 Warga
            </div>
        </div>

        <!-- Tab 2: Petugas -->
        <div x-show="activeTab === 'petugas'" class="p-0" style="display: none;">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-dim text-on-surface-variant text-sm border-b border-outline-variant">
                            <th class="py-3 px-6 font-semibold">ID</th>
                            <th class="py-3 px-6 font-semibold">Nama Petugas</th>
                            <th class="py-3 px-6 font-semibold">Email Login</th>
                            <th class="py-3 px-6 font-semibold">Password Default</th>
                            <th class="py-3 px-6 font-semibold">Status</th>
                            <th class="py-3 px-6 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        <tr class="border-b border-outline-variant hover:bg-surface-variant/50 transition-colors">
                            <td class="py-3 px-6 text-on-surface font-medium">#P-01</td>
                            <td class="py-3 px-6 text-on-surface font-semibold">Jajang Suryana</td>
                            <td class="py-3 px-6 text-on-surface-variant">jajang@ecotrash</td>
                            <td class="py-3 px-6 text-on-surface font-mono text-xs">eco123</td>
                            <td class="py-3 px-6"><span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-green-50 text-green-700 ring-1 ring-inset ring-green-600/20">Aktif</span></td>
                            <td class="py-3 px-6 text-right">
                                <div class="flex justify-end gap-1">
                                    <button @click="showEditModal = true" class="text-blue-600 hover:bg-blue-50 p-1.5 rounded-md transition-colors" title="Edit Akun"><span class="material-symbols-outlined text-[20px]">edit</span></button>
                                    <button @click="showDeleteModal = true" class="text-red-600 hover:bg-red-50 p-1.5 rounded-md transition-colors" title="Hapus Akun"><span class="material-symbols-outlined text-[20px]">delete</span></button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-surface-variant/50 transition-colors">
                            <td class="py-3 px-6 text-on-surface font-medium">#P-02</td>
                            <td class="py-3 px-6 text-on-surface font-semibold">Asep Sunandar</td>
                            <td class="py-3 px-6 text-on-surface-variant">asep@ecotrash</td>
                            <td class="py-3 px-6 text-on-surface font-mono text-xs">asep123</td>
                            <td class="py-3 px-6"><span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-red-50 text-red-700 ring-1 ring-inset ring-red-600/10">Berhalangan</span></td>
                            <td class="py-3 px-6 text-right">
                                <div class="flex justify-end gap-1">
                                    <button @click="showEditModal = true" class="text-blue-600 hover:bg-blue-50 p-1.5 rounded-md transition-colors" title="Edit Akun"><span class="material-symbols-outlined text-[20px]">edit</span></button>
                                    <button @click="showDeleteModal = true" class="text-red-600 hover:bg-red-50 p-1.5 rounded-md transition-colors" title="Hapus Akun"><span class="material-symbols-outlined text-[20px]">delete</span></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Profil Warga -->
    <div x-show="showProfilModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div x-show="showProfilModal" x-transition.opacity class="fixed inset-0 bg-black/50 transition-opacity" @click="showProfilModal = false"></div>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showProfilModal" x-transition.scale class="relative bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-md w-full">
                <div class="bg-primary p-6 text-white text-center">
                    <div class="w-20 h-20 bg-white rounded-full mx-auto flex items-center justify-center mb-3">
                        <span class="material-symbols-outlined text-primary text-[40px]">person</span>
                    </div>
                    <h3 class="text-xl font-bold">Budi Santoso</h3>
                    <p class="text-primary-100 text-sm">#W-001</p>
                </div>
                <div class="bg-white px-6 py-4">
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-on-surface-variant">Email</p>
                            <p class="text-on-surface font-medium">budi@email.com</p>
                        </div>
                        <div>
                            <p class="text-sm text-on-surface-variant">Kontak HP</p>
                            <p class="text-on-surface font-medium">08123456789</p>
                        </div>
                        <div class="col-span-2 flex items-center justify-between p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                            <span class="font-bold text-yellow-800">Total Koin Reward</span>
                            <span class="font-bold text-yellow-600 text-lg">450 Koin</span>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-on-surface-variant mb-1">Ringkasan Riwayat</p>
                            <div class="flex gap-2">
                                <span class="bg-surface-dim px-3 py-1 rounded text-xs text-on-surface">15 Pesanan Selesai</span>
                                <span class="bg-surface-dim px-3 py-1 rounded text-xs text-on-surface">3 Laporan Liar</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-surface-dim px-4 py-3 sm:px-6 flex flex-row-reverse border-t border-outline-variant">
                    <button type="button" @click="showProfilModal = false" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-bold text-white hover:bg-primary-dark focus:outline-none sm:w-auto sm:text-sm">Tutup Profil</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Petugas -->
    <div x-show="showAddModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div x-show="showAddModal" x-transition.opacity class="fixed inset-0 bg-black/50 transition-opacity" @click="showAddModal = false"></div>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showAddModal" x-transition.scale class="relative bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-md w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg leading-6 font-bold text-on-surface">Tambah Akun Petugas</h3>
                        <button @click="showAddModal = false" class="text-on-surface-variant hover:text-on-surface"><span class="material-symbols-outlined">close</span></button>
                    </div>
                    <div class="mb-4">
                        <form class="flex flex-col gap-4">
                            <div>
                                <label class="block font-medium text-sm text-on-surface mb-1">Nama Lengkap</label>
                                <input type="text" placeholder="Masukkan nama petugas" class="w-full px-4 py-2 border border-outline-variant rounded-lg text-sm text-on-surface bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-on-surface mb-1">Email Login</label>
                                <input type="email" placeholder="email@petugas.ecotrash" class="w-full px-4 py-2 border border-outline-variant rounded-lg text-sm text-on-surface bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-on-surface mb-1">Password Default</label>
                                <input type="text" value="ecotrash123" class="w-full px-4 py-2 border border-outline-variant rounded-lg text-sm text-on-surface bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                                <p class="text-xs text-on-surface-variant mt-1">Petugas dapat mengubah password setelah login.</p>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="bg-surface-dim px-4 py-3 sm:px-6 flex flex-col sm:flex-row-reverse gap-2 border-t border-outline-variant">
                    <button type="button" @click="showAddModal = false" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-bold text-white hover:bg-primary-dark focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Simpan & Buat Akun</button>
                    <button type="button" @click="showAddModal = false" class="mt-3 w-full inline-flex justify-center rounded-lg border border-outline-variant shadow-sm px-4 py-2 bg-white text-base font-bold text-on-surface hover:bg-surface-variant focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Petugas -->
    <div x-show="showEditModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div x-show="showEditModal" x-transition.opacity class="fixed inset-0 bg-black/50 transition-opacity" @click="showEditModal = false"></div>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showEditModal" x-transition.scale class="relative bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-md w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg leading-6 font-bold text-on-surface">Edit Petugas</h3>
                        <button @click="showEditModal = false" class="text-on-surface-variant hover:text-on-surface"><span class="material-symbols-outlined">close</span></button>
                    </div>
                    <div class="mb-4">
                        <form class="flex flex-col gap-4">
                            <div>
                                <label class="block font-medium text-sm text-on-surface mb-1">Nama Lengkap</label>
                                <input type="text" value="Jajang Suryana" class="w-full px-4 py-2 border border-outline-variant rounded-lg text-sm text-on-surface bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-on-surface mb-1">Email Login</label>
                                <input type="email" value="jajang@ecotrash" class="w-full px-4 py-2 border border-outline-variant rounded-lg text-sm text-on-surface bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-on-surface mb-1">Ubah Password</label>
                                <input type="text" placeholder="Kosongkan jika tidak ingin mengubah" class="w-full px-4 py-2 border border-outline-variant rounded-lg text-sm text-on-surface bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-on-surface mb-2">Area Tugas Aktif (Multi-Pilih)</label>
                                <div class="space-y-2 border border-outline-variant p-3 rounded-lg bg-surface-dim max-h-40 overflow-y-auto">
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="checkbox" checked class="w-4 h-4 text-primary rounded focus:ring-primary">
                                        <span class="text-sm">Perumahan Asri Indah</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="checkbox" checked class="w-4 h-4 text-primary rounded focus:ring-primary">
                                        <span class="text-sm">Komp. Permata Hijau</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="checkbox" class="w-4 h-4 text-primary rounded focus:ring-primary">
                                        <span class="text-sm">Griya Raya Selatan</span>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Peringatan Alasan Berhalangan -->
                            <div class="bg-red-50 border border-red-200 rounded-lg p-3 mt-2">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-red-100 text-red-700 uppercase">Status: Berhalangan</span>
                                </div>
                                <p class="text-xs font-semibold text-red-800 mb-1">Alasan Berhalangan:</p>
                                <p class="text-sm text-red-700 italic">"Saya mengalami kecelakaan ringan saat perjalanan, motor harus dibawa ke bengkel. Mohon izin off hari ini."</p>
                                <div class="mt-2 pt-2 border-t border-red-200 text-right">
                                    <button type="button" class="text-xs font-bold text-primary hover:underline">Reset ke Status Aktif</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="bg-surface-dim px-4 py-3 sm:px-6 flex flex-col sm:flex-row-reverse gap-2 border-t border-outline-variant">
                    <button type="button" @click="showEditModal = false" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-bold text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Simpan Perubahan</button>
                    <button type="button" @click="showEditModal = false" class="mt-3 w-full inline-flex justify-center rounded-lg border border-outline-variant shadow-sm px-4 py-2 bg-white text-base font-bold text-on-surface hover:bg-surface-variant focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Hapus Petugas -->
    <div x-show="showDeleteModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div x-show="showDeleteModal" x-transition.opacity class="fixed inset-0 bg-black/50 transition-opacity" @click="showDeleteModal = false"></div>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showDeleteModal" x-transition.scale class="relative bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-md w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <span class="material-symbols-outlined text-red-600">warning</span>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-bold text-on-surface">Hapus Akun Petugas</h3>
                            <div class="mt-2">
                                <p class="text-sm text-on-surface-variant">Apakah Anda yakin ingin menghapus akun petugas ini? Akun ini tidak akan bisa login lagi ke aplikasi. Tindakan ini tidak dapat dibatalkan.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-surface-dim px-4 py-3 sm:px-6 flex flex-col sm:flex-row-reverse gap-2 border-t border-outline-variant">
                    <button type="button" @click="showDeleteModal = false" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-bold text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Ya, Hapus Akun</button>
                    <button type="button" @click="showDeleteModal = false" class="mt-3 w-full inline-flex justify-center rounded-lg border border-outline-variant shadow-sm px-4 py-2 bg-white text-base font-bold text-on-surface hover:bg-surface-variant focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
