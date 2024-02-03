<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserEmissionMaterialUse extends Model
{
    use HasFactory, SoftDeletes;

    public function materialuses()
    {
        return $this->hasOne(MaterialUse::class, 'id', 'factor_id')->select('id', 'activity', 'waste_type', 'factors');
    }
}
