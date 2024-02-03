<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyActivity extends Model
{
    use HasFactory,SoftDeletes;
    
    // public function emission()
    public function activity()
    {
        // return $this->hasOne(Activity::class,'id','activity_id')->whereNotIn('name', ['Home Office', 'Flight and Accommodation']);
        return $this->hasOne(Activity::class,'id','activity_id');
    }

    public function activitydata()
    {
        return $this->hasOne(Activity::class,'id','activity_id');
    }
}
