<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuperAdminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Permission::where('user_role_id', 1)->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $permissionArr = [
            [
                'module_id'=>"6",
                'action'=>"download",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"6",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],

            [
                'module_id'=>"7",
                'action'=>"create",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"7",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"7",
                'action'=>"show",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"7",
                'action'=>"edit",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"7",
                'action'=>"delete",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],

            [
                'module_id'=>"8",
                'action'=>"create",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"8",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"8",
                'action'=>"show",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"8",
                'action'=>"edit",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"8",
                'action'=>"delete",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            
            [
                'module_id'=>"9",
                'action'=>"create",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"9",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"9",
                'action'=>"show",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"9",
                'action'=>"edit",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"9",
                'action'=>"delete",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],

            [
                'module_id'=>"10",
                'action'=>"create",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"10",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"10",
                'action'=>"show",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"10",
                'action'=>"edit",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"10",
                'action'=>"delete",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],

            [
                'module_id'=>"11",
                'action'=>"create",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"11",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"11",
                'action'=>"show",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"11",
                'action'=>"edit",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"11",
                'action'=>"delete",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],

            [
                'module_id'=>"12",
                'action'=>"create",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"12",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"12",
                'action'=>"show",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"12",
                'action'=>"edit",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"12",
                'action'=>"delete",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],


            [
                'module_id'=>"14",
                'action'=>"create",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"14",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"14",
                'action'=>"show",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"14",
                'action'=>"edit",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"14",
                'action'=>"delete",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],

            [
                'module_id'=>"15",
                'action'=>"create",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"15",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"15",
                'action'=>"show",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"15",
                'action'=>"edit",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"15",
                'action'=>"delete",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],

            [
                'module_id'=>"16",
                'action'=>"create",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"16",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"16",
                'action'=>"show",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"16",
                'action'=>"edit",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"16",
                'action'=>"delete",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],


            [
                'module_id'=>"17",
                'action'=>"create",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"17",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"17",
                'action'=>"show",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"17",
                'action'=>"edit",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"17",
                'action'=>"delete",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],

            [
                'module_id'=>"18",
                'action'=>"create",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"18",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"18",
                'action'=>"show",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"18",
                'action'=>"edit",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"18",
                'action'=>"delete",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],

            [
                'module_id'=>"19",
                'action'=>"create",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"19",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"19",
                'action'=>"show",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"19",
                'action'=>"edit",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"19",
                'action'=>"delete",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],


            [
                'module_id'=>"20",
                'action'=>"create",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"20",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"20",
                'action'=>"show",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"20",
                'action'=>"edit",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"20",
                'action'=>"delete",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],

            [
                'module_id'=>"21",
                'action'=>"create",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"21",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"21",
                'action'=>"show",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"21",
                'action'=>"edit",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"21",
                'action'=>"delete",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],


            [
                'module_id'=>"22",
                'action'=>"create",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"22",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"22",
                'action'=>"show",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"22",
                'action'=>"edit",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"22",
                'action'=>"delete",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],

            [
                'module_id'=>"23",
                'action'=>"create",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"23",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"23",
                'action'=>"show",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"23",
                'action'=>"edit",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"23",
                'action'=>"delete",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],

            [
                'module_id'=>"24",
                'action'=>"create",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"24",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"24",
                'action'=>"show",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"24",
                'action'=>"edit",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"24",
                'action'=>"delete",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],

            [
                'module_id'=>"25",
                'action'=>"create",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"25",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"25",
                'action'=>"show",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"25",
                'action'=>"edit",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"25",
                'action'=>"delete",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],

            [
                'module_id'=>"26",
                'action'=>"create",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"26",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"26",
                'action'=>"show",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"26",
                'action'=>"edit",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"26",
                'action'=>"delete",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],

            [
                'module_id'=>"27",
                'action'=>"create",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"27",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"27",
                'action'=>"show",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"27",
                'action'=>"edit",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"27",
                'action'=>"delete",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],

            [
                'module_id'=>"29",
                'action'=>"create",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"29",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"29",
                'action'=>"show",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"29",
                'action'=>"edit",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"29",
                'action'=>"delete",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],

            [
                'module_id'=>"28",
                'action'=>"create",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"28",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"28",
                'action'=>"show",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"28",
                'action'=>"edit",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"28",
                'action'=>"delete",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],

            [
                'module_id'=>"30",
                'action'=>"create",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"30",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"30",
                'action'=>"show",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"30",
                'action'=>"edit",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"30",
                'action'=>"delete",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],

            [
                'module_id'=>"31",
                'action'=>"create",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"31",
                'action'=>"index",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"31",
                'action'=>"show",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"31",
                'action'=>"edit",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],
            [
                'module_id'=>"31",
                'action'=>"delete",
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'user_role_id'=>'1',
                
            ],

        ];

        Permission::insert($permissionArr);
    }
}
