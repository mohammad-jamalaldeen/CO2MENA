<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
    

class EmployeesCommuting extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'row_id',
        'vehicle',
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
        'Battery Electric',
        'Plug-in Hybrid Electric',
        'Plug-in Hybrid Electric (Petrol)',
        
     ];

     const TYPE = [
        'Local bus',
      //   'Local London Bus',
        'Average local bus',
        'Coach',
        'Small car',
        'Medium car',
        'Large car',
        'Average car',
        'National rail',
        'international rail',
        'Light rail and tram',
        'London underground',
        'Regular',
        'Black cab',
        'Small',
        'Medium',
        'Large',
        'Average'
     ];

     const UNIT = [
        'Passenger.km',
        'km',
     ];

}
