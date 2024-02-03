<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Watersupplytreatment;
use Illuminate\Support\Facades\DB;

class WatersupplytreatmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Watersupplytreatment::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $watersupplytreatmentArray = [
            ['type' => 'Water Supply', 'unit' => Watersupplytreatment::UNIT[0],'factors' => 0.34400],
            ['type' => 'Water Treatment', 'unit' => Watersupplytreatment::UNIT[0],'factors' => 0.70800],
        ];

        Watersupplytreatment::insert($watersupplytreatmentArray);
    }
}
