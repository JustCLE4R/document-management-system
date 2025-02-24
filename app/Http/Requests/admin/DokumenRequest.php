<?php

namespace App\Http\Requests\admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class DokumenRequest extends FormRequest
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
            'kriteria' => 'required|numeric|between:1,12',
            'sub_kriteria' => 'max:255',
            'catatan' => 'max:255',
            'file' => 'required_without_all:url,shareable|mimes:pdf,png,jpg,jpeg|max:102400',
            'url' => 'required_without_all:file,shareable|url|max:255',
            'shareable' => 'required_without_all:file,url|exists:dokumens,id',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi!',
            'mimes' => ':attribute harus berupa PDF atau gambar',
            'max' => ':attribute maksimal :max karakter',
            'numeric' => ':attribute harus berupa angka',
            'between' => ':attribute harus diantara 1 sampai 9',
            'required_without_all' => ':attribute harus diisi jika :values tidak diisi',
            'url' => ':attribute harus berupa URL yang valid',
            'exists' => ':attribute yang dipilih tidak valid',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nama',
            'kriteria' => 'Kriteria',
            'sub_kriteria' => 'Sub Kriteria',
            'catatan' => 'Catatan',
            'file' => 'File',
            'url' => 'URL',
            'shareable' => 'Shareable',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => Auth::user()->id,
        ]);
    }
}
