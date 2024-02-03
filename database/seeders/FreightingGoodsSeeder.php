<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FreightingGoodsVansHgvs;
use App\Models\FreightingGoodsFlights;
use App\Models\FreightingGoodsFlightsRails;
use Illuminate\Support\Facades\DB;

class FreightingGoodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        FreightingGoodsVansHgvs::truncate();
        FreightingGoodsFlightsRails::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $goodVansHGVS = [
            ['vehicle' => "Vans", 'type' => "Class I (up to 1.305 t)", 'fuel' => "Diesel", 'factors' => '0.15'],
            ['vehicle' => "Vans", 'type' => "Class II (1.305 to 1.74 t)", 'fuel' => "Diesel", 'factors' => '0.19'],
            ['vehicle' => "Vans", 'type' => "Class III (1.74 to 3.5 t)", 'fuel' => "Diesel", 'factors' => '0.27'],
            ['vehicle' => "Vans", 'type' => "Average (up to 3.5 t)", 'fuel' => "Diesel", 'factors' => '0.25'],
            ['vehicle' => "Vans", 'type' => "Class I (up to 1.305 t)", 'fuel' => "Petrol", 'factors' => '0.21'],
            ['vehicle' => "Vans", 'type' => "Class II (1.305 to 1.74 t)", 'fuel' => "Petrol", 'factors' => '0.21'],
            ['vehicle' => "Vans", 'type' => "Class III (1.74 to 3.5 t)", 'fuel' => "Petrol", 'factors' => '0.33'],
            ['vehicle' => "Vans", 'type' => "Average (up to 3.5 t)", 'fuel' => "Petrol", 'factors' => '0.22'],
            ['vehicle' => "Vans", 'type' => "Average (up to 3.5 t)", 'fuel' => "CNG", 'factors' => '0.25'],
            ['vehicle' => "Vans", 'type' => "Average (up to 3.5 t)", 'fuel' => "LPG", 'factors' => '0.27'],
            ['vehicle' => "Vans", 'type' => "Average (up to 3.5 t)", 'fuel' => "Unknown", 'factors' => '0.25'],
            ['vehicle' => "Vans", 'type' => "Class I (up to 1.305 t)", 'fuel' => "Battery Electric", 'factors' => '0.04'],
            ['vehicle' => "Vans", 'type' => "Class II (1.305 to 1.74 t)", 'fuel' => "Battery Electric", 'factors' => '0.06'],
            ['vehicle' => "Vans", 'type' => "Class III (1.74 to 3.5 t)", 'fuel' => "Battery Electric", 'factors' => '0.08'],
            ['vehicle' => "Vans", 'type' => "Average (up to 3.5 t)", 'fuel' => "Battery Electric", 'factors' => '0.06'],
            ['vehicle' => "HGV", 'type' => "Rigid (>3.5-7.5 t)", 'fuel' => "Diesel", 'factors' => '0.48'],
            ['vehicle' => "HGV", 'type' => "Rigid (>7.5 t-17 t)", 'fuel' => "Diesel", 'factors' => '0.59'],
            ['vehicle' => "HGV", 'type' => "Rigid (>17 t)", 'fuel' => "Diesel", 'factors' => '0.96'],
            ['vehicle' => "HGV", 'type' => "All rigids", 'fuel' => "Diesel", 'factors' => '0.80'],
            ['vehicle' => "HGV", 'type' => "Articulated (>3.5 - 33t)", 'fuel' => "Diesel", 'factors' => '0.78'],
            ['vehicle' => "HGV", 'type' => "Articulated (>33t)", 'fuel' => "Diesel", 'factors' => '0.92'],
            ['vehicle' => "HGV", 'type' => "All artics", 'fuel' => "Diesel", 'factors' => '0.92'],
            ['vehicle' => "HGV", 'type' => "All HGVs", 'fuel' => "Diesel", 'factors' => '0.87'],
            ['vehicle' => "HGV refrigerated", 'type' => "Rigid (>3.5-7.5 t)", 'fuel' => "Diesel", 'factors' => '0.57'],
            ['vehicle' => "HGV refrigerated", 'type' => "Rigid (>7.5 t-17 t)", 'fuel' => "Diesel", 'factors' => '0.70'],
            ['vehicle' => "HGV refrigerated", 'type' => "Rigid (>17 t)", 'fuel' => "Diesel", 'factors' => '1.15'],
            ['vehicle' => "HGV refrigerated", 'type' => "All rigids", 'fuel' => "Diesel", 'factors' => '0.95'],
            ['vehicle' => "HGV refrigerated", 'type' => "Articulated (>3.5 - 33t)", 'fuel' => "Diesel", 'factors' => '0.90'],
            ['vehicle' => "HGV refrigerated", 'type' => "Articulated (>33t)", 'fuel' => "Diesel", 'factors' => '1.07'],
            ['vehicle' => "HGV refrigerated", 'type' => "All artics", 'fuel' => "Diesel", 'factors' => '1.06'],
            ['vehicle' => "HGV refrigerated", 'type' => "All HGVs", 'fuel' => "Diesel", 'factors' => '1.01'],

        ];
        FreightingGoodsVansHgvs::insert($goodVansHGVS);


        $goodsFlights = [
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[0], 'type' => 'Domestic', 'unit' => 'tonne.km', 'factors' => '2.52'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[0], 'type' => 'Short-haul', 'unit' => 'tonne.km', 'factors' => '1.17'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[0], 'type' => 'Long-haul', 'unit' => 'tonne.km', 'factors' => '0.60'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[0], 'type' => 'International', 'unit' => 'tonne.km', 'factors' => '0.60'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[1], 'type' => 'Freight train', 'unit' => 'tonne.km', 'factors' => '0.03'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[2], 'type' => 'Crude tanker; 200,000+ dwt', 'unit' => 'tonne.km', 'factors' => '0.00'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[2], 'type' => 'Crude tanker; 120,000-199,999 dwt', 'unit' => 'tonne.km', 'factors' => '0.00'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[2], 'type' => 'Crude tanker; 80,000-119,999 dwt', 'unit' => 'tonne.km', 'factors' => '0.01'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[2], 'type' => 'Crude tanker; 60,000-79,999 dwt', 'unit' => 'tonne.km', 'factors' => '0.01'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[2], 'type' => 'Crude tanker; 10,000-59,999 dwt', 'unit' => 'tonne.km', 'factors' => '0.01'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[2], 'type' => 'Crude tanker; 0-9999 dwt', 'unit' => 'tonne.km', 'factors' => '0.03'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[2], 'type' => 'Crude tanker; Average', 'unit' => 'tonne.km', 'factors' => '0.00'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[2], 'type' => 'Products tanker; 60,000+ dwt', 'unit' => 'tonne.km', 'factors' => '0.01'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[2], 'type' => 'Products tanker; 20,000-59,999 dwt', 'unit' => 'tonne.km', 'factors' => '0.01'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[2], 'type' => 'Products tanker; 10,000-19,999 dwt', 'unit' => 'tonne.km', 'factors' => '0.02'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[2], 'type' => 'Products tanker; 5000-9999 dwt', 'unit' => 'tonne.km', 'factors' => '0.03'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[2], 'type' => 'Products tanker; 0-4999 dwt', 'unit' => 'tonne.km', 'factors' => '0.05'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[2], 'type' => 'Products tanker; Average', 'unit' => 'tonne.km', 'factors' => '0.01'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[2], 'type' => 'Chemical tanker; 20,000+ dwt', 'unit' => 'tonne.km', 'factors' => '0.01'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[2], 'type' => 'Chemical tanker; 10,000-19,999 dwt', 'unit' => 'tonne.km', 'factors' => '0.01'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[2], 'type' => 'Chemical tanker; 5000-9999 dwt', 'unit' => 'tonne.km', 'factors' => '0.02'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[2], 'type' => 'Chemical tanker; 0-4999 dwt', 'unit' => 'tonne.km', 'factors' => '0.02'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[2], 'type' => 'Chemical tanker; Average', 'unit' => 'tonne.km', 'factors' => '0.01'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[2], 'type' => 'LNG tanker; 200,000+ m3', 'unit' => 'tonne.km', 'factors' => '0.01'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[2], 'type' => 'LNG tanker; 0-199,999 m3', 'unit' => 'tonne.km', 'factors' => '0.01'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[2], 'type' => 'LNG tanker; Average', 'unit' => 'tonne.km', 'factors' => '0.01'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[2], 'type' => 'LPG Tanker; 50,000+ m3', 'unit' => 'tonne.km', 'factors' => '0.01'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[2], 'type' => 'LPG Tanker; 0-49,999 m3', 'unit' => 'tonne.km', 'factors' => '0.04'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[2], 'type' => 'LPG Tanker; Average', 'unit' => 'tonne.km', 'factors' => '0.01'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[3], 'type' => 'Bulk carrier; 200,000+ dwt', 'unit' => 'tonne.km', 'factors' => '0.00'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[3], 'type' => 'Bulk carrier; 100,000-199,999 dwt', 'unit' => 'tonne.km', 'factors' => '0.00'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[3], 'type' => 'Bulk carrier; 60,000-99,999 dwt', 'unit' => 'tonne.km', 'factors' => '0.00'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[3], 'type' => 'Bulk carrier; 35,000-59,999 dwt', 'unit' => 'tonne.km', 'factors' => '0.01'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[3], 'type' => 'Bulk carrier; 10,000-34,999 dwt', 'unit' => 'tonne.km', 'factors' => '0.01'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[3], 'type' => 'Bulk carrier; 0-9999 dwt', 'unit' => 'tonne.km', 'factors' => '0.03'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[3], 'type' => 'Bulk carrier; Average', 'unit' => 'tonne.km', 'factors' => '0.00'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[3], 'type' => 'General cargo; 10,000+ dwt', 'unit' => 'tonne.km', 'factors' => '0.01'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[3], 'type' => 'General cargo; 5000-9999 dwt', 'unit' => 'tonne.km', 'factors' => '0.02'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[3], 'type' => 'General cargo; 0-4999 dwt', 'unit' => 'tonne.km', 'factors' => '0.01'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[3], 'type' => 'General cargo; 10,000+ dwt 100+ TEU', 'unit' => 'tonne.km', 'factors' => '0.01'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[3], 'type' => 'General cargo; 5000-9999 dwt 100+ TEU', 'unit' => 'tonne.km', 'factors' => '0.02'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[3], 'type' => 'General cargo; 0-4999 dwt 100+ TEU', 'unit' => 'tonne.km', 'factors' => '0.02'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[3], 'type' => 'General cargo; Average', 'unit' => 'tonne.km', 'factors' => '0.01'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[3], 'type' => 'Container ship; 8000+ TEU', 'unit' => 'tonne.km', 'factors' => '0.01'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[3], 'type' => 'Container ship; 5000-7999 TEU', 'unit' => 'tonne.km', 'factors' => '0.02'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[3], 'type' => 'Container ship; 3000-4999 TEU', 'unit' => 'tonne.km', 'factors' => '0.02'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[3], 'type' => 'Container ship; 2000-2999 TEU', 'unit' => 'tonne.km', 'factors' => '0.02'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[3], 'type' => 'Container ship; 1000-1999 TEU', 'unit' => 'tonne.km', 'factors' => '0.03'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[3], 'type' => 'Container ship; 0-999 TEU', 'unit' => 'tonne.km', 'factors' => '0.04'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[3], 'type' => 'Container ship; Average', 'unit' => 'tonne.km', 'factors' => '0.02'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[3], 'type' => 'Vehicle transport; 4000+ CEU', 'unit' => 'tonne.km', 'factors' => '0.03'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[3], 'type' => 'Vehicle transport; 0-3999 CEU ', 'unit' => 'tonne.km', 'factors' => '0.06'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[3], 'type' => 'Vehicle transport; Average', 'unit' => 'tonne.km', 'factors' => '0.04'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[3], 'type' => 'RoRo-Ferry; 2000+ LM', 'unit' => 'tonne.km', 'factors' => '0.05'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[3], 'type' => 'RoRo-Ferry; 0-1999 LM', 'unit' => 'tonne.km', 'factors' => '0.06'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[3], 'type' => 'RoRo-Ferry; Average', 'unit' => 'tonne.km', 'factors' => '0.05'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[3], 'type' => 'Large RoPax ferry; Average', 'unit' => 'tonne.km', 'factors' => '0.38'],
            ['vehicle' =>FreightingGoodsFlightsRails::VEHICLE[3], 'type' => 'Refrigerated cargo; All dwt', 'unit' => 'tonne.km', 'factors' => '0.01'],
        ];
        FreightingGoodsFlightsRails::insert($goodsFlights);
    }
}
