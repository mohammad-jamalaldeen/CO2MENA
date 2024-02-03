<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class BakupCreateRequest extends FormRequest
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
    public function rules(Request $request): array
    {
        if($request->radiocheck == "custom"){
            if($request->my_hidden_startdate && $request->my_hidden_enddate){
                $requiredDate = "required|before:my_hidden_enddate";
            }else{
                $requiredDate = "required|before:my_hidden_enddate";
            }
        }else{
            $requiredDate = "nullable";
        }
        return [
            'company'=>'required',
            'radiocheck'=>'required',
            'custom_date'=>$requiredDate,
        ];
    }
}
