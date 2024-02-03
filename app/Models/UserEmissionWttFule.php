<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserEmissionWttFule extends Model
{
    use HasFactory, SoftDeletes;

    public function wttfules()
    {
        return $this->hasOne(WttFules::class, 'id', 'factor_id')->select('id', 'type', 'fuel', 'unit', 'factors');
    }
}
