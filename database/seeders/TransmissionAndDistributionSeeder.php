<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TransmissionAndDistribution;
use Illuminate\Support\Facades\DB;

class TransmissionAndDistributionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        TransmissionAndDistribution::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $transmissionanddistributionArray = [
            ['activity' => 'T&D- electricity', 'unit' => TransmissionAndDistribution::UNIT[0],'factors' => 0.02005],
            ['activity' => 'Distribution - district heat & steam', 'unit' => TransmissionAndDistribution::UNIT[0],'factors' => 0.02005],
        ];

        TransmissionAndDistribution::insert($transmissionanddistributionArray);
    }
}
