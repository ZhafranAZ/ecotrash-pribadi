<?php

namespace App\Http\Requests\Petugas;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Authorization handled in controller
    }

    public function rules(): array
    {
        return [
            'status'     => 'required|in:diproses,selesai',
            'foto_bukti' => 'required_if:status,selesai|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'status.required'        => 'Status wajib diisi.',
            'status.in'              => 'Status tidak valid.',
            'foto_bukti.required_if' => 'Foto bukti wajib dilampirkan saat menyelesaikan pesanan.',
            'foto_bukti.image'       => 'File harus berupa gambar.',
            'foto_bukti.max'         => 'Ukuran foto maksimal 2MB.',
        ];
    }

    /**
     * Return JSON response on validation failure (Axios request).
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validasi gagal.',
                'errors'  => $validator->errors(),
            ], 422)
        );
    }
}
