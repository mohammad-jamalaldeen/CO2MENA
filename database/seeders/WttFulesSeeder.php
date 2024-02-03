<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WttFules;
use Illuminate\Support\Facades\DB;

class WttFulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        WttFules::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $wttfulesArray = [
            ['type' => WttFules::TYPE[0], 'fuel' => 'Compressed Natural Gas', 'unit' => WttFules::UNIT[0], 'factors' => '0.08516'],
            ['type' => WttFules::TYPE[0], 'fuel' => 'Liquefied Natural Gas ', 'unit' => WttFules::UNIT[0], 'factors' => '0.39688'],
            ['type' => WttFules::TYPE[0], 'fuel' => 'Liquefied petroleum gas', 'unit' => WttFules::UNIT[0], 'factors' => '0.19018'],
            ['type' => WttFules::TYPE[0], 'fuel' => 'Natural gas', 'unit' => WttFules::UNIT[1], 'factors' => '0.26299'],
            ['type' => WttFules::TYPE[0], 'fuel' => 'Natural gas (100% mineral blend)', 'unit' => WttFules::UNIT[1], 'factors' => '0.26299'],
            ['type' => WttFules::TYPE[0], 'fuel' => 'Other petroleum gas', 'unit' => WttFules::UNIT[0], 'factors' => '0.11654'],
            ['type' => WttFules::TYPE[1], 'fuel' => 'Aviation spirit', 'unit' => WttFules::UNIT[0], 'factors' => '0.58166'],
            ['type' => WttFules::TYPE[1], 'fuel' => 'Aviation turbine fuel', 'unit' => WttFules::UNIT[0], 'factors' => '0.52644'],
            ['type' => WttFules::TYPE[1], 'fuel' => 'Burning oil', 'unit' => WttFules::UNIT[0], 'factors' => '0.52835'],
            ['type' => WttFules::TYPE[1], 'fuel' => 'Diesel (average biofuel blend)', 'unit' => WttFules::UNIT[0], 'factors' => '0.61015'],
            ['type' => WttFules::TYPE[1], 'fuel' => 'Diesel (100% mineral diesel)', 'unit' => WttFules::UNIT[0], 'factors' => '0.62611'],
            ['type' => WttFules::TYPE[1], 'fuel' => 'Fuel oil', 'unit' => WttFules::UNIT[0], 'factors' => '0.60346'],
            ['type' => WttFules::TYPE[1], 'fuel' => 'Gas oil', 'unit' => WttFules::UNIT[0], 'factors' => '0.63253'],
            ['type' => WttFules::TYPE[1], 'fuel' => 'Petrol (average biofuel blend)', 'unit' => WttFules::UNIT[0], 'factors' => '0.59344'],
            ['type' => WttFules::TYPE[1], 'fuel' => 'Petrol (100% mineral petrol)', 'unit' => WttFules::UNIT[0], 'factors' => '0.59732'],
            ['type' => WttFules::TYPE[1], 'fuel' => 'Processed fuel oils - residual oil', 'unit' => WttFules::UNIT[0], 'factors' => '0.38830'],
            ['type' => WttFules::TYPE[1], 'fuel' => 'Processed fuel oils - distillate oil', 'unit' => WttFules::UNIT[0], 'factors' => '0.33355'],
            ['type' => WttFules::TYPE[1], 'fuel' => 'Marine gas oil', 'unit' => WttFules::UNIT[0], 'factors' => '0.63253'],
            ['type' => WttFules::TYPE[1], 'fuel' => 'Marine fuel oil', 'unit' => WttFules::UNIT[0], 'factors' => '0.60346'],
            ['type' => WttFules::TYPE[2], 'fuel' => 'Coal (industrial)', 'unit' => WttFules::UNIT[2], 'factors' => '383.08926'],
            ['type' => WttFules::TYPE[2], 'fuel' => 'Coal (electricity generation)', 'unit' => WttFules::UNIT[2], 'factors' => '362.02993'],
            ['type' => WttFules::TYPE[2], 'fuel' => 'Coal (domestic)', 'unit' => WttFules::UNIT[2], 'factors' => '431.46914'],
            ['type' => WttFules::TYPE[2], 'fuel' => 'Coking coal', 'unit' => WttFules::UNIT[2], 'factors' => '456.00312'],
            ['type' => WttFules::TYPE[2], 'fuel' => 'Petroleum coke', 'unit' => WttFules::UNIT[2], 'factors' => '414.84679'],
            ['type' => WttFules::TYPE[2], 'fuel' => 'Coal (electricity generation- home produced coal only)', 'unit' => WttFules::UNIT[2], 'factors' => '361.46430'],
        ];

        

        WttFules::insert($wttfulesArray);
    }
}
