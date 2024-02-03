<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserEmissionEmployeesCommuting extends Model
{
    use HasFactory,SoftDeletes;
    public function employeescommutings()
    {
        return $this->hasOne(EmployeesCommuting::class, 'id', 'factor_id')->select('id', 'vehicle', 'type', 'fuel', 'unit', 'factors');
    }
}
