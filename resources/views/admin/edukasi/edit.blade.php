@extends('layouts.admin')

@section('title', 'Edit Artikel Edukasi')
@section('subtitle', 'Ubah rincian artikel dan terbitkan kembali untuk warga.')

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
        <li class="text-on-surface font-semibold">Edit Artikel</li>
    </ol>
</nav>

<div class="bg-white rounded-xl border border-outline shadow-sm overflow-hidden mb-8">
    <div class="p-6">
        <form id="artikel-form" action="{{ route('admin.edukasi.update', $artikel->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6">
            @csrf
            @method('PUT')
            <!-- Header Actions -->
            <div class="flex items-center justify-between pb-4 border-b border-outline">
                <a href="{{ route('admin.edukasi.index') }}" class="text-on-surface-variant hover:text-on-surface flex items-center gap-1 text-sm font-medium transition-colors">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span> Kembali
                </a>
                <div class="flex gap-2">
                    <button type="button" @click="$dispatch('show-toast', { message: 'Fitur Simpan Draf tidak didukung saat ini.', type: 'warning' })" class="px-4 py-2 bg-surface-variant text-on-surface hover:bg-outline rounded-lg text-sm font-bold transition-colors">Simpan Draf</button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white hover:bg-primary-dark rounded-lg text-sm font-bold transition-colors flex items-center gap-2 shadow-md">
                        <span class="material-symbols-outlined text-[18px]">save</span> Simpan Perubahan
                    </button>
                </div>
            </div>

            <!-- Title & Category -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="col-span-2">
                    <label class="block font-medium text-sm text-on-surface mb-1">Judul Artikel <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul', $artikel->judul) }}" placeholder="Masukkan judul yang menarik..." class="w-full px-4 py-2.5 border border-outline-variant rounded-lg text-on-surface bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none font-semibold text-lg @error('judul') border-red-500 @enderror">
                    @error('judul')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block font-medium text-sm text-on-surface mb-1">Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori" class="w-full px-4 py-3 border border-outline-variant rounded-lg text-sm text-on-surface bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none @error('kategori') border-red-500 @enderror">
                        <option value="daur_ulang" {{ old('kategori', $artikel->kategori) === 'daur_ulang' ? 'selected' : '' }}>Daur Ulang</option>
                        <option value="kompos" {{ old('kategori', $artikel->kategori) === 'kompos' ? 'selected' : '' }}>Kompos</option>
                        <option value="b3" {{ old('kategori', $artikel->kategori) === 'b3' ? 'selected' : '' }}>B3</option>
                        <option value="tips" {{ old('kategori', $artikel->kategori) === 'tips' ? 'selected' : '' }}>Tips Lingkungan</option>
                    </select>
                    @error('kategori')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Thumbnail Upload -->
            <div x-data="{ previewUrl: '{{ $artikel->gambar_thumbnail ? asset($artikel->gambar_thumbnail) : null }}' }">
                <label class="block font-medium text-sm text-on-surface mb-1">Gambar Thumbnail <span class="text-red-500">*</span></label>
                <input type="file" name="gambar_thumbnail" id="gambar_thumbnail" accept="image/*" class="hidden" @change="const file = $event.target.files[0]; if (file) { previewUrl = URL.createObjectURL(file); }">
                <div onclick="document.getElementById('gambar_thumbnail').click()" class="w-full min-h-[10rem] border-2 border-dashed border-outline-variant rounded-xl flex flex-col items-center justify-center text-on-surface-variant hover:bg-surface-dim hover:border-primary transition-colors cursor-pointer group p-4">
                    <template x-if="!previewUrl">
                        <div class="flex flex-col items-center">
                            <span class="material-symbols-outlined text-[40px] mb-2 group-hover:text-primary transition-colors">cloud_upload</span>
                            <p class="text-sm font-medium">Klik untuk memilih gambar baru</p>
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
                <input type="hidden" name="konten_html" id="konten_html" value="{{ old('konten_html', $artikel->konten_html) }}">
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

        // Set content from database
        var contentVal = document.getElementById('konten_html').value;
        if (contentVal) {
            quill.root.innerHTML = contentVal;
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
