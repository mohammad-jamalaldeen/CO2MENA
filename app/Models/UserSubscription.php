<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSubscription extends Model
{
    use HasFactory,SoftDeletes;

    public function user()
    {
        return $this->hasOne(User::class,'id','updated_by');
    }

    public function getStartDateAttribute()
    {
        $date = $this->attributes['start_date'];
        return  date('M d, Y',strtotime($date));
    }
    public function getEndDateAttribute()
    {
        $date = $this->attributes['end_date'];
        return  date('M d, Y',strtotime($date));
    }
    public function getCreatedAtAttribute()
    {
        $date = convertToDubaiTimezone($this->attributes['created_at']);
        return  $date;
    }
}
