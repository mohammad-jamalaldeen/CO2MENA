<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BusinessTravels;
use Illuminate\Support\Facades\DB;

class BusinessTravelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        BusinessTravels::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $businessTrvelArr = [
            ['row_id'=> '1', 'vehicles'=> 'Bus', 'type' => 'Local bus', 'fuel' => 'Unknown', 'unit' =>'passenger.km', 'factors' => '0.11950'],
            // ['row_id'=> '2', 'vehicles'=> 'Bus', 'type' => 'Local London bus', 'fuel' => 'Unknown', 'unit' =>'passenger.km', 'factors' => '0.07856'],
            ['row_id'=> '3', 'vehicles'=> 'Bus', 'type' => 'Average local bus', 'fuel' => 'Unknown', 'unit' =>'passenger.km', 'factors' => '0.10312'],
            ['row_id'=> '4', 'vehicles'=> 'Bus', 'type' => 'Coach', 'fuel' => 'Unknown', 'unit' =>'passenger.km', 'factors' => '0.02732'],
            ['row_id'=> '5', 'vehicles'=> 'Car', 'type' => 'Small car', 'fuel' => 'Diesel', 'unit' =>'Km', 'factors' => '0.13721'],
            ['row_id'=> '6', 'vehicles'=> 'Car', 'type' => 'Medium car', 'fuel' => 'Diesel', 'unit' =>'Km', 'factors' => '0.16637'],
            ['row_id'=> '7', 'vehicles'=> 'Car', 'type' => 'Large car', 'fuel' => 'Diesel', 'unit' =>'Km', 'factors' => '0.20419'],
            ['row_id'=> '8', 'vehicles'=> 'Car', 'type' => 'Average car', 'fuel' => 'Diesel', 'unit' =>'Km', 'factors' => '0.16844'],
            ['row_id'=> '9', 'vehicles'=> 'Car', 'type' => 'Small car', 'fuel' => 'Petrol', 'unit' =>'Km', 'factors' => '0.14836'],
            ['row_id'=> '10', 'vehicles'=>'Car', 'type' => 'Medium car', 'fuel' => 'Petrol', 'unit' =>'Km', 'factors' => '0.18659'],
            ['row_id'=> '11', 'vehicles'=>'Car', 'type' => 'Large car', 'fuel' => 'Petrol', 'unit' =>'Km', 'factors' => '0.27807'],
            ['row_id'=> '12', 'vehicles'=>'Car', 'type' => 'Average car', 'fuel' => 'Petrol', 'unit' =>'Km', 'factors' => '0.17430'],
            ['row_id'=> '13', 'vehicles'=>'Car', 'type' => 'Small car', 'fuel' => 'Hybrid', 'unit' =>'Km', 'factors' => '0.10275'],
            ['row_id'=> '14', 'vehicles'=>'Car', 'type' => 'Medium car', 'fuel' => 'Hybrid', 'unit' =>'Km', 'factors' => '0.10698'],
            ['row_id'=> '15', 'vehicles'=>'Car', 'type' => 'Large car', 'fuel' => 'Hybrid', 'unit' =>'Km', 'factors' => '0.14480'],
            ['row_id'=> '16', 'vehicles'=>'Car', 'type' => 'Average car', 'fuel' => 'Hybrid', 'unit' =>'Km', 'factors' => '0.11558'],
            ['row_id'=> '17', 'vehicles'=>'Car', 'type' => 'Medium car', 'fuel' => 'CNG', 'unit' =>'Km', 'factors' => '0.15935'],
            ['row_id'=> '18', 'vehicles'=>'Car', 'type' => 'Large car', 'fuel' => 'CNG', 'unit' =>'Km', 'factors' => '0.23680'],
            ['row_id'=> '19', 'vehicles'=>'Car', 'type' => 'Average car', 'fuel' => 'CNG', 'unit' =>'Km', 'factors' => '0.17621'],
            ['row_id'=> '20','vehicles'=> 'Car', 'type' => 'Medium car', 'fuel' => 'LPG', 'unit' =>'Km', 'factors' => '0.17847'],
            ['row_id'=> '21', 'vehicles'=>'Car', 'type' => 'Large car', 'fuel' => 'LPG', 'unit' =>'Km', 'factors' => '0.26606'],
            ['row_id'=> '22', 'vehicles'=>'Car', 'type' => 'Average car', 'fuel' => 'LPG', 'unit' =>'Km', 'factors' => '0.19754'],
            ['row_id'=> '23', 'vehicles'=>'Car', 'type' => 'Small car', 'fuel' => 'Unknown', 'unit' =>'Km', 'factors' => '0.14449'],
            ['row_id'=> '24', 'vehicles'=>'Car', 'type' => 'Medium car', 'fuel' => 'Unknown', 'unit' =>'Km', 'factors' => '0.17571'],
            ['row_id'=> '25', 'vehicles'=>'Car', 'type' => 'Large car', 'fuel' => 'Unknown', 'unit' =>'Km', 'factors' => '0.22321'],
            ['row_id'=> '26', 'vehicles'=>'Car', 'type' => 'Average car', 'fuel' => 'Unknown', 'unit' =>'Km', 'factors' => '0.17140'],
            ['row_id'=> '27', 'vehicles'=>'Car', 'type' => 'Small car', 'fuel' => 'Plug-in Hybrid Electric', 'unit' =>'Km', 'factors' => '0.05860'],
            ['row_id'=> '28', 'vehicles'=>'Car', 'type' => 'Medium car', 'fuel' => 'Plug-in Hybrid Electric', 'unit' =>'Km', 'factors' => '0.09251'],
            ['row_id'=> '29', 'vehicles'=>'Car', 'type' => 'Large car', 'fuel' => 'Plug-in Hybrid Electric', 'unit' =>'Km', 'factors' => '0.10515'],
            ['row_id'=> '30', 'vehicles'=>'Car', 'type' => 'Aveage car', 'fuel' => 'Plug-in Hybrid Electric', 'unit' =>'Km', 'factors' => '0.09712'],
            ['row_id'=> '31', 'vehicles'=>'Car', 'type' => 'Small car', 'fuel' => 'Battery Electric', 'unit' =>'Km', 'factors' => '0.04637'],
            ['row_id'=> '32', 'vehicles'=>'Car', 'type' => 'Medium car', 'fuel' => 'Battery Electric', 'unit' =>'Km', 'factors' => '0.05563'],
            ['row_id'=> '33', 'vehicles'=>'Car', 'type' => 'Large car', 'fuel' => 'Battery Electric', 'unit' =>'Km', 'factors' => '0.06646'],
            ['row_id'=> '34', 'vehicles'=>'Car', 'type' => 'Average car', 'fuel' => 'Battery Electric', 'unit' =>'Km', 'factors' => '0.05728'],
            ['row_id'=> '35', 'vehicles'=>'Ferry', 'type' => 'Foot passenger', 'fuel' => 'Foot passenger', 'unit' =>'passenger.km', 'factors' => '0.01874'],
            ['row_id'=> '36', 'vehicles'=>'Ferry', 'type' => 'Car passenger', 'fuel' => 'Car passenger', 'unit' =>'passenger.km', 'factors' => '0.12952'],
            ['row_id'=> '37', 'vehicles'=>'Ferry', 'type' => 'Average passenger', 'fuel' => 'Average passenger', 'unit' =>'passenger.km', 'factors' => '0.11286'],
            ['row_id'=> '38', 'vehicles'=>'Motorbike', 'type' => 'Small ', 'fuel' => 'Unknown', 'unit' =>'Km', 'factors' => '0.08277'],
            ['row_id'=> '39', 'vehicles'=>'Motorbike', 'type' => 'Medium ', 'fuel' => 'Unknown', 'unit' =>'Km', 'factors' => '0.10086'],
            ['row_id'=> '40', 'vehicles'=>'Motorbike', 'type' => 'Large ', 'fuel' => 'Unknown', 'unit' =>'Km', 'factors' => '0.13237'],
            ['row_id'=> '41', 'vehicles'=>'Motorbike', 'type' => 'Average', 'fuel' => 'Unknown', 'unit' =>'Km', 'factors' => '0.11337'],
            ['row_id'=> '42', 'vehicles'=>'Rail', 'type' => 'National rail', 'fuel' => 'Unknown', 'unit' =>'passenger.km', 'factors' => '0.03694'],
            ['row_id'=> '43', 'vehicles'=>'Rail', 'type' => 'International rail', 'fuel' => 'Unknown', 'unit' =>'passenger.km', 'factors' => '0.00497'],
            ['row_id'=> '44', 'vehicles'=>'Rail', 'type' => 'Light rail and and term ', 'fuel' => 'Unknown', 'unit' =>'passenger.km', 'factors' => '0.02991'],
            ['row_id'=> '45', 'vehicles'=>'Rail', 'type' => 'London underground', 'fuel' => 'Unknown', 'unit' =>'passenger.km', 'factors' => '0.02750'],
            ['row_id'=> '46', 'vehicles'=>'Taxi', 'type' => 'Regular', 'fuel' => 'Unknown', 'unit' =>'passenger.km', 'factors' => '0.20369'],
            ['row_id'=> '47', 'vehicles'=>'Taxi', 'type' => 'Black cab', 'fuel' => 'Unknown', 'unit' =>'passenger.km', 'factors' => '0.31191'],
        ];

        BusinessTravels::insert($businessTrvelArr);
    }
}
