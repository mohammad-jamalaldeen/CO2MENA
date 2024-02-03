<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserEmissionWatersupplytreatment extends Model
{
    use HasFactory, SoftDeletes;

    public function watersupplytreatments()
    {
        return $this->hasOne(Watersupplytreatment::class, 'id','factor_id')->select('id', 'type', 'unit', 'factors');
    }
}
