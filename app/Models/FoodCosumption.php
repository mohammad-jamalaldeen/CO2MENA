<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FoodCosumption extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'vehicle',
        'unit',
        'factors',
    ];

    const UNIT = [
        'breakfast',
        'hot snack',
        'meal',
        'litre',
        'sandwich',
     ];

     const TYPE = [
        'Meal',
        'Drink',
    ];
}
