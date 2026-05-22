<?php

namespace App\Http\Requests\Warga;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfilRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama'       => ['required', 'string', 'max:255'],
            'no_telepon' => ['required', 'string', 'min:10'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required'       => 'Nama wajib diisi.',
            'nama.max'            => 'Nama maksimal 255 karakter.',
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'no_telepon.min'      => 'Nomor telepon minimal 10 digit.',
        ];
    }
}
