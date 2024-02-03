<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Vehicle extends Model
{
   use HasFactory, SoftDeletes;

   protected $fillable = [
      'vehicle',
      'type',
      'fuel',
      'factors',
      'distance',
      'vehicle_type',
   ];

   const VEHICLE = [
      'Car',
      'Motorbike',
   ];

   const VEHICLE_TYPE = [
      '1' =>'Passenger Vehicles',
      '2' => 'Delivery Vehicles',
   ];

   const TYPE = [
      'Small Car',
      'Medium Car',
      'Large Car',
      'Average Car',
      'Small',
      'Medium',
      'Large',
      'Average',
   ];

   const FUEL = [
      'Diesel',
      'Petrol',
      'Hybrid',
      'CNG',
      'LPG',
      'Unknown',
      'Battery Electric',
      'Plug-in Hybrid Electric',
      'Plug-in Hybrid Electric (Petrol)',
   ];

   const DELIVERY_VEHICLE = [
      'HGV',
      'HGVs refrigerated',
      'Vans',
   ];

   const DELIVERY_TYPE = [
      'Rigid (>3.5 - 7.5 tonnes)',
      'Rigid (>7.5 tonnes - 17 tonnes)',
      'Rigid (17 tonnes)',
      'All rigids',
      'Articulated (>3.5 - 33t)',
      'Articulated (>33t)',
      'All artics',
      'All HGVs',
      'Class I (up to 1.305t)',
      'Class II (1.305t to 1.74t)',
      'Class III (1.74t to 3.5t)',
      'Average (up to 3.5t)',
   ];

   const DELIVERY_FUEL = [
      'Diesel',
      'Petrol',
      'CNG',
      'LPG',
      'Unknown',
      'Battery Electric',
   ];
}
