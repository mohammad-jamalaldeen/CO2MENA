<?php

namespace App\Http\Requests\Admin;

use App\Rules\NumericMaxLengthRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
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
        $allowedMimes = 'mimes:jpeg,png,jpg,pdf,webp|max:15360';
        return [
            'company_organization'=>'required|min:3',
            'email' => [
                'required',
                'email',
                'max:250',
                Rule::unique('users')->whereNull('deleted_at'),
            ],
            'company_name'=>'required|min:3',
            'company_logo'=>'nullable|mimes:jpeg,png,jpg,webp|max:15360',
            'trade_licence_number'=>'nullable|max:80',
            'no_of_employees'=>'nullable',
            'country_id'=>'nullable',
            'city' =>'nullable|min:3|max:85',
            'industry' =>'nullable',
            'address' =>'nullable',
            'emissionscope'=>'nullable',
            // 'company_phone_number'=>['nullable','numeric', new NumericMaxLengthRule(10)],
            'company_email'=>[
                'nullable',
                'email',
                'max:250',
            ],
            'tradeLicense.*'=>$allowedMimes,
            'established.*'=>$allowedMimes,
            'subscription_start_date'=>'required|before:subscription_end_date',
            'subscription_end_date'=>'required|after:subscription_start_date',
        ];
    }

    public function messages(): array
    {
        return [
            'tradeLicense.*.mimes' => 'The TRADE LICENSE field must be a file of type: jpg, jpeg, pdf,doc, docx, png, webp.',
            'established.*.mimes' => 'The ESTABLISHMENT CARD field must be a file of type: jpg, jpeg, pdf, png,doc, docx, webp.',
            'company_organization.required' => 'The name field is required'
        ];
    }
}
