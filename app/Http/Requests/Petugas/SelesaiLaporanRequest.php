<?php

namespace App\Http\Requests\Petugas;

use Illuminate\Foundation\Http\FormRequest;

class SelesaiLaporanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization di-handle di controller
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'foto_hasil' => 'required|image|max:2048',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'foto_hasil.required' => 'Foto hasil pembersihan wajib diunggah.',
            'foto_hasil.image'    => 'File harus berupa gambar (jpg, png, gif, dsb).',
            'foto_hasil.max'      => 'Ukuran foto maksimal 2MB.',
        ];
    }
}
