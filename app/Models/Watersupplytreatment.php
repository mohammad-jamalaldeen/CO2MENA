<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Watersupplytreatment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'unit',
        'factors',
    ];

    const UNIT = [
        'Cubic Metres',
    ];

    const TYPE = [
        'Water Supply' => 'Water Supply',
        'Water Treatment' => 'Water Treatment',
    ];
}
