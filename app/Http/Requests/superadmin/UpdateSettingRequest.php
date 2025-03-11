<?php

namespace App\Http\Requests\superadmin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
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
            'app_name' => 'required|string|max:255',
            'app_alias' => 'required|string|max:50',
            'app_description' => 'required|string|max:255',
            'color_primary' => 'required|regex:/^#([a-fA-F0-9]{6})$/',
            'color_secondary' => 'required|regex:/^#([a-fA-F0-9]{6})$/',
            'color_tertiary' => 'required|regex:/^#([a-fA-F0-9]{6})$/',
        ];
    }

    /**
     * Get the custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required' => 'The :attribute is required.',
            'regex' => 'The :attribute must be a valid hex code (e.g., #FF0000).',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'app_name' => 'application name',
            'app_alias' => 'application alias',
            'app_description' => 'application description',
            'color_primary' => 'primary color',
            'color_secondary' => 'secondary color',
            'color_tertiary' => 'tertiary color',
        ];
    }
}
