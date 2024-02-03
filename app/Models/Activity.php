<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory, SoftDeletes;

    public function getCreatedAtAttribute()
    {
        $date = convertToDubaiTimezone($this->attributes['created_at']);
        return  $date;
    }

    const REFRIGERANTS =  'refrigerants';
    const FUELS =  'fuels';
    const WTT_FULES =  'wtt_fules';
    const T_D = 't_d';
    const WATER = 'water';
    const MATERIAL_USE = 'material_use';
    const FOOD = 'food';
    const BUSSINESSTRAVEL = 'business_travel_land_and_sea';
    const WTT_Fules =  'wtt_fules';
    const EMPLOYEECOMMUNTING = 'employees_commuting';
    const WASTEDISPOSAL = 'waste_disposal';
    const OWNED_VEHICLES = 'owned_vehicles';
    const ELECTRICITY_HEAT_COOLING = 'electricity_heat_cooling';
    const FREIGHTING_GOODS_FlightsRail = 'freighting_goods_flights_rail';
    const FREIGHTING_GOODS_VansHgv = 'freighting_goods_vansHgv';
    const FREIGHTING_GOODS = 'freighting_goods';
    const FLIGHT_AND_ACCOMMODATION = 'flight_and_accommodation';
    const OWNED_VEHICLES_PASSENGER = 'owned_vehicles_passenger';
    const OWNED_VEHICLES_DELIVERY = 'owned_vehicles_delivery';
    const HOME_OFFICE = 'home_office';
    
    
}
