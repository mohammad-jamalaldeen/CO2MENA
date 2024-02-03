<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FreightingGoodsVansHgvs extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'vehicle',
        'type',
        'fuel',
        'unit',
        'factors',
        'formula',
        'distance',
    ];

    const VEHICLE = [
        'Vans',
        'HGV',
        'HGV refrigerated',
     ];

     const FUEL = [
        'Diesel',
        'Petrol',
        'CNG',
        'LPG',
        'Unknown',
        'Battery Electric',
     ];
}
