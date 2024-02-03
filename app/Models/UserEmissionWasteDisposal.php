<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserEmissionWasteDisposal extends Model
{
    use HasFactory,SoftDeletes;

    public function wastedisposal()
    {
        return $this->hasOne(WasteDisposal::class, 'id', 'factor_id')->select('id', 'waste_type', 'factors','type');
    }
}
