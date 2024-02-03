<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserEmissionBusinessTravel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table ="user_emission_business_travels";

    public function businesstravels()
    {
        return $this->hasOne(BusinessTravels::class, 'id', 'factor_id')->select('id','vehicles', 'type', 'fuel', 'unit', 'factors');
    }
}
