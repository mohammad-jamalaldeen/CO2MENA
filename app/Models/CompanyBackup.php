<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class CompanyBackup extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'file',
        'start_date',
        'end_date',
        'status',
        'report_json',
    ];

    const IS_PENDING = '0';
    const IS_PROGRESS = '1';
    const IS_COMPLETE = '2';
    const IS_FAIL = '3';
    public function company()
    {
        return $this->hasOne(Company::class,'id','company_id');
    }

    public function getCreatedAtAttribute()
    {
        $date = convertToDubaiTimezone($this->attributes['created_at']);
        return  $date;
    }

    public function getFileAttribute()
    {
        if(!empty($this->attributes['file']) && Storage::disk('backup')->exists($this->attributes['file'])){
            $imgpath = Storage::disk('backup')->url($this->attributes['file']);
        }else{
            $imgpath = "";
        }
        return $imgpath;
    }
}
