<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $userArray = [
            [
                "user_role_id" => 1,
                "name" => "ankit kaviaya",
                "username"=> "akitkavaiya",
                "email" => "suparadmin@yopmail.com",
                "contact_number" => "919824922258",
                "otp" => rand(111111,999999),
                "password" => bcrypt('Admin@123'),
                "status" => "1",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" =>date('Y-m-d H:i:s')
            ]
        ];

        User::insert($userArray);
    }
}
