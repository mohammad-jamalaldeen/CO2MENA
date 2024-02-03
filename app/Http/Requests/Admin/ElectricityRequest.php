<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class ElectricityRequest extends FormRequest
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
    public function rules(Request $request): array
    {
        return [
            'activity' => 'required',
            'country' => ($request->electricity_type == '1' || $request->electricity_type == '3' ) ? 'required' : 'nullable',
            'unit' => 'required',
            'factors' => 'required|numeric',
            'electricity_type' => 'required',
        ];
    }
}
