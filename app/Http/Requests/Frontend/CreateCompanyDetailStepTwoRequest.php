<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\{
    Company,
    CompanyDocument
};

class CreateCompanyDetailStepTwoRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        $user = Auth::guard('web')->user();
        $companyData = Company::where('user_id', $user->id)->first();
        $documentTypes = $companyData->companydocuments->pluck('document_type')->toArray();

        $allowedMimes = 'mimes:jpeg,png,jpg,webp,pdf,doc,docx|max:15360';
        $validationRules = [];

        $documentTypesToCheck = [
            CompanyDocument::TRADE_LICENSE => 'trade_license.*',
            CompanyDocument::ESTABLISHMENT => 'establishment.*',
        ];

        $requiredFiled = 'required|';


        foreach ($documentTypesToCheck as $documentType => $fieldName) {
            if (!in_array($documentType, $documentTypes)) {
                 // Set the initial value if not already set
                $validationRules[$fieldName] = $allowedMimes;
                
                // Update the value based on the condition
                if ($documentType == CompanyDocument::TRADE_LICENSE) {
                    $validationRules[$fieldName] = $requiredFiled . $allowedMimes;
                }
            } 
            // else {
            //     $validationRules[$fieldName] = $allowedMimes;
            // }
        }

        return $validationRules;
    }

     /**
     * Get custom error messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'trade_license.*.required' => 'The TRADE LICENSE is required.',
            'trade_license.*.max' => 'Please size exceeds  15MB.Please choose smaller file.',
            'establishment.*.max' => 'Please size exceeds  15MB.Please choose smaller file.',
            'trade_license.*.mimes' => 'The TRADE LICENSE field must be a file of type: jpeg, png, jpg, webp, pdf, doc, docx..',
            'establishment.*.mimes' => 'The ESTABLISHMENT CARD field must be a file of type: jpeg, png, jpg, webp, pdf, doc, docx..',
        ];
    }
}
