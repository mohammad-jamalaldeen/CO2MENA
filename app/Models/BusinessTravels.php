<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessTravels extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'row_id',
        'vehicles',
        'type',
        'fuel',
        'unit',
        'factors',
        'formula',
        'total_distance',
    ];

    const VEHICLE = [
        'Bus',
        'Car',
        'Ferry',
        'Motorbike',
        'Rail',
        'Taxi',
     ];

     const FUEL = [
        'Unknown',
        'Diesel',
        'Petrol',
        'Hybrid',
        'CNG',
        'LPG',
        'Plug-in Hybrid Electric',
        'Battery Electric',
        'Foot Passenger',
        'Car Passenger',
        'Average Passenger',
     ];

     const TYPE = [
      //   'Local Bus',
      //   'Local London Bus',
        'Average Local Bus',
        'Coach',
        'Small Car',
        'Medium Car',
        'Large Car',
        'Average Car',
        'Foot Passenger',
        'Car Passenger',
        'Average Passenger',
        'Small',
        'Medium',
        'Large',
        'National Rail',
        'International Rail',
        'Light Rail And Tram',
        'London Underground',
        'Regular',
        'Black Cab',
     ];

     const UNIT = [
        'Passenger.km',
        'km',
     ];

}
