<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\DB;

class UserSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        UserSubscription::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        UserSubscription::insert([
            'user_id' => 3,
            'updated_by' => 1,
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d', strtotime('+30 days')),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
