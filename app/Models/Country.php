<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory, SoftDeletes;

    const countries = [
        'United Arab Emirates',
        'Saudi Arabia',
        'Qatar',
        'Bahrain',
        'Oman',
        'Kuwait',
        'Lebanon',
        'Iraq',
        'Jordan',
        'Egypt',
        'Morocco',
        'Tunisia'
    ];
    const countries_prefix = [
        '971' =>'United Arab Emirates',
        '966' => 'Saudi Arabia',
        '974'=>'Qatar',
        '973'=>'Bahrain',
        '968'=>'Oman',
        '965'=>'Kuwait',
        '961'=>'Lebanon',
        '964'=>'Iraq',
        '962'=>'Jordan',
        '20'=>'Egypt',
        '212'=>'Morocco',
        '216'=>'Tunisia'
    ];

}
