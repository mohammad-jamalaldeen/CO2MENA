<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    use HasFactory, SoftDeletes;

    public function permissions(): HasMany
    {
       return  $this->hasMany(Permission::class, 'module_id', 'id')->select('id', 'module_id', 'user_role_id', 'action');
        // if($userRoleId !== null)
        // {
        //     $query->where('user_role_id', $userRoleId);
        // }

        // return $query;
    }
}
