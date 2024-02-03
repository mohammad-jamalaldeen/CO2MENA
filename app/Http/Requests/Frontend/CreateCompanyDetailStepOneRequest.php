<?php

namespace App\Http\Requests\Frontend;

use App\Rules\WhiteSpaceRule;
use App\Rules\NumericMaxLengthRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;

class CreateCompanyDetailStepOneRequest extends FormRequest
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
        $user = Auth::guard('web')->user();
        $companyData = Company::select('company_logo', 'user_id', 'company_email', 'id')->where('user_id', $user->id)->first();
        // $uniqueEmailCheck = ($companyData->company_email === NULL || $companyData->company_email == '') ? '|unique:companies,company_email' : '';
        // $companyLogoValidation = $companyData ? 'mimes:jpeg,png,jpg,webp|max:15360' : 'required|mimes:jpeg,png,jpg,webp|max:15360';
        $companyLogoValidation =  'mimes:jpeg,png,jpg,webp|max:15360';
      
        return [
            'company_name' =>[ 'required', 'max:24', new WhiteSpaceRule()],
            'trade_licence_number' => ['required', new WhiteSpaceRule()],
            'no_of_employees' => 'required',
            'company_email' => 'required|email|max:255',
            'company_phone' => ['required'],
            // new NumericMaxLengthRule(10)
            'company_logo' => $companyLogoValidation,
            // 'address' => ['required', new WhiteSpaceRule()],
            // 'country_id' => ['required', new WhiteSpaceRule()],
            // 'city' => ['required','min:3',  'max:85', new WhiteSpaceRule()]
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'company_email.required' => 'The email is required.',
            'company_phone.required' => 'The contact number is required.',
            'country_id.required' => 'The country is required.',
            'company_logo.max' => 'File Size exceeds 15MB.Please choose a smaller file.',
        ];
    }
}
