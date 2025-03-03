<?php
namespace App\Http\Requests\admin;

use App\Models\Kriteria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDokumenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'kriteria_id' => [
                'required',
                'exists:kriterias,id',
                function ($attribute, $value, $fail) {
                    $kriteria = Kriteria::where('id', $value)
                        ->where(function ($query) {
                            $query->whereHas('department', function ($query) {
                                $query->where('id', Auth::user()->department_id);
                            })->orWhere('department_id', 1);
                        })
                        ->first();

                    if (!$kriteria) {
                        $fail('The selected ' . $attribute . ' is invalid.');
                    }
                },

            ],
            'sub_kriteria' => 'max:255',
            'catatan' => 'max:255',
            'file' => 'nullable|mimes:pdf,png,jpg,jpeg|max:102400|prohibits:url',
            'url' => 'nullable|url|max:255|prohibits:file',
            'shareable' => 'nullable|exists:dokumens,id',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi!',
            'mimes' => ':attribute harus berupa PDF atau gambar',
            'max' => ':attribute maksimal :max karakter',
            'numeric' => ':attribute harus berupa angka',
            'prohibits' => 'Hanya isi salah satu (File/URL)',
            'url' => ':attribute harus berupa URL yang valid',
            'exists' => ':attribute yang dipilih tidak valid',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nama',
            'kriteria_id' => 'Kriteria',
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
