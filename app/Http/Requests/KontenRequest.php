<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KontenRequest extends FormRequest
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
        $kontenId = $this->route('konten') ? $this->route('konten')->id : null;

        return [
            'kategori_koten_id' => [
                'required',
                'exists:kategori_kotens,id',
            ],
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'body' => [
                'required',
                'string',
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:2048', // 2MB
            ],
            'author' => [
                'nullable',
                'string',
                'max:100',
            ],
            'status' => [
                'required',
                'in:draft,published',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'kategori_koten_id.required' => 'Kategori konten wajib dipilih.',
            'kategori_koten_id.exists' => 'Kategori konten yang dipilih tidak valid.',
            'title.required' => 'Judul konten wajib diisi.',
            'title.string' => 'Judul konten harus berupa teks.',
            'title.max' => 'Judul konten maksimal 255 karakter.',
            'body.required' => 'Konten wajib diisi.',
            'body.string' => 'Konten harus berupa teks.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar yang diizinkan: jpeg, png, jpg, gif, webp.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'author.string' => 'Nama penulis harus berupa teks.',
            'author.max' => 'Nama penulis maksimal 100 karakter.',
            'status.required' => 'Status konten wajib dipilih.',
            'status.in' => 'Status konten harus draft atau published.',
        ];
    }
}
