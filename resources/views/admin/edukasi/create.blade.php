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
    /* Fix Quill tooltip positioning and z-index */
    .ql-snow .ql-tooltip {
        z-index: 100 !important;
    }
    /* Pindahkan list counter reset ke root editor agar angka berlanjut meskipun ada paragraf di tengah */
    .ql-editor {
        counter-reset: list-0-decimal list-0-alpha list-0-uppercase list-0-roman list-1 list-2 list-3 list-4 list-5 list-6 list-7 list-8 list-9 !important;
    }
    .ql-editor ol {
        counter-reset: none !important;
    }
    /* Styling Dropdown Label & Item di Toolbar */
    .ql-snow .ql-picker.ql-list-style {
        width: 110px;
    }
    .ql-snow .ql-picker.ql-list-style .ql-picker-label::before,
    .ql-snow .ql-picker.ql-list-style .ql-picker-item::before {
        content: '1, 2, 3';
    }
    .ql-snow .ql-picker.ql-list-style .ql-picker-label[data-value="alpha"]::before,
    .ql-snow .ql-picker.ql-list-style .ql-picker-item[data-value="alpha"]::before {
        content: 'a, b, c';
    }
    .ql-snow .ql-picker.ql-list-style .ql-picker-label[data-value="uppercase"]::before,
    .ql-snow .ql-picker.ql-list-style .ql-picker-item[data-value="uppercase"]::before {
        content: 'A, B, C';
    }
    .ql-snow .ql-picker.ql-list-style .ql-picker-label[data-value="roman"]::before,
    .ql-snow .ql-picker.ql-list-style .ql-picker-item[data-value="roman"]::before {
        content: 'i, ii, iii';
    }

    /* Rendering Penomoran Huruf & Romawi di Editor (Tingkat Pertama Saja) */
    .ql-editor ol li:not([class*="ql-indent-"]).ql-list-style-alpha {
        counter-increment: list-0-alpha !important;
    }
    .ql-editor ol li:not([class*="ql-indent-"]).ql-list-style-alpha::before {
        content: counter(list-0-alpha, lower-alpha) ". " !important;
    }

    .ql-editor ol li:not([class*="ql-indent-"]).ql-list-style-uppercase {
        counter-increment: list-0-uppercase !important;
    }
    .ql-editor ol li:not([class*="ql-indent-"]).ql-list-style-uppercase::before {
        content: counter(list-0-uppercase, upper-alpha) ". " !important;
    }

    .ql-editor ol li:not([class*="ql-indent-"]).ql-list-style-roman {
        counter-increment: list-0-roman !important;
    }
    .ql-editor ol li:not([class*="ql-indent-"]).ql-list-style-roman::before {
        content: counter(list-0-roman, lower-roman) ". " !important;
    }

    .ql-editor ol li:not([class*="ql-indent-"]).ql-list-style-decimal {
        counter-increment: list-0-decimal !important;
        counter-set: list-0-alpha 0 list-0-uppercase 0 list-0-roman 0 !important;
    }
    .ql-editor ol li:not([class*="ql-indent-"]).ql-list-style-decimal::before {
        content: counter(list-0-decimal, decimal) ". " !important;
    }

    /* Default decimal list item (no custom class, no indent class) di Editor */
    .ql-editor ol li:not([class*="ql-indent-"]):not([class*="ql-list-style-"]) {
        counter-increment: list-0-decimal !important;
        counter-set: list-0-alpha 0 list-0-uppercase 0 list-0-roman 0 !important;
    }
    .ql-editor ol li:not([class*="ql-indent-"]):not([class*="ql-list-style-"])::before {
        content: counter(list-0-decimal, decimal) ". " !important;
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

<div class="bg-white rounded-xl border border-outline shadow-sm overflow-hidden mb-8">
    <div class="p-6">
        <form id="artikel-form" action="{{ route('admin.edukasi.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6">
            @csrf
            <!-- Header Actions -->
            <div class="flex items-center justify-between pb-4 border-b border-outline">
                <a href="{{ route('admin.edukasi.index') }}" class="text-on-surface-variant hover:text-on-surface flex items-center gap-1 text-sm font-medium transition-colors">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span> Kembali
                </a>
                <div class="flex gap-2">
                    <button type="button" @click="$dispatch('show-toast', { message: 'Fitur Simpan Draf tidak didukung saat ini.', type: 'warning' })" class="px-4 py-2 bg-surface-variant text-on-surface hover:bg-outline rounded-lg text-sm font-bold transition-colors">Simpan Draf</button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white hover:bg-primary-dark rounded-lg text-sm font-bold transition-colors flex items-center gap-2 shadow-md">
                        <span class="material-symbols-outlined text-[18px]">publish</span> Terbitkan
                    </button>
                </div>
            </div>

            <!-- Title & Category -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="col-span-2">
                    <label class="block font-medium text-sm text-on-surface mb-1">Judul Artikel <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Masukkan judul yang menarik..." class="w-full px-4 py-2.5 border border-outline-variant rounded-lg text-on-surface bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none font-semibold text-lg @error('judul') border-red-500 @enderror">
                    @error('judul')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block font-medium text-sm text-on-surface mb-1">Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori" class="w-full px-4 py-3 border border-outline-variant rounded-lg text-sm text-on-surface bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none @error('kategori') border-red-500 @enderror">
                        <option value="daur_ulang" {{ old('kategori') === 'daur_ulang' ? 'selected' : '' }}>Daur Ulang</option>
                        <option value="kompos" {{ old('kategori') === 'kompos' ? 'selected' : '' }}>Kompos</option>
                        <option value="b3" {{ old('kategori') === 'b3' ? 'selected' : '' }}>B3</option>
                        <option value="tips" {{ old('kategori') === 'tips' ? 'selected' : '' }}>Tips Lingkungan</option>
                    </select>
                    @error('kategori')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Thumbnail Upload -->
            <div x-data="{ previewUrl: null }">
                <label class="block font-medium text-sm text-on-surface mb-1">Gambar Thumbnail <span class="text-red-500">*</span></label>
                <input type="file" name="gambar_thumbnail" id="gambar_thumbnail" accept="image/*" class="hidden" @change="const file = $event.target.files[0]; if (file) { previewUrl = URL.createObjectURL(file); }">
                <div onclick="document.getElementById('gambar_thumbnail').click()" class="w-full min-h-[10rem] border-2 border-dashed border-outline-variant rounded-xl flex flex-col items-center justify-center text-on-surface-variant hover:bg-surface-dim hover:border-primary transition-colors cursor-pointer group p-4">
                    <template x-if="!previewUrl">
                        <div class="flex flex-col items-center">
                            <span class="material-symbols-outlined text-[40px] mb-2 group-hover:text-primary transition-colors">cloud_upload</span>
                            <p class="text-sm font-medium">Klik untuk memilih gambar</p>
                            <p class="text-xs mt-1">PNG, JPG up to 2MB. Resolusi ideal 1200x630px.</p>
                        </div>
                    </template>
                    <template x-if="previewUrl">
                        <div class="relative w-full h-full flex justify-center">
                            <img :src="previewUrl" class="max-h-40 rounded-lg object-cover">
                            <button type="button" @click.stop="previewUrl = null; document.getElementById('gambar_thumbnail').value = ''" class="absolute top-2 right-2 bg-red-600 text-white p-1 rounded-full hover:bg-red-700 transition-colors shadow-md">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </div>
                    </template>
                </div>
                @error('gambar_thumbnail')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- WYSIWYG Editor -->
            <div>
                <label class="block font-medium text-sm text-on-surface mb-1">Konten Artikel <span class="text-red-500">*</span></label>
                <input type="hidden" name="konten_html" id="konten_html" value="{{ old('konten_html') }}">
                <!-- Editor Container -->
                <div id="editor-container"></div>
                @error('konten_html')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
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
        // Register custom list style class attributor
        var Parchment = Quill.import('parchment');
        var ListStyle = new Parchment.Attributor.Class('list-style', 'ql-list-style', {
            scope: Parchment.Scope.BLOCK
        });
        Quill.register(ListStyle, true);

        var quill = new Quill('#editor-container', {
            theme: 'snow',
            placeholder: 'Mulai menulis konten edukasi di sini...',
            modules: {
                toolbar: [
                    [{ 'header': [2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'list-style': ['decimal', 'alpha', 'uppercase', 'roman'] }],
                    [{ 'indent': '-1' }, { 'indent': '+1' }],
                    [{ 'align': [] }],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            }
        });

        // Set old content if available
        var oldContent = document.getElementById('konten_html').value;
        if (oldContent) {
            quill.root.innerHTML = oldContent;
        }

        // Update hidden input on submit
        var form = document.getElementById('artikel-form');
        form.addEventListener('submit', function() {
            var content = document.getElementById('konten_html');
            content.value = quill.root.innerHTML;
        });
    });
</script>
@endpush
