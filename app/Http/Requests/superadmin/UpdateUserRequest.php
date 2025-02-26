<?php

namespace App\Http\Requests\superadmin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $this->user->id,
            'department' => 'required|exists:departments,id',
            'role' => 'required|in:admin,user',
            'password' => 'nullable|required_with:old_password|string|min:8|confirmed',
            'password_confirmation' => 'nullable|required_with:password|string|min:8',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama harus diisi.',
            'username.required' => 'Username harus diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'department.required' => 'Program Studi harus diisi.',
            'department.exists' => 'Program Studi yang dipilih tidak valid.',
            'role.required' => 'Role harus diisi.',
            'role.in' => 'Role harus admin atau user.',
            'old_password.required_with' => 'Password lama harus diisi.',
            'old_password.min' => 'Password lama minimal harus 8 karakter.',
            'password.required_with' => 'Semua password harus diisi jika ingin diganti.',
            'password.min' => 'Password baru minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password_confirmation.required_with' => 'Konfirmasi password harus diisi.',
            'password_confirmation.min' => 'Konfirmasi password minimal harus 8 karakter.',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nama',
            'username' => 'Username',
            'department' => 'Program Studi',
            'role' => 'Role',
            'old_password' => 'Password Lama',
            'password' => 'Password Baru',
            'password_confirmation' => 'Ulangi Password Baru',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'department_id' => $this->department,
        ]);
    }
}
