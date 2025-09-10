<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNasabahRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $nasabahId = $this->route('nasabah')->id;

        return [
            'kode_nasabah' => 'nullable|string|unique:nasabah,kode_nasabah,' . $nasabahId . '|max:20',
            'nama' => 'required|string|max:255',
            'nik_nip' => 'required|string|unique:nasabah,nik_nip,' . $nasabahId . '|max:50',
            'alamat' => 'required|string',
            'instansi' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama nasabah wajib diisi.',
            'nik_nip.required' => 'NIK/NIP wajib diisi.',
            'nik_nip.unique' => 'NIK/NIP sudah terdaftar pada nasabah lain.',
            'alamat.required' => 'Alamat wajib diisi.',
            'kode_nasabah.unique' => 'Kode nasabah sudah digunakan.',
        ];
    }
}