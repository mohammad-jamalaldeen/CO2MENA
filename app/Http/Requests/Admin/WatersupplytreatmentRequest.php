<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WatersupplytreatmentRequest extends FormRequest
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
            'unit' => 'required',
            'factors' => 'required|numeric',
        ];
    }
    public function messages(): array
    {
        return [
            'factors' => 'The emission factor field must be a number.',
        ];
    }
}
