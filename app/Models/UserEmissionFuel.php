<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserEmissionFuel extends Model
{
    use HasFactory, SoftDeletes;

    public function fules()
    {
        return $this->hasOne(Fuels::class, 'id', 'factor_id')->select('id','type', 'fuel', 'unit', 'factor');
    }
}
