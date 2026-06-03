<?php

namespace App\Http\Requests\Warga;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlamatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'komplek_id'       => ['required', 'exists:komplek,id'],
            'nama_alamat'      => ['required', 'string', 'max:255'],
            'blok_nomor_rumah' => ['required', 'string', 'max:255'],
            'detail_patokan'   => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'komplek_id.required'       => 'Pilih komplek/perumahan.',
            'komplek_id.exists'         => 'Komplek yang dipilih tidak valid.',
            'nama_alamat.required'      => 'Nama alamat wajib diisi (misal: Rumah, Kantor).',
            'blok_nomor_rumah.required' => 'Alamat lengkap (Blok/No Rumah) wajib diisi.',
        ];
    }
}
