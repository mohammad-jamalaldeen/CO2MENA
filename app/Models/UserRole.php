<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{
    Model,
    SoftDeletes
};

class UserRole extends Model
{
    use HasFactory, SoftDeletes;

    const BACKEND = 'Backend';
    const FRONTEND = 'Frontend';    
}
