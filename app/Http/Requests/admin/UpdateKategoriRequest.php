<?php

namespace App\Http\Requests\admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateKategoriRequest extends FormRequest
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
            'name' => 'required|max:255',
            'description' => 'nullable|max:64',
            // 'department_id' => 'required|exists:departments,id|in:' . implode(',', Auth::user()->departments->pluck('id')->toArray()),
            'icon' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama Kategori wajib diisi!',
            'name.max' => 'Nama Kategori maksimal 255 karakter!',
            'description.max' => 'Deskripsi maksimal 64 karakter!',
            // 'department_id.required' => 'Fakultas atau Program Studi wajib dipilih!',
            // 'department_id.exists' => 'Fakultas atau Program Studi yang dipilih tidak valid!',
            'icon.required' => 'Ikon wajib dipilih!',
            'icon.string' => 'Ikon harus berupa string!',
            'icon.max' => 'Ikon maksimal 255 karakter!',
            'image.image' => 'File harus berupa gambar!',
            'image.mimes' => 'Gambar harus berupa file dengan tipe: jpeg, png, jpg, svg!',
            'image.max' => 'Gambar maksimal 2048 kilobytes!',
        ];
    }
}
