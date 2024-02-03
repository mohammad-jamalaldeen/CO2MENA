<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserEmissionVehicle extends Model
{
    use HasFactory, SoftDeletes;
    public function vehicles()
    {
        return $this->hasOne(Vehicle::class, 'id', 'factor_id')->select('id', 'vehicle', 'type', 'fuel', 'factors','vehicle_type');
    }
}
