<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserEmissionFreightingGoodsFlightsRail extends Model
{
    use HasFactory, SoftDeletes;
    public function freightingGoodsFlight()
    {
        return $this->hasOne(FreightingGoodsFlightsRails::class, 'id', 'factor_id')->select('id', 'vehicle', 'type', 'unit', 'factors');
    }
}
