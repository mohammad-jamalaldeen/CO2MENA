<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MaterialUse extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'activity',
        'waste_type',
        'factors',
    ];
 
    const ACTIVITY = [
        'Construction',
        'Other',
        'Organic',
        'Electrical Items',
        'Metal',
        'Plastic',
        'Paper',
    ];
}
