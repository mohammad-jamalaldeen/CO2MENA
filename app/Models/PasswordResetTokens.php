<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PasswordResetTokens extends Model
{
    public $timestamps = false;
    protected $table = 'password_reset_tokens';
    protected $fillable = ['email', 'token', 'created_at'];
}
