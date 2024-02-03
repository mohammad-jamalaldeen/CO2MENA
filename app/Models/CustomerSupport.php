<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSupport extends Model
{
    use HasFactory;

    const SUBJECT = [
        'Ask a question',
        'Need Help'
    ];

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function getCreatedAtAttribute()
    {
        $date = convertToDubaiTimezone($this->attributes['created_at']);
        return  $date;
    }
}
