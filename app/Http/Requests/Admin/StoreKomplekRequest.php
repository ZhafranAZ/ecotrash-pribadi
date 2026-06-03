<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreKomplekRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_komplek' => ['required', 'string', 'max:255'],
            'lat'          => ['required', 'numeric'],
            'lng'          => ['required', 'numeric'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_komplek.required' => 'Nama komplek wajib diisi.',
            'lat.required'          => 'Koordinat latitude wajib diisi.',
            'lat.numeric'           => 'Latitude harus berupa angka.',
            'lng.required'          => 'Koordinat longitude wajib diisi.',
            'lng.numeric'           => 'Longitude harus berupa angka.',
        ];
    }
}
