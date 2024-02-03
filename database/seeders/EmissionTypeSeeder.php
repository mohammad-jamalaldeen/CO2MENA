<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Activity;

class EmissionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Activity::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $scoperArr = [
            [
                'user_id'=>'1',
                'name'=>'Fuels',
                'no'=>'12345678',
                'last_updated_by'=>'1',
                'ip_address'=>'203.109.113.178',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ],
            [
                'user_id'=>'1',
                'name'=>'Refrigerants',
                'no'=>'12345678',
                'last_updated_by'=>'1',
                'ip_address'=>'203.109.113.178',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ],
            [
                'user_id'=>'1',
                'name'=>'Owned vehicles',
                'no'=>'12345678',
                'last_updated_by'=>'1',
                'ip_address'=>'203.109.113.178',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ],
            [
                'user_id'=>'1',
                'name'=>'Electricity, heat, cooling',
                'no'=>'12345678',
                'last_updated_by'=>'1',
                'ip_address'=>'203.109.113.178',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ],
            [
                'user_id'=>'1',
                'name'=>'WTT-fules',
                'no'=>'12345678',
                'last_updated_by'=>'1',
                'ip_address'=>'203.109.113.178',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ],
            [
                'user_id'=>'1',
                'name'=>'T&D',
                'no'=>'12345678',
                'last_updated_by'=>'1',
                'ip_address'=>'203.109.113.178',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ],
            [
                'user_id'=>'1',
                'name'=>'Water',
                 'no'=>'12345678',
                'last_updated_by'=>'1',
                'ip_address'=>'203.109.113.178',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ],
            [
                'user_id'=>'1',
                'name'=>'Material use',
                 'no'=>'12345678',
                'last_updated_by'=>'1',
                'ip_address'=>'203.109.113.178',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ],
            [
                'user_id'=>'1',
                'name'=>'Waste disposel',
                 'no'=>'12345678',
                'last_updated_by'=>'1',
                'ip_address'=>'203.109.113.178',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ],
            [
                'user_id'=>'1',
                'name'=>'Flight and Accommodation',
                 'no'=>'12345678',
                'last_updated_by'=>'1',
                'ip_address'=>'203.109.113.178',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ],
            [
                'user_id'=>'1',
                'name'=>'Business travel - land and sea',
                 'no'=>'12345678',
                'last_updated_by'=>'1',
                'ip_address'=>'203.109.113.178',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ],
            [
                'user_id'=>'1',
                'name'=>'Freighting goods',
                 'no'=>'12345678',
                'last_updated_by'=>'1',
                'ip_address'=>'203.109.113.178',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ],
            [
                'user_id'=>'1',
                'name'=>'Employees commuting',
                 'no'=>'12345678',
                'last_updated_by'=>'1',
                'ip_address'=>'203.109.113.178',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ],
            [
                'user_id'=>'1',
                'name'=>'Food',
                 'no'=>'12345678',
                'last_updated_by'=>'1',
                'ip_address'=>'203.109.113.178',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ],
            [
                'user_id'=>'1',
                'name'=>'Home Office',
                 'no'=>'12345678',
                'last_updated_by'=>'1',
                'ip_address'=>'203.109.113.178',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ],
            
        ];
        Activity::insert($scoperArr);
    }
}
