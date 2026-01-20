<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'place_of_birth' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.string' => 'Nama depan harus berupa teks.',
            'last_name.string' => 'Nama belakang harus berupa teks.',
            'place_of_birth.string' => 'Tempat lahir harus berupa teks.',
            'date_of_birth.date' => 'Tanggal lahir harus berupa tanggal.',
            'address.string' => 'Alamat harus berupa teks.',
            'phone_number.numeric' => 'Nomer telepon harus berupa angka.'
        ];
    }
}
