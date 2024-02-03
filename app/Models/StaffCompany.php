<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffCompany extends Model
{
    use HasFactory, SoftDeletes;
    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
    public function company()
    {
        return $this->hasOne(Company::class,'id','company_id');
    }
}
