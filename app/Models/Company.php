<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
    User,
    CompanyIndustry,
    CompanyActivity,
    CompanyDocument
};
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id')->whereNull('deleted_at');
    }
    public function industry()
    {
        return $this->hasOne(CompanyIndustry::class, 'id', 'company_industry_id')->select('id', 'name');
    }

    public function companyactivities()
    {
        return $this->hasMany(CompanyActivity::class);
    }
    public function usersubscription()
    {
        return $this->hasOne(UserSubscription::class, 'company_id', 'id')->orderBy('created_at', 'desc')->latest();
    }

    public function companydocuments()
    {
        return $this->hasMany(CompanyDocument::class)->select('id', 'company_id', 'document_type', 'file_name');
    }

    public function companyaddresses()
    {
        return $this->hasMany(CompanyAddress::class)->select('id', 'company_id', 'address', 'city', 'country_id');
    }
    public function companyaddressesone()
    {
        return $this->hasOne(CompanyAddress::class)->select('id', 'company_id', 'address', 'city', 'country_id');
    }
    public function getCompanyLogoAttribute()
    {
        if (!empty($this->attributes['company_logo']) && Storage::disk('company_user')->exists($this->attributes['company_logo'])) {
            $imgpath = Storage::disk('company_user')->url($this->attributes['company_logo']);
        } else {
            $imgpath = asset('assets/images/No_profile_picture.jpeg');
        }
        return $imgpath;
    }

    public function getSampleDatasheetAttribute()
    {
        if (!empty($this->attributes['sample_datasheet']) && Storage::disk('sample_datasheet')->exists($this->attributes['sample_datasheet'])) {
            $imgpath = Storage::disk('sample_datasheet')->url($this->attributes['sample_datasheet']);
        } else {
            $imgpath = '';
        }
        return $imgpath;
    }

    public static function getFileName($url)
    {
        $lastSlashPos = strrpos($url, '/');
        if ($lastSlashPos !== false) {
            $result = substr($url, $lastSlashPos + 1);
            return $result;
        }
    }

    public static function generateCompanyId()
    {
        $countRecord = self::count();
        $lastRecord = self::latest()->first();
        if ($countRecord != 0) {
            $lastId = $countRecord + 1;
            $lastRecord = $lastRecord->id + 1;
            $lastId = $lastRecord . $lastId;
        } else {
            $lastId = 11;
        }
        return 'EMP' . str_pad($lastId, 8, '0', STR_PAD_LEFT);
    }

    public function staffInfo()
    {
        return $this->hasMany(StaffCompany::class, 'company_id', 'id')->whereNull('deleted_at');
    }   
}
