<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{
    Electricity,
    Country
};
use Illuminate\Support\Facades\DB;

class ElectricitySeeder  extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Electricity::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $countryId = Country::where('name', 'United Arab Emirates')->pluck('id');

        $fuelArray = [
            ['electricity_type' => '1', 'activity' => 'Electricity', 'country' => $countryId[0], 'type' => null,'unit' => Electricity::UNIT[0],'factors' => 0.20],
            ['electricity_type' => '2', 'activity' => 'District heat and steam', 'country' => null,'type' => 'District heat and steam', 'unit' => Electricity::UNIT[0],'factors' => 0.17],
            ['electricity_type' => '3', 'activity' => 'District cooling', 'country' => $countryId[0], 'type' => null,'unit' => Electricity::UNIT[1],'factors' => 0.7],
        ];

        Electricity::insert($fuelArray);
    }
}
