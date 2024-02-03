<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyAdminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Permission::where('user_role_id', 6)->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $permissionArr = [
            [
                'module_id'=>"1",
                'action'=>"download",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'6',
            ],
            [
                'module_id'=>"1",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'6',
            ],

            [
                'module_id'=>"2",
                'action'=>"create",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'6',
            ],
            [
                'module_id'=>"2",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'6',
            ],
            [
                'module_id'=>"2",
                'action'=>"show",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'6',
            ],
            [
                'module_id'=>"2",
                'action'=>"edit",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'6',
            ],
            [
                'module_id'=>"2",
                'action'=>"delete",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'6',
            ],

            [
                'module_id'=>"3",
                'action'=>"create",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'6',
            ],
            [
                'module_id'=>"3",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'6',
            ],
            [
                'module_id'=>"3",
                'action'=>"show",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'6',
            ],
            [
                'module_id'=>"3",
                'action'=>"edit",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'6',
            ],
            [
                'module_id'=>"3",
                'action'=>"delete",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'6',
            ],

            [
                'module_id'=>"4",
                'action'=>"create",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'6',
            ],
            [
                'module_id'=>"4",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'6',
            ],
            [
                'module_id'=>"4",
                'action'=>"show",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'6',
            ],
            [
                'module_id'=>"4",
                'action'=>"edit",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'6',
            ],
            [
                'module_id'=>"4",
                'action'=>"delete",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'6',
            ],


            [
                'module_id'=>"5",
                'action'=>"create",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'6',
            ],
            [
                'module_id'=>"5",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'6',
            ],

            [
                'module_id'=>"13",
                'action'=>"edit",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'6',
            ],
        ];
        Permission::insert($permissionArr);
    }
}
