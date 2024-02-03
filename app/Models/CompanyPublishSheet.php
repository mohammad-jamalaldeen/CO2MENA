<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyPublishSheet extends Model
{
    use HasFactory;

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function datasheets()
    {
        return $this->hasOne(Datasheet::class,'id','datasheet_id');
    }
}
