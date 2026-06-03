<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ApproveLaporanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'petugas_id'  => 'required|exists:users,id',
            'koin_reward' => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'petugas_id.required'  => 'Petugas lapangan wajib dipilih.',
            'petugas_id.exists'    => 'Petugas yang dipilih tidak valid.',
            'koin_reward.required' => 'Jumlah koin reward wajib diisi.',
            'koin_reward.integer'  => 'Koin reward harus berupa angka.',
            'koin_reward.min'      => 'Koin reward tidak boleh negatif.',
        ];
    }
}
