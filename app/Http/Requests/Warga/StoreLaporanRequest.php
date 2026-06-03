<?php

namespace App\Http\Requests\Warga;

use Illuminate\Foundation\Http\FormRequest;

class StoreLaporanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'lat'       => 'required|numeric',
            'lng'       => 'required|numeric',
            'deskripsi' => 'required|string|min:10',
            'foto'      => 'required|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'lat.required'       => 'Lokasi (latitude) wajib ditentukan.',
            'lng.required'       => 'Lokasi (longitude) wajib ditentukan.',
            'deskripsi.required' => 'Deskripsi laporan wajib diisi.',
            'deskripsi.min'      => 'Deskripsi minimal 10 karakter.',
            'foto.required'      => 'Foto bukti laporan wajib diunggah.',
            'foto.image'         => 'File harus berupa gambar.',
            'foto.max'           => 'Ukuran foto maksimal 2MB.',
        ];
    }
}
