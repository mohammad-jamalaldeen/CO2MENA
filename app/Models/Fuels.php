<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Fuels extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'fuel',
        'unit',
        'factor',
    ];

    const TYPE = [
        'Gaseous fuels',
        'Liquid fuels',
        'Solid fuels',
     ];

     const UNIT = [
        'liters',
        'cubic metres',
        'tonnes',
     ];
    
}
