<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FreightingGoodsFlightsRails extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'vehicle',
        'type',
        'unit',
        'factors',
        'formula',
        'distance',
    ];

    const VEHICLE = [
        'Freight Flights',
        'Rail',
        'Sea Tanker',
        'Cargo Ship',
     ];

     const UNIT = [
        'tonne.km',
     ];
}
