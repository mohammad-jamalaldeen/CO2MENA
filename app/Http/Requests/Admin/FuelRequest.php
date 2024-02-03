<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FuelRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'required',
            'fuel' => 'required',
            'unit' => 'required',
            'factor' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'factor' => 'The emission factor field must be a number.',
        ];
    }
}
