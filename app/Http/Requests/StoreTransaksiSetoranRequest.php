<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransaksiSetoranRequest extends FormRequest
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
        return [
            'nasabah_id' => 'required|exists:nasabah,id',
            'jenis_sampah_id' => 'required|exists:jenis_sampah,id',
            'berat_kg' => 'required|numeric|min:0.01|max:9999.99',
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
            'nasabah_id.required' => 'Nasabah wajib dipilih.',
            'nasabah_id.exists' => 'Nasabah tidak ditemukan.',
            'jenis_sampah_id.required' => 'Jenis sampah wajib dipilih.',
            'jenis_sampah_id.exists' => 'Jenis sampah tidak ditemukan.',
            'berat_kg.required' => 'Berat sampah wajib diisi.',
            'berat_kg.numeric' => 'Berat sampah harus berupa angka.',
            'berat_kg.min' => 'Berat sampah minimal 0.01 kg.',
            'berat_kg.max' => 'Berat sampah maksimal 9999.99 kg.',
        ];
    }
}