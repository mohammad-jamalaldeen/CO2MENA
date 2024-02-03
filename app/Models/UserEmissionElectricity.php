<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserEmissionElectricity extends Model
{
    use HasFactory,SoftDeletes;

    public function electricity()
    {
        return $this->hasOne(Electricity::class, 'id', 'factor_id');
    }
}
