@extends('layouts.admin')

@section('title', 'Edukasi Lingkungan')
@section('subtitle', 'Kelola artikel dan konten edukasi untuk warga.')

@section('content')
<div x-data="{ showDeleteModal: false }" class="bg-white rounded-xl border border-outline-variant shadow-sm overflow-hidden mb-8">
    <div class="p-4 border-b border-outline-variant flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="relative w-full sm:w-auto">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[18px]">search</span>
            <input type="text" placeholder="Cari artikel..." class="pl-9 pr-4 py-2 border border-outline-variant rounded-lg text-sm w-full sm:w-64 focus:border-primary focus:ring-1 focus:ring-primary outline-none">
        </div>
        <a href="{{ route('admin.edukasi.create') }}" class="bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center justify-center gap-2 text-sm">
            <span class="material-symbols-outlined text-[20px]">add</span> Artikel Baru
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-dim text-on-surface-variant text-sm border-b border-outline-variant">
                    <th class="py-3 px-4 font-semibold">Judul Artikel</th>
                    <th class="py-3 px-4 font-semibold">Kategori</th>
                    <th class="py-3 px-4 font-semibold">Tanggal Terbit</th>
                    <th class="py-3 px-4 font-semibold">Status</th>
                    <th class="py-3 px-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                <tr class="border-b border-outline-variant hover:bg-surface-variant/50 transition-colors">
                    <td class="py-4 px-4 text-on-surface font-medium">Cara Tepat Memilah Sampah Plastik</td>
                    <td class="py-4 px-4 text-on-surface-variant">Panduan</td>
                    <td class="py-4 px-4 text-on-surface-variant">10 Mei 2026</td>
                    <td class="py-4 px-4">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-green-50 text-green-700 ring-1 ring-inset ring-green-600/20">Diterbitkan</span>
                    </td>
                    <td class="py-4 px-4 text-right">
                        <div class="flex justify-end gap-1">
                            <a href="{{ route('admin.edukasi.create') }}" class="text-blue-600 hover:bg-blue-50 p-1.5 rounded-md transition-colors inline-block" title="Edit Artikel"><span class="material-symbols-outlined text-[20px]">edit</span></a>
                            <button @click="showDeleteModal = true" class="text-red-600 hover:bg-red-50 p-1.5 rounded-md transition-colors" title="Hapus Artikel"><span class="material-symbols-outlined text-[20px]">delete</span></button>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-surface-variant/50 transition-colors">
                    <td class="py-4 px-4 text-on-surface font-medium">Bahaya Baterai Bekas Bagi Tanah</td>
                    <td class="py-4 px-4 text-on-surface-variant">Info / Berita</td>
                    <td class="py-4 px-4 text-on-surface-variant">-</td>
                    <td class="py-4 px-4">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-surface-variant text-on-surface-variant ring-1 ring-inset ring-outline-variant">Draf</span>
                    </td>
                    <td class="py-4 px-4 text-right">
                        <div class="flex justify-end gap-1">
                            <a href="{{ route('admin.edukasi.create') }}" class="text-blue-600 hover:bg-blue-50 p-1.5 rounded-md transition-colors inline-block" title="Edit Artikel"><span class="material-symbols-outlined text-[20px]">edit</span></a>
                            <button @click="showDeleteModal = true" class="text-red-600 hover:bg-red-50 p-1.5 rounded-md transition-colors" title="Hapus Artikel"><span class="material-symbols-outlined text-[20px]">delete</span></button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Modal Hapus Artikel -->
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
                            <h3 class="text-lg leading-6 font-bold text-on-surface">Hapus Artikel Edukasi</h3>
                            <div class="mt-2">
                                <p class="text-sm text-on-surface-variant">Apakah Anda yakin ingin menghapus artikel ini? Artikel yang terhapus tidak akan lagi bisa diakses oleh warga di aplikasi. Tindakan ini tidak dapat dibatalkan.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-surface-dim px-4 py-3 sm:px-6 flex flex-col sm:flex-row-reverse gap-2 border-t border-outline-variant">
                    <button type="button" @click="showDeleteModal = false" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-bold text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Ya, Hapus Artikel</button>
                    <button type="button" @click="showDeleteModal = false" class="mt-3 w-full inline-flex justify-center rounded-lg border border-outline-variant shadow-sm px-4 py-2 bg-white text-base font-bold text-on-surface hover:bg-surface-variant focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
