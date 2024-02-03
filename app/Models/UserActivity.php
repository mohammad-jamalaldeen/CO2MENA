<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    use HasFactory;

    public function module()
    {
        return $this->hasOne(\App\Models\Module::class, 'id', 'module_id');
    }
    public function user()
    {
        return $this->hasOne(\App\Models\User::class, 'id', 'user_id');
    }
    public function getCreatedAtAttribute()
    {
        $date = convertToDubaiTimezone($this->attributes['created_at']);
        return  $date;
    }
}
