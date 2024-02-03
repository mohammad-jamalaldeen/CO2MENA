<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserEmissionFlight extends Model
{
    use HasFactory, SoftDeletes;
    public function flight()
    {
        return $this->hasOne(Flight::class, 'id', 'factor_id');
    }
}
