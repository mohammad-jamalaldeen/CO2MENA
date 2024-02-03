<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class CustomerUpdateRequest extends FormRequest
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
        $id = $request->user_id;
        $company_id = $request->company_id;
        if(!empty($request->company_logo)){
            $required = "nullable|mimes:jpeg,png,jpg,webp|max:15360";
        } else {
            if(!empty($request->hidden_company_logo)){
                $required = "nullable|mimes:jpg,jpeg,gif,png,webp|max:15360";
            } else {
                $required = "nullable|mimes:jpg,jpeg,gif,png,webp|max:15360";
            }
        }
        
        $allowedMimes = 'mimes:jpg,jpeg,pdf,png,webp|max:15360';
        return [
            'company_name'=>'required|max:24',
            'company_logo'=> $required,
            'emissionscope'=>'nullable',
            'company_email'=>[
                'nullable',
                'email',
                'max:250',
            ],
            'tradeLicense.*'=>$allowedMimes,
            'established.*'=>$allowedMimes,
            'subscription_start_date'=>'required|before_or_equal:subscription_end_date',
            'subscription_end_date'=>'required|after_or_equal:subscription_start_date',
        ];
    }
    public function messages(): array
    {
        return [
            'tradeLicense.*.mimes' => 'The TRADE LICENSE field must be a file of type: jpg, jpeg, pdf, png, webp,doc, docx.',
            'established.*.mimes' => 'The ESTABLISHMENT CARD field must be a file of type: jpg, jpeg, pdf, png, webp, doc, docx.'
        ];
    }
}
