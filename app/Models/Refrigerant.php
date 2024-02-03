<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Refrigerant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'emission',
        'unit',
        'type',
        'factors',
        'amount',
    ];

    const UNIT = [
        'Kg',
    ];

    const TYPE = [
        'Gaseous',
        'HFC',
        'R Type',
        'CFC',        
    ];
    
}
