<?php

namespace App\Http\Requests\Frontend;

use App\Rules\NumericMaxLengthRule;
use Illuminate\Foundation\Http\FormRequest;

class CustomerSupportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'phone_number' => ['required'],
            'subject' => ['required'],
            'filename.*' => ['file','mimes:jpeg,jpg,png,webp,pdf,doc,docx,xlsx'],
            'message' => ['required']
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
            'phone_number.required' => 'The contact number is required.',
            // 'phone_number.digits_between' => 'The contact number must be 10 digit.',
        ];
    }
}
