<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Electricity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'activity',
        'country',
        'unit',
        'factors', 
        'amount',
        'type',
        'electricity_type',
    ];

    const UNIT = [
        'kWh',
        'Ton of refrigeration',
     ];

     const TYPE = [
        '1' =>'Electricity Grid',
        '2' => 'Heat And Steam',
        '3' => 'District Cooling',
     ];

     const COUNTRY = [
        'Afghanistan',
        'Albania',
        'Algeria',
        'Andorra',
        'Angola',
        'Antigua and Barbuda',
        'Argentina',
        'Armenia',
        'Dubai'
     ];

     public function country()
     {
        return $this->hasOne(Country::class,'id','country')->select('id', 'code', 'name');
     }
    
}
