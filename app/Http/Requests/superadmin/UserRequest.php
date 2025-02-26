<?php

namespace App\Http\Requests\superadmin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'username' => 'required|string|max:255|unique:users,username',
            'department' => 'required|exists:departments,id',
            'role' => 'required|in:admin,user',
            'password' => 'required|string|min:8|confirmed',
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
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nama Lengkap',
            'username' => 'Username',
            'department' => 'Program Studi',
            'role' => 'Role',
            'password' => 'Password',
            'password_confirmation' => 'Konfirmasi Password',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'department_id' => $this->department,
        ]);
    }
}
