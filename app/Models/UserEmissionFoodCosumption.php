<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserEmissionFoodCosumption extends Model
{
    use HasFactory,SoftDeletes;

    public function foodcosumption()
    {
        return $this->hasOne(FoodCosumption::class, 'id', 'factor_id');
    }
}
