<?php

namespace App\Http\Requests\admin;

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
            'old_password' => 'required|string|current_password',
            'password' => 'nullable|string|min:8|confirmed',
            'password_confirmation' => 'nullable|required_with:password|string|min:8',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama harus diisi.',
            'username.required' => 'Username harus diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'old_password.required' => 'Password harus diisi.',
            'old_password.min' => 'Password minimal harus 8 karakter.',
            'old_password.current_password' => 'Password lama tidak cocok.',
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
