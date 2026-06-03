<?php

namespace App\Http\Requests\Petugas;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReportKendalaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Authorization handled in controller
    }

    public function rules(): array
    {
        return [
            'tipe_kendala'  => 'required|in:terkunci,beda_ukuran',
            'alasan'        => 'nullable|string|max:500',
            'foto_kendala'  => 'nullable|image|max:2048',
            'ukuran_aktual' => 'required_if:tipe_kendala,beda_ukuran|in:sedang,besar',
        ];
    }

    public function messages(): array
    {
        return [
            'tipe_kendala.required'     => 'Tipe kendala wajib diisi.',
            'tipe_kendala.in'           => 'Tipe kendala tidak valid.',
            'foto_kendala.image'        => 'File harus berupa gambar.',
            'foto_kendala.max'          => 'Ukuran foto maksimal 2MB.',
            'ukuran_aktual.required_if' => 'Ukuran aktual wajib diisi untuk kendala beda ukuran.',
            'ukuran_aktual.in'          => 'Ukuran aktual tidak valid.',
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
