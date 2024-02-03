<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class industryScope extends Model
{
    use HasFactory;
    protected $table = 'industry_scopes';

    public function activity()
    {
        return $this->hasOne(Activity::class,'id','activity_id');
    }

    public function industry()
    {
        return $this->hasOne(CompanyIndustry::class,'id','industry_id');
    }
    public function scope()
    {
        return $this->hasOne(Scope::class,'id','scope_id');
    }

    public function getCreatedAtAttribute()
    {
        $date = convertToDubaiTimezone($this->attributes['created_at']);
        return  $date;
    }
}
