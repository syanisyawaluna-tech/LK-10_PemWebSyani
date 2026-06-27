<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MahasiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('mahasiswa') ? $this->route('mahasiswa')->id : null;

        return [
            'nim'          => 'required|string|max:20|unique:mahasiswas,nim,' . $id,
            'nama'         => 'required|string|max:100',
            'email'        => 'required|email|unique:mahasiswas,email,' . $id,
            'jenis_barang' => 'required|string|max:100',
            'angkatan'     => 'required|integer|min:2000|max:' . date('Y'),
        ];
    }

    public function messages(): array
    {
        return [
            'nim.unique' => 'NIM sudah terdaftar.',
            'email.unique' => 'Email sudah terdaftar.',
            'angkatan.max' => 'Angkatan tidak boleh melebihi tahun sekarang.',
        ];
    }
}
