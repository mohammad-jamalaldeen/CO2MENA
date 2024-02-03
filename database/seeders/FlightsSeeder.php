<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Flight;
use Illuminate\Support\Facades\DB;

class FlightsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Flight::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $flightArray = [
            ['origin' => 1, 'destination' => 2,'class' => Flight::CLASS_TYPE[0],'single_way_and_return' => Flight::SINGLE_WAY_RETURN[1],'distance' => 0.34400],
        ];

        Flight::insert($flightArray);
    }
}
