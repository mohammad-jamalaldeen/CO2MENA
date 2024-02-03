<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    const NO_OF_EMPLOYEE = [
        '1 - 9 Employees',
        '10 - 100 Employees',
        '101 - 500 Employees',
        '500 - 1000 Employees',
        '1000 - 5000 Employees',
        'Above 5000 Employees'
    ];

    const TYPE = [
        '1' => 'Super Admin',
        '2' => 'Sub Admin',
        '3' => 'Customer'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'created_at'  => 'date:Y-m-d',
    ];

    public static function isSuperAdmin()
    {
        $userDetails = Auth::guard('admin')->user();
        if($userDetails)
        {
            $userType = $userDetails->user_role_id;
            if($userType == 1)
                return true;
        }

        return false;
    }
    public static function isSubAdmin()
    {
        $userDetails = Auth::guard('admin')->user();
        if($userDetails)
        {
            $subAdminRoles = UserRole::whereNot('role','Super Admin')->where('type','Backend')->pluck('id')->toArray();
            $userType = $userDetails->user_role_id;
            if(in_array($userType, $subAdminRoles)){
                return true;
            } 
        }
        return false;
    }
    public static function isCompanyAdmin()
    {
        $userDetails = Auth::guard('admin')->user();
        if($userDetails)
        {
            $userType = $userDetails->user_role_id;
            $companyAdmin = UserRole::whereNot('role','Company Admin')->first();
            if($userType == $companyAdmin->id)
                return true;
        }
        return false;
    }
    public static function isStaffAdmin()
    {
        $userDetails = Auth::guard('admin')->user();
        if($userDetails)
        {
            $staffAdminRoles = UserRole::whereNot('role','Company Admin')->where('type','Frontend')->pluck('id')->toArray();
            if(in_array($userDetails->user_role_id, $staffAdminRoles))
                return true;
        }
        return false;
    }

    public function getProfilePictureAttribute()
    {
        if (!empty($this->attributes['profile_picture']) && Storage::disk('admin_user')->exists($this->attributes['profile_picture'])) {
            $imgpath = Storage::disk('admin_user')->url($this->attributes['profile_picture']);
        } elseif (!empty($this->attributes['profile_picture']) && Storage::disk('company_user')->exists($this->attributes['profile_picture'])) {
            $imgpath = Storage::disk('company_user')->url($this->attributes['profile_picture']);
        } else {
            $imgpath = asset('assets/images/No_profile_picture.jpeg');
        }

        return $imgpath;
    }

    public function role()
    {
        return $this->hasOne(UserRole::class,'id','user_role_id');
    }

    public function userRole()
    {
        return $this->hasOne(UserRole::class,'id','user_role_id')->select('id', 'role');
    }

    public static function generateEmpId()
    {
        $countRecord = self::whereNot('user_role_id','1')->count();
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

    public function company()
    {
        return $this->hasOne(Company::class, 'user_id', 'id');
    }
}
