<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class TransmissionAndDistribution extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'activity',
        'unit',
        'factors',
    ];

    const UNIT = [
        'KWh'
    ];
    
}
