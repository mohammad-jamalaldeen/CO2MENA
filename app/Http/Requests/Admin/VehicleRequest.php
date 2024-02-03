<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VehicleRequest extends FormRequest
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
        $vehicleType = $this->input('vehicle_type');

        // return [
        //     'vehicle' => $vehicleType == 1 ? 'required' : '',
        //     'type' => $vehicleType == 1 ? 'required' : '',
        //     'fuel' => $vehicleType == 1 ? 'required' : '',
        //     'factors' => 'nullable|numeric',
        // ];

        return [
            'vehicle' => 'required',
            //'type' => 'required',
            'fuel' => 'required',
            'factors' => 'required|numeric',
            'id_field' => 'vehicle_type_validation',
            'delivery_vehicle_field' => 'vehicle_type_validation',
        ];
    }

    public function messages(): array
    {
        return [
            'factors' => 'The emission factor field must be a number.',
        ];
    }
}
