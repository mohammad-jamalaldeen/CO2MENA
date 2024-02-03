<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WttFules extends Model
{
    use HasFactory, SoftDeletes;

    const UNIT = [
      'litres',
      'cubic metres',
      'tonnes',
     ];

     const TYPE = [
        'Gaseous fuels',
        'Liquid fuels',
        'Solid fuels',
     ];
}
