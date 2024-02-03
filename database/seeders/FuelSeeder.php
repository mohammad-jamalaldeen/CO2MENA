<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fuels;
use Illuminate\Support\Facades\DB;

class FuelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Fuels::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $fuelArray = [
            ['type' => Fuels::TYPE[0], 'fuel' => "Compressed Natural Gas", 'unit' => Fuels::UNIT[0], 'factor' => '0.44327'],
            ['type' => Fuels::TYPE[0], 'fuel' => "Liquefied Natural Gas ", 'unit' => Fuels::UNIT[0], 'factor' => '1.15041'],
            ['type' => Fuels::TYPE[0], 'fuel' => "Liquefied petroleum gas", 'unit' => Fuels::UNIT[0], 'factor' => '1.55537'],
            ['type' => Fuels::TYPE[0], 'fuel' => "Natural gas", 'unit' => Fuels::UNIT[1], 'factor' => '2.02266'],
            ['type' => Fuels::TYPE[0], 'fuel' => "Natural gas (100% mineral blend)", 'unit' => Fuels::UNIT[1], 'factor' => '2.03017'],
            ['type' => Fuels::TYPE[0], 'fuel' => "Other petroleum gas", 'unit' => Fuels::UNIT[0], 'factor' => '0.95279'],
            ['type' => Fuels::TYPE[1], 'fuel' => "Aviation spirit", 'unit' => Fuels::UNIT[0], 'factor' => '2.29082'],
            ['type' => Fuels::TYPE[1], 'fuel' => "Aviation turbine fuel", 'unit' => Fuels::UNIT[0], 'factor' => '2.5431'],
            ['type' => Fuels::TYPE[1], 'fuel' => "Burning oil", 'unit' => Fuels::UNIT[0], 'factor' => '2.54039'],
            ['type' => Fuels::TYPE[1], 'fuel' => "Diesel (average biofuel blend)", 'unit' => Fuels::UNIT[0], 'factor' => '2.54603'],
            ['type' => Fuels::TYPE[1], 'fuel' => "Diesel (100% mineral diesel)", 'unit' => Fuels::UNIT[0], 'factor' => '2.68787'],
            ['type' => Fuels::TYPE[1], 'fuel' => "Fuel oil", 'unit' => Fuels::UNIT[0], 'factor' => '3.18317'],
            ['type' => Fuels::TYPE[1], 'fuel' => "Gas oil", 'unit' => Fuels::UNIT[0], 'factor' => '2.75776'],
            ['type' => Fuels::TYPE[1], 'fuel' => "Lubricants", 'unit' => Fuels::UNIT[0], 'factor' => '-'],
            ['type' => Fuels::TYPE[1], 'fuel' => "Naphtha", 'unit' => Fuels::UNIT[0], 'factor' => '-'],
            ['type' => Fuels::TYPE[1], 'fuel' => "Petrol (average biofuel blend)", 'unit' => Fuels::UNIT[0], 'factor' => '2.16802'],
            ['type' => Fuels::TYPE[1], 'fuel' => "Petrol (100% mineral petrol)", 'unit' => Fuels::UNIT[0], 'factor' => '2.31467'],
            ['type' => Fuels::TYPE[1], 'fuel' => "Processed fuel oils - residual oil", 'unit' => Fuels::UNIT[0], 'factor' => '3.18317'],
            ['type' => Fuels::TYPE[1], 'fuel' => "Processed fuel oils - distillate oil", 'unit' => Fuels::UNIT[0], 'factor' => '2.75776'],
            ['type' => Fuels::TYPE[1], 'fuel' => "Refinery miscellaneous", 'unit' => Fuels::UNIT[0], 'factor' => '-'],
            ['type' => Fuels::TYPE[1], 'fuel' => "Waste oils", 'unit' => Fuels::UNIT[0], 'factor' => '-'],
            ['type' => Fuels::TYPE[1], 'fuel' => "Marine gas oil", 'unit' => Fuels::UNIT[0], 'factor' => '2.7754'],
            ['type' => Fuels::TYPE[1], 'fuel' => "Marine fuel oil", 'unit' => Fuels::UNIT[0], 'factor' => '3.12204'],
            ['type' => Fuels::TYPE[2], 'fuel' => "Coal (industrial)", 'unit' => Fuels::UNIT[2], 'factor' => '2,380.01'],
            ['type' => Fuels::TYPE[2], 'fuel' => "Coal (electricity generation)", 'unit' => Fuels::UNIT[2], 'factor' => '2,222.94'],
            ['type' => Fuels::TYPE[2], 'fuel' => "Coal (domestic)", 'unit' => Fuels::UNIT[2], 'factor' => '2,883.26'],
            ['type' => Fuels::TYPE[2], 'fuel' => "Coking coal", 'unit' => Fuels::UNIT[2], 'factor' => '3,222.04'],
            ['type' => Fuels::TYPE[2], 'fuel' => "Petroleum coke", 'unit' => Fuels::UNIT[2], 'factor' => '3,397.79'],
            ['type' => Fuels::TYPE[2], 'fuel' => "Coal (electricity generation - home produced coal only)", 'unit' => Fuels::UNIT[2], 'factor' => '2,219.47'],
        ];

        Fuels::insert($fuelArray);
    }
}
