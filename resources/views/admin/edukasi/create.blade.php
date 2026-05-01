@extends('layouts.admin')

@section('title', 'Tulis Artikel Edukasi')
@section('subtitle', 'Buat konten edukasi baru untuk dibagikan kepada warga.')

@push('styles')
<!-- Quill.js Theme included via CDN -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .ql-editor {
        min-height: 300px;
        font-family: 'Inter', sans-serif;
        font-size: 15px;
    }
    .ql-toolbar.ql-snow {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
        border-color: var(--color-outline-variant);
        background-color: var(--color-surface-dim);
    }
    .ql-container.ql-snow {
        border-bottom-left-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
        border-color: var(--color-outline-variant);
    }
    .ql-editor:focus {
        border-radius: 0.5rem;
        box-shadow: 0 0 0 1px var(--color-primary);
    }
</style>
@endpush

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-5">
    <ol class="flex items-center gap-2 text-sm text-on-surface-variant">
        <li><a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Dasbor</a></li>
        <li><span class="material-symbols-outlined text-[16px] opacity-50">chevron_right</span></li>
        <li><a href="{{ route('admin.edukasi.index') }}" class="hover:text-primary transition-colors">Edukasi</a></li>
        <li><span class="material-symbols-outlined text-[16px] opacity-50">chevron_right</span></li>
        <li class="text-on-surface font-semibold">Artikel Baru</li>
    </ol>
</nav>

<div x-data class="bg-white rounded-xl border border-outline shadow-sm overflow-hidden mb-8">
    <div class="p-6">
        <form class="flex flex-col gap-6">
            <!-- Header Actions -->
            <div class="flex items-center justify-between pb-4 border-b border-outline">
                <a href="{{ route('admin.edukasi.index') }}" class="text-on-surface-variant hover:text-on-surface flex items-center gap-1 text-sm font-medium transition-colors">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span> Kembali
                </a>
                <div class="flex gap-2">
                    <button type="button" @click="$dispatch('show-toast', { message: 'Artikel berhasil disimpan sebagai Draf.', type: 'warning' })" class="px-4 py-2 bg-surface-variant text-on-surface hover:bg-outline rounded-lg text-sm font-bold transition-colors">Simpan Draf</button>
                    <button type="button" @click="$dispatch('show-toast', { message: '✅ Artikel berhasil diterbitkan!', type: 'success' })" class="px-4 py-2 bg-primary text-white hover:bg-primary-dark rounded-lg text-sm font-bold transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">publish</span> Terbitkan
                    </button>
                </div>
            </div>

            <!-- Title & Category -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="col-span-2">
                    <label class="block font-medium text-sm text-on-surface mb-1">Judul Artikel <span class="text-red-500">*</span></label>
                    <input type="text" placeholder="Masukkan judul yang menarik..." class="w-full px-4 py-2.5 border border-outline-variant rounded-lg text-on-surface bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none font-semibold text-lg">
                </div>
                <div>
                    <label class="block font-medium text-sm text-on-surface mb-1">Kategori <span class="text-red-500">*</span></label>
                    <select class="w-full px-4 py-3 border border-outline-variant rounded-lg text-sm text-on-surface bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                        <option value="panduan">Panduan</option>
                        <option value="info">Info / Berita</option>
                        <option value="tips">Tips Lingkungan</option>
                    </select>
                </div>
            </div>

            <!-- Thumbnail Upload -->
            <div>
                <label class="block font-medium text-sm text-on-surface mb-1">Gambar Thumbnail</label>
                <div class="w-full h-40 border-2 border-dashed border-outline-variant rounded-xl flex flex-col items-center justify-center text-on-surface-variant hover:bg-surface-dim hover:border-primary transition-colors cursor-pointer group">
                    <span class="material-symbols-outlined text-[40px] mb-2 group-hover:text-primary transition-colors">cloud_upload</span>
                    <p class="text-sm font-medium">Klik atau seret gambar ke sini</p>
                    <p class="text-xs mt-1">PNG, JPG up to 2MB. Resolusi ideal 1200x630px.</p>
                </div>
            </div>

            <!-- WYSIWYG Editor -->
            <div>
                <label class="block font-medium text-sm text-on-surface mb-1">Konten Artikel <span class="text-red-500">*</span></label>
                <!-- Editor Container -->
                <div id="editor-container"></div>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<!-- Quill.js JS via CDN -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var quill = new Quill('#editor-container', {
            theme: 'snow',
            placeholder: 'Mulai menulis konten edukasi di sini...',
            modules: {
                toolbar: [
                    [{ 'header': [2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            }
        });
    });
</script>
@endpush
