<?php

namespace App\Http\Requests\Petugas;

use Illuminate\Foundation\Http\FormRequest;

class TundaLaporanRequest extends FormRequest
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
            'alasan_utama'     => 'required|string|max:255',
            'catatan_tambahan' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'alasan_utama.required' => 'Alasan penundaan wajib dipilih.',
            'alasan_utama.max'      => 'Alasan penundaan maksimal 255 karakter.',
            'catatan_tambahan.max'  => 'Catatan tambahan maksimal 1000 karakter.',
        ];
    }
}
