<?php

namespace App\Http\Requests\superadmin;

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
            'Departments' => 'required|exists:department_ids,id',
            'status' => 'required|in:private,share,borrow',
            'catatan' => 'max:255',
            'file' => 'required_without_all:url|mimes:pdf,png,jpg,jpeg|max:102400',
            'url' => 'required_without_all:file|url|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama harus diisi.',
            'name.max' => 'Nama tidak boleh melebihi 255 karakter.',
            'kriteria.required' => 'Kriteria harus diisi.',
            'kriteria.numeric' => 'Kriteria harus berupa angka.',
            'kriteria.between' => 'Kriteria harus di antara 1 dan 12.',
            'sub_kriteria.max' => 'Sub Kriteria tidak boleh melebihi 255 karakter.',
            'Departments.required' => 'Program Studi harus diisi.',
            'Departments.exists' => 'Program Studi yang dipilih tidak valid.',
            'status.required' => 'Status harus diisi.',
            'status.in' => 'Status yang dipilih tidak valid.',
            'catatan.max' => 'Catatan tidak boleh melebihi 255 karakter.',
            'file.required_without_all' => 'File harus diisi jika tidak ada URL yang ada.',
            'file.mimes' => 'File harus berupa file PDF atau gambar.',
            'file.max' => 'File tidak boleh melebihi 100 megabita.',
            'url.required_without_all' => 'URL harus diisi jika tidak ada File yang ada.',
            'url.url' => 'URL harus berupa URL yang valid.',
            'url.max' => 'URL tidak boleh melebihi 255 karakter.',
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
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => $this->department,
        ]);
    }
}
