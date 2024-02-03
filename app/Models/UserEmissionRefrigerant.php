<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserEmissionRefrigerant extends Model
{
    use HasFactory, SoftDeletes;

    public function refrigerants()
    {
        return $this->hasOne(Refrigerant::class, 'id', 'factor_id')->select('id', 'emission', 'unit', 'factors','type');
    }
}
