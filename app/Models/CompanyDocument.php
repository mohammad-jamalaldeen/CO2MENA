<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class CompanyDocument extends Model
{
    use HasFactory, SoftDeletes;
    const TRADE_LICENSE = 'Trade License';
    const ESTABLISHMENT = 'Establishment';
    public function getFileNameAttribute()
    {
        if(!empty($this->attributes['file_name'])  && Storage::disk('company_user')->exists($this->attributes['file_name'])){
            $imgpath = Storage::disk('company_user')->url($this->attributes['file_name']);
        }else{
            $imgpath = asset('assets/images/No_image_available.png');
        }
        return $imgpath;
    }
}
