<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Vehicle::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $vehicleArray = [
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Small car", "fuel" => "Diesel", "factors" => "0.13721"],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Medium car", "fuel" => "Diesel", "factors" => "0.16637"],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Large car", "fuel" => "Diesel", "factors" => "0.20419"],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Average car", "fuel" => "Diesel", "factors" => "0.16844"],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Small car", "fuel" => "Petrol", "factors" => "0.14836"],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Medium car", "fuel" => "Petrol", "factors" => "0.18659"],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Large car", "fuel" => "Petrol", "factors" => "0.27807"],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Average car", "fuel" => "Petrol", "factors" => "0.17430"],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Small car", "fuel" => "Hybrid", "factors" => "0.10275"],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Medium car", "fuel" => "Hybrid", "factors" => "0.10698"],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Large car", "fuel" => "Hybrid", "factors" => "0.14480"],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Average car", "fuel" => "Hybrid", "factors" => "0.11558"],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Medium car", "fuel" => "CNG", "factors" => "0.15935"],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Large car", "fuel" => "CNG", "factors" => "0.23680"],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Average car", "fuel" => "CNG", "factors" => "0.17621"],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Medium car", "fuel" => "LPG", "factors" => "0.17847"],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Large car", "fuel" => "LPG", "factors" => "0.26606"],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Average car", "fuel" => "LPG", "factors" => "0.19754"],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Small car", "fuel" => "Unknown", "factors" => "0.14449"],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Medium car", "fuel" => "Unknown", "factors" => "0.17571"],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Large car", "fuel" => "Unknown", "factors" => "0.22321"],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Average car", "fuel" => "Unknown", "factors" => "0.1714"],
            ["vehicle_type" => 1, "vehicle" => "Mororbike", "type" => "Small ", "fuel" => "Petrol", "factors" => "0.08277"],
            ["vehicle_type" => 1, "vehicle" => "Mororbike", "type" => "Medium ", "fuel" => "Petrol", "factors" => "0.10086"],
            ["vehicle_type" => 1, "vehicle" => "Mororbike", "type" => "Large ", "fuel" => "Petrol", "factors" => "0.13237"],
            ["vehicle_type" => 1, "vehicle" => "Mororbike", "type" => "Average ", "fuel" => "Petrol", "factors" => "0.11337"],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Small car", "fuel" => "Battery Electric*", "factors" => ""],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Medium car", "fuel" => "Battery Electric*", "factors" => ""],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Large car", "fuel" => "Battery Electric*", "factors" => ""],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Average car", "fuel" => "Battery Electric*", "factors" => ""],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Small car", "fuel" => "Plug-in Hybrid Electric*", "factors" => ""],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Medium car", "fuel" => "Plug-in Hybrid Electric*", "factors" => ""],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Large car", "fuel" => "Plug-in Hybrid Electric*", "factors" => ""],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Average car", "fuel" => "Plug-in Hybrid Electric*", "factors" => ""],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Small car", "fuel" => "Plug-in Hybrid Electric (Petrol)", "factors" => "0.02235"],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Medium car", "fuel" => "Plug-in Hybrid Electric (Petrol)", "factors" => "0.07012"],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Large car", "fuel" => "Plug-in Hybrid Electric (Petrol)", "factors" => "0.07570"],
            ["vehicle_type" => 1, "vehicle" => "Car", "type" => "Average car", "fuel" => "Plug-in Hybrid Electric (Petrol)", "factors" => "0.06995"],
            ["vehicle_type" => 2, "vehicle" => "HGV", "type" => "Rigid (>3.5-7.5 tonnes)", "fuel" => "Diesel", "factors" => "0.4825"],
            ["vehicle_type" => 2, "vehicle" => "HGV", "type" => "Rigid (>7.5 tonnes-17 tonnes)", "fuel" => "Diesel", "factors" => "0.5893"],
            ["vehicle_type" => 2, "vehicle" => "HGV", "type" => "Rigid (>17 tonnes)", "fuel" => "Diesel", "factors" => "0.9643"],
            ["vehicle_type" => 2, "vehicle" => "HGV", "type" => "All rigids", "fuel" => "Diesel", "factors" => "0.8011"],
            ["vehicle_type" => 2, "vehicle" => "HGV", "type" => "Articulated (>3.5 - 33t)", "fuel" => "Diesel", "factors" => "0.7757"],
            ["vehicle_type" => 2, "vehicle" => "HGV", "type" => "Articulated (>33t)", "fuel" => "Diesel", "factors" => "0.9237"],
            ["vehicle_type" => 2, "vehicle" => "HGV", "type" => "All artics", "fuel" => "Diesel", "factors" => "0.9157"],
            ["vehicle_type" => 2, "vehicle" => "HGV", "type" => "All HGVs", "fuel" => "Diesel", "factors" => "0.8654"],
            ["vehicle_type" => 2, "vehicle" => "HGVs refrigerated", "type" => "Rigid (>3.5-7.5 tonnes)", "fuel" => "Diesel", "factors" => "0.5744"],
            ["vehicle_type" => 2, "vehicle" => "HGVs refrigerated", "type" => "Rigid (>7.5 tonnes-17 tonnes)", "fuel" => "Diesel", "factors" => "0.7015"],
            ["vehicle_type" => 2, "vehicle" => "HGVs refrigerated", "type" => "Rigid (>17 tonnes)", "fuel" => "Diesel", "factors" => "1.1480"],
            ["vehicle_type" => 2, "vehicle" => "HGVs refrigerated", "type" => "All rigids", "fuel" => "Diesel", "factors" => "0.9537"],
            ["vehicle_type" => 2, "vehicle" => "HGVs refrigerated", "type" => "Articulated (>3.5 - 33t)", "fuel" => "Diesel", "factors" => "0.8980"],
            ["vehicle_type" => 2, "vehicle" => "HGVs refrigerated", "type" => "Articulated (>33t)", "fuel" => "Diesel", "factors" => "1.0692"],
            ["vehicle_type" => 2, "vehicle" => "HGVs refrigerated", "type" => "All artics", "fuel" => "Diesel", "factors" => "1.0600"],
            ["vehicle_type" => 2, "vehicle" => "HGVs refrigerated", "type" => "All HGVs", "fuel" => "Diesel", "factors" => "1.0142"],
            ["vehicle_type" => 2, "vehicle" => "Vans", "type" => "Class I (up to 1.305t)", "fuel" => "Diesel", "factors" => "1.1485"],
            ["vehicle_type" => 2, "vehicle" => "Vans", "type" => "Class II (1.305 to 1.74t)", "fuel" => "Diesel", "factors" => "0.1890"],
            ["vehicle_type" => 2, "vehicle" => "Vans", "type" => "Class III (1.74 to 3.5t)", "fuel" => "Diesel", "factors" => "0.2717"],
            ["vehicle_type" => 2, "vehicle" => "Vans", "type" => "Average (up to 3.5t)", "fuel" => "Diesel", "factors" => "0.2471"],
            ["vehicle_type" => 2, "vehicle" => "Vans", "type" => "Class I (up to 1.305t)", "fuel" => "Petrol", "factors" => "0.2108"],
            ["vehicle_type" => 2, "vehicle" => "Vans", "type" => "Class II (1.305 to 1.74t)", "fuel" => "Petrol", "factors" => "0.2079"],
            ["vehicle_type" => 2, "vehicle" => "Vans", "type" => "Class III (1.74 to 3.5t)", "fuel" => "Petrol", "factors" => "0.3328"],
            ["vehicle_type" => 2, "vehicle" => "Vans", "type" => "Average (up to 3.5t)", "fuel" => "Petrol", "factors" => "0.2196"],
            ["vehicle_type" => 2, "vehicle" => "Vans", "type" => "Average (up to 3.5t)", "fuel" => "CNG", "factors" => "0.2471"],
            ["vehicle_type" => 2, "vehicle" => "Vans", "type" => "Average (up to 3.5t)", "fuel" => "LPG", "factors" => "0.2718"],
            ["vehicle_type" => 2, "vehicle" => "Vans", "type" => "Average (up to 3.5t)", "fuel" => "Unknown", "factors" => "0.2462"],
            ["vehicle_type" => 2, "vehicle" => "Vans", "type" => "Class I (up to 1.305t)", "fuel" => "Battery Electric", "factors" => ""],
            ["vehicle_type" => 2, "vehicle" => "Vans", "type" => "Class II (1.305 to 1.74t)", "fuel" => "Battery Electric", "factors" => ""],
            ["vehicle_type" => 2, "vehicle" => "Vans", "type" => "Class III (1.74 to 3.5t)", "fuel" => "Battery Electric", "factors" => ""],
            ["vehicle_type" => 2, "vehicle" => "Vans", "type" => "Average (uo to 3.5t)", "fuel" => "Battery Electric", "factors" => ""],
        ];
            vehicle::insert($vehicleArray);
    }
}
