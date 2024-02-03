<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MaterialUse;
use Illuminate\Support\Facades\DB;

class MaterialUseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        MaterialUse::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $materialuseArray = [
            ['activity' => MaterialUse::ACTIVITY[0], 'waste_type' => 'Aggregates','factors' =>  7.77],
            ['activity' => MaterialUse::ACTIVITY[0], 'waste_type' => 'Average construction', 'factors' => "79.27"],
            ['activity' => MaterialUse::ACTIVITY[0], 'waste_type' => 'Asbestos', 'factors' => "27.00"],
            ['activity' => MaterialUse::ACTIVITY[0], 'waste_type' => 'Asphalt', 'factors' => "39.21"],
            ['activity' => MaterialUse::ACTIVITY[0], 'waste_type' => 'Bricks', 'factors' => "241.77"],
            ['activity' => MaterialUse::ACTIVITY[0], 'waste_type' => 'Concrete', 'factors' => "131.77"],
            ['activity' => MaterialUse::ACTIVITY[0], 'waste_type' => 'Insulation', 'factors' => "1,861.77"],
            ['activity' => MaterialUse::ACTIVITY[0], 'waste_type' => 'Metals', 'factors' => "3,894.22"],
            ['activity' => MaterialUse::ACTIVITY[0], 'waste_type' => 'Mineral oil', 'factors' => "1,401.00"],
            ['activity' => MaterialUse::ACTIVITY[0], 'waste_type' => 'Plasterboard', 'factors' => "120.05"],
            ['activity' => MaterialUse::ACTIVITY[0], 'waste_type' => 'Tyres', 'factors' => "3,335.57"],
            ['activity' => MaterialUse::ACTIVITY[0], 'waste_type' => 'Wood ', 'factors' => "312.60"],
            ['activity' => MaterialUse::ACTIVITY[1], 'waste_type' => 'Glass', 'factors' => "843.00"],
            ['activity' => MaterialUse::ACTIVITY[1], 'waste_type' => 'Clothing', 'factors' => "22,310.00"],
            ['activity' => MaterialUse::ACTIVITY[1], 'waste_type' => 'Food and drink', 'factors' => "3,701.40"],
            ['activity' => MaterialUse::ACTIVITY[2], 'waste_type' => 'Compost derived from garden waste', 'factors' => "113.31"],
            ['activity' => MaterialUse::ACTIVITY[2], 'waste_type' => 'Compost derived from food and garden waste', 'factors' => "116.13"],
            ['activity' => MaterialUse::ACTIVITY[3], 'waste_type' => 'WEEE-fridges and freezers', 'factors' => "3,814.37"],
            ['activity' => MaterialUse::ACTIVITY[3], 'waste_type' => 'WEEE - large', 'factors' => "537.24"],
            ['activity' => MaterialUse::ACTIVITY[3], 'waste_type' => 'WEEE - mixed', 'factors' => "1,148.42"],
            ['activity' => MaterialUse::ACTIVITY[3], 'waste_type' => 'WEEE - small', 'factors' => "1,759.60"],
            ['activity' => MaterialUse::ACTIVITY[3], 'waste_type' => 'Batteries', 'factors' => "12,119.21"],
            ['activity' => MaterialUse::ACTIVITY[4], 'waste_type' => 'Metal: aluminium cans and foil (excl. forming)', 'factors' => "9,122.64"],
            ['activity' => MaterialUse::ACTIVITY[4], 'waste_type' => 'Metal: mixed cans', 'factors' => "5,204.56"],
            ['activity' => MaterialUse::ACTIVITY[4], 'waste_type' => 'Metal: scrap metal', 'factors' => "3,567.60"],
            ['activity' => MaterialUse::ACTIVITY[4], 'waste_type' => 'Metal: steel cans', 'factors' => "3,000.64"],
            ['activity' => MaterialUse::ACTIVITY[5], 'waste_type' => 'Plastics: average plastics', 'factors' => "3,116.29"],
            ['activity' => MaterialUse::ACTIVITY[5], 'waste_type' => 'Plastics: average plastic film ', 'factors' => "2,574.16"],
            ['activity' => MaterialUse::ACTIVITY[5], 'waste_type' => 'Plastics: average plastic rigid', 'factors' => "3,276.71"],
            ['activity' => MaterialUse::ACTIVITY[5], 'waste_type' => 'Plastics: HDPE (incl. forming)', 'factors' => "3,269.84"],
            ['activity' => MaterialUse::ACTIVITY[5], 'waste_type' => 'Plastics: LDPE and LLDPE (incl. forming)', 'factors' => "2,600.64"],
            ['activity' => MaterialUse::ACTIVITY[5], 'waste_type' => 'Plastics: PET (incl. forming)', 'factors' => "4,032.39"],
            ['activity' => MaterialUse::ACTIVITY[5], 'waste_type' => 'Plastics: PP (incl. forming)', 'factors' => "3,104.73"],
            ['activity' => MaterialUse::ACTIVITY[5], 'waste_type' => 'Plastics: PS (incl. forming)', 'factors' => "3,777.95"],
            ['activity' => MaterialUse::ACTIVITY[5], 'waste_type' => 'Plastics: PVC (incl. forming)', 'factors' => "3,413.08"],
            ['activity' => MaterialUse::ACTIVITY[6], 'waste_type' => 'Paper and board: board', 'factors' => "750.26"],
            ['activity' => MaterialUse::ACTIVITY[6], 'waste_type' => 'Paper and board: mixed', 'factors' => "853.57"],
            ['activity' => MaterialUse::ACTIVITY[6], 'waste_type' => 'Paper and board: paper', 'factors' => "919.40"],
        ];

 
        MaterialUse::insert($materialuseArray);
    }
}
