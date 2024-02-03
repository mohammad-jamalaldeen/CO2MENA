<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CustomerSupportFile extends Model
{
    use HasFactory;
    
    public function getFileNameAttribute()
    {
        if(!empty($this->attributes['file_name']) && Storage::disk('customer_support')->exists($this->attributes['file_name'])){
            $imgpath = Storage::disk('customer_support')->url($this->attributes['file_name']);
            
        } else{
            $imgpath = asset('assets/images/file-img.png');
        }
        
        return $imgpath;
    }
}
