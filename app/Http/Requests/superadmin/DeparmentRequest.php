<?php

namespace App\Http\Requests\superadmin;

use Illuminate\Foundation\Http\FormRequest;

class DeparmentRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'type' => 'required|in:faculty,program',
            'parent_id' => 'required_if:type,program|exists:departments,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama departemen wajib diisi.',
            'name.string' => 'Nama departemen harus berupa string.',
            'name.max' => 'Nama departemen tidak boleh lebih dari 255 karakter.',
            'type.required' => 'Jenis departemen wajib diisi.',
            'type.in' => 'Jenis departemen harus berupa fakultas atau program.',
            'parent_id.required_if' => 'Departemen induk wajib diisi ketika jenis adalah program.',
            'parent_id.exists' => 'Departemen induk yang dipilih tidak ada.',
        ];
    }
}
