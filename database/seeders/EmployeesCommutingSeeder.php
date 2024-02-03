<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmployeesCommuting;
use Illuminate\Support\Facades\DB;

class EmployeesCommutingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        EmployeesCommuting::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $EmployeesComArr = [
            ['row_id'=>'1', 'vehicle' => 'Bus', 'type' => 'Local bus', 'fuel' => 'Unknown', 'unit' =>'Passenger.km', 'factors' => '0.11950'],
            // ['row_id'=>'2', 'vehicle' => 'Bus', 'type' => 'Local London bus', 'fuel' => 'Unknown', 'unit' =>'Passenger.km', 'factors' => '0.07856'],
            ['row_id'=>'3', 'vehicle' => 'Bus', 'type' => 'Average local bus', 'fuel' => 'Unknown', 'unit' =>'Passenger.km', 'factors' => '0.10312'],
            ['row_id'=>'4', 'vehicle' => 'Bus', 'type' => 'Coach', 'fuel' => 'Unknown', 'unit' =>'Passenger.km', 'factors' => '0.02732'],
            ['row_id'=>'5', 'vehicle' => 'Car', 'type' => 'Small car', 'fuel' => 'Diesel', 'unit' =>'km', 'factors' => '0.13721'],
            ['row_id'=>'6', 'vehicle' => 'Car', 'type' => 'Medium car', 'fuel' => 'Diesel', 'unit' =>'km', 'factors' => '0.16637'],
            ['row_id'=>'7', 'vehicle' => 'Car', 'type' => 'Large car', 'fuel' => 'Diesel', 'unit' =>'km', 'factors' => '0.20419'],
            ['row_id'=>'8', 'vehicle' => 'Car', 'type' => 'Average car', 'fuel' => 'Diesel', 'unit' =>'km', 'factors' => '0.16844'],
            ['row_id'=>'9', 'vehicle' => 'Car', 'type' => 'Small car', 'fuel' => 'Petrol', 'unit' =>'km', 'factors' => '0.14836'],
            ['row_id'=>'10', 'vehicle' => 'Car', 'type' => 'Medium car', 'fuel' => 'Petrol', 'unit' =>'km', 'factors' => '0.18659'],
            ['row_id'=>'11', 'vehicle' => 'Car', 'type' => 'Large car', 'fuel' => 'Petrol', 'unit' =>'km', 'factors' => '0.27807'],
            ['row_id'=>'12', 'vehicle' => 'Car', 'type' => 'Average car', 'fuel' => 'Petrol', 'unit' =>'km', 'factors' => '0.17430'],
            ['row_id'=>'13', 'vehicle' => 'Car', 'type' => 'Small car', 'fuel' => 'Hybrid', 'unit' =>'km', 'factors' => '0.10275'],
            ['row_id'=>'14', 'vehicle' => 'Car', 'type' => 'Medium car', 'fuel' => 'Hybrid', 'unit' =>'km', 'factors' => '0.10698'],
            ['row_id'=>'15', 'vehicle' => 'Car', 'type' => 'Large car', 'fuel' => 'Hybrid', 'unit' =>'km', 'factors' => '0.14480'],
            ['row_id'=>'16', 'vehicle' => 'Car', 'type' => 'Average car', 'fuel' => 'Hybrid', 'unit' =>'km', 'factors' => '0.11558'],
            ['row_id'=>'17', 'vehicle' => 'Car', 'type' => 'Medium car', 'fuel' => 'CNG', 'unit' =>'km', 'factors' => '0.15935'],
            ['row_id'=>'18', 'vehicle' => 'Car', 'type' => 'Large car', 'fuel' => 'CNG', 'unit' =>'km', 'factors' => '0.23680'],
            ['row_id'=>'19', 'vehicle' => 'Car', 'type' => 'Average car', 'fuel' => 'CNG', 'unit' =>'km', 'factors' => '0.17621'],
            ['row_id'=>'20', 'vehicle' => 'Car', 'type' => 'Medium car', 'fuel' => 'LPG', 'unit' =>'km', 'factors' => '0.17847'],
            ['row_id'=>'21', 'vehicle' => 'Car', 'type' => 'Large car', 'fuel' => 'LPG', 'unit' =>'km', 'factors' => '0.26606'],
            ['row_id'=>'22', 'vehicle' => 'Car', 'type' => 'Average car', 'fuel' => 'LPG', 'unit' =>'km', 'factors' => '0.19754'],
            ['row_id'=>'23', 'vehicle' => 'Car', 'type' => 'Small car', 'fuel' => 'Unknown', 'unit' =>'km', 'factors' => '0.14449'],
            ['row_id'=>'24', 'vehicle' => 'Car', 'type' => 'Medium car', 'fuel' => 'Unknown', 'unit' =>'km', 'factors' => '0.17571'],
            ['row_id'=>'25', 'vehicle' => 'Car', 'type' => 'Large car', 'fuel' => 'Unknown', 'unit' =>'km', 'factors' => '0.22321'],
            ['row_id'=>'26', 'vehicle' => 'Car', 'type' => 'Average car', 'fuel' => 'Unknown', 'unit' =>'km', 'factors' => '0.17140'],
            ['row_id'=>'27', 'vehicle' => 'Car', 'type' => 'Small car', 'fuel' => 'Battery Electric', 'unit' =>'km', 'factors' => '-'],
            ['row_id'=>'28', 'vehicle' => 'Car', 'type' => 'Medium car', 'fuel' => 'Battery Electric', 'unit' =>'km', 'factors' => '-'],
            ['row_id'=>'29', 'vehicle' => 'Car', 'type' => 'Large car', 'fuel' => 'Battery Electric', 'unit' =>'km', 'factors' => '-'],
            ['row_id'=>'30', 'vehicle' => 'Car', 'type' => 'Average car', 'fuel' => 'Battery Electric', 'unit' =>'km', 'factors' => '-'],
            ['row_id'=>'31', 'vehicle' => 'Motorbike', 'type' => 'Small ', 'fuel' => 'Unknown', 'unit' =>'km', 'factors' => '0.08277'],
            ['row_id'=>'32', 'vehicle' => 'Motorbike', 'type' => 'Medium ', 'fuel' => 'Unknown', 'unit' =>'km', 'factors' => '0.10086'],
            ['row_id'=>'33', 'vehicle' => 'Motorbike', 'type' => 'Large ', 'fuel' => 'Unknown', 'unit' =>'km', 'factors' => '0.13237'],
            ['row_id'=>'34', 'vehicle' => 'Motorbike', 'type' => 'Average', 'fuel' => 'Unknown', 'unit' =>'km', 'factors' => '0.11337'],
            ['row_id'=>'35', 'vehicle' => 'Rail', 'type' => 'National rail', 'fuel' => 'Unknown', 'unit' =>'Passenger.km', 'factors' => '0.03694'],
            ['row_id'=>'36', 'vehicle' => 'Rail', 'type' => 'international rail', 'fuel' => 'Unknown', 'unit' =>'Passenger.km', 'factors' => '0.00497'],
            ['row_id'=>'37', 'vehicle' => 'Rail', 'type' => 'Light rail and tram', 'fuel' => 'Unknown', 'unit' =>'Passenger.km', 'factors' => '0.02991'],
            ['row_id'=>'38', 'vehicle' => 'Rail', 'type' => 'London underground', 'fuel' => 'Unknown', 'unit' =>'Passenger.km', 'factors' => '0.02750'],
            ['row_id'=>'39', 'vehicle' => 'Taxi', 'type' => 'Regular', 'fuel' => 'Unknown', 'unit' =>'Passenger.km', 'factors' => '0.20369'],
            ['row_id'=>'40', 'vehicle' => 'Taxi', 'type' => 'Black cab', 'fuel' => 'Unknown', 'unit' =>'Passenger.km', 'factors' => '0.31191'],
            ['row_id'=>'41', 'vehicle' => 'Car', 'type' => 'Small car', 'fuel' => 'Plug-in Hybrid Electric*', 'unit' =>'km', 'factors' => '-'],
            ['row_id'=>'42', 'vehicle' => 'Car', 'type' => 'Medium car', 'fuel' => 'Plug-in Hybrid Electric*', 'unit' =>'km', 'factors' => '-'],
            ['row_id'=>'43', 'vehicle' => 'Car', 'type' => 'Large car', 'fuel' => 'Plug-in Hybrid Electric*', 'unit' =>'km', 'factors' => '-'],
            ['row_id'=>'44', 'vehicle' => 'Car', 'type' => 'Average car', 'fuel' => 'Plug-in Hybrid Electric*', 'unit' =>'km', 'factors' => '-'],
            ['row_id'=>'45', 'vehicle' => 'Car', 'type' => 'Small car', 'fuel' => 'Plug-in Hybrid Electric (Petrol)*', 'unit' =>'km', 'factors' => '0.02235'],
            ['row_id'=>'46', 'vehicle' => 'Car', 'type' => 'Medium car', 'fuel' => 'Plug-in Hybrid Electric (Petrol)*', 'unit' =>'km', 'factors' => '0.07012'],
            ['row_id'=>'47', 'vehicle' => 'Car', 'type' => 'Large car', 'fuel' => 'Plug-in Hybrid Electric(Petrol)*', 'unit' =>'km', 'factors' => '0.07570'],
            ['row_id'=>'48', 'vehicle' => 'Car', 'type' => 'Average car', 'fuel' => 'Plug-in Hybrid Electric (Petrol)*', 'unit' =>'km', 'factors' => '0.06995'],
        ];
        EmployeesCommuting::insert($EmployeesComArr);
    }
}
