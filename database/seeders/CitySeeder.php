<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        City::truncate();
        $cityArr = [
            ['name' => 'Dubai',],
            ['name' => 'Mumbai',],
            ['name' => 'Dehli',],
            ['name' => 'Ahemdabad',],
        ];
        City::insert($cityArr);
    }
}
