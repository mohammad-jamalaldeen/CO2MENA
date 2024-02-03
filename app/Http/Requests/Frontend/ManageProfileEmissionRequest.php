<?php

namespace App\Http\Requests\Frontend;

use App\Models\Company;
use App\Models\Activity;
use App\Models\CompanyActivity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ManageProfileEmissionRequest extends FormRequest
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
        $companyActivity = Company::where('id',$request->company_id)->first()->toArray();
        $companyDataJson = json_decode($companyActivity['temp_json'], true); 
        $companyActivities = $companyDataJson['companyactivities'];
        $validationArr = [];
        foreach($companyActivities as $name){
            $emission = generateSlug($name['name']);
            if(isset($request->{$emission}) && count($request->{$emission}) > 0){
                $required = "nullable";
            }else{
                $required = "required";
            }
            $validationArr[$emission] = $required;
        }
        if(array_key_exists('freighting_goods',$validationArr)){
            unset($validationArr['freighting_goods']);
            $validationArr['freighting_goods_vansHgv'] = 'required'; 
            $validationArr['freighting_goods_flights_rail'] = 'required'; 
        }
        if(array_key_exists('owned_vehicles',$validationArr)){
            unset($validationArr['owned_vehicles']);
            $validationArr['owned_vehicles_passenger'] = 'required'; 
            $validationArr['owned_vehicles_delivery'] = 'required'; 
        }
        
        if(array_key_exists('home_office',$validationArr)){
            unset($validationArr['home_office']);
        }
        if(array_key_exists('flight_and_accommodation',$validationArr)){
            unset($validationArr['flight_and_accommodation']);
        }
        return $validationArr;
    }
    public function messages(): array
    {
        $messages = [];
        
        $emissionName = Activity::all(); // You may need to fetch all activities to match with your form fields.

        foreach ($emissionName as $emission) {
            $emission_name = generateSlug($emission->name);
            $messages["$emission_name.required"] = $emission->name;
        }
        if(array_key_exists('freighting_goods.required',$messages)){
            unset($messages['freighting_goods.required']);
            $messages['freighting_goods_vansHgv.required'] = 'Freighting Goods vans and HGVs'; 
            $messages['freighting_goods_flights_rail.required'] = 'Freighting Goods Flights Rail'; 
        }
        if(array_key_exists('owned_vehicles.required',$messages)){
            unset($messages['owned_vehicles.required']);
            $messages['owned_vehicles_passenger.required'] = 'Owned Passenger Vehicles '; 
            $messages['owned_vehicles_delivery.required'] = 'Owned Delivery Vehicles'; 
        }
        return $messages;
    }
    
}
