<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserEmissionTransmissionAndDistribution extends Model
{
    use HasFactory, SoftDeletes;

    public function transmissionanddistribution()
    {
        return $this->hasOne(TransmissionAndDistribution::class, 'id', 'factor_id')->select('id', 'activity', 'unit', 'factors');
    }
}
