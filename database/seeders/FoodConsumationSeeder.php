<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FoodCosumption;
use Illuminate\Support\Facades\DB;

class FoodConsumationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        FoodCosumption::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $FoodArr = [
            [
                'vehicle' => '1 standard breakfast',
                'unit' => 'breakfast',
                'type' => 'Meal',
                'factors' => '0.84',
            ],
            [
                'vehicle' => '1 gourmet breakfast',
                'unit' => 'breakfast',
                'type' => 'Meal',
                'factors' => '2.33',
            ],
            [
                'vehicle' => '1 cold or hot snack',
                'unit' => 'hot snack',
                'type' => 'Meal',
                'factors' => '2.02',
            ],
            [
                'vehicle' => '1 average meal',
                'unit' => 'meal',
                'type' => 'Meal',
                'factors' => '4.70',
            ],
            [
                'vehicle' => 'Non-alcoholic beverage',
                'unit' => 'litre',
                'type' => 'Drink',
                'factors' => '0.20',
            ],
            [
                'vehicle' => 'Alcoholic beverage',
                'unit' => 'litre',
                'type' => 'Drink',
                'factors' => '1.87',
            ],
            [
                'vehicle' => '1 hot snack (burger + frites)',
                'unit' => 'hot snack',
                'type' => 'Meal',
                'factors' => '2.77',
            ],
            [
                'vehicle' => '1 sandwich',
                'unit' => 'sandwich',
                'type' => 'Meal',
                'factors' => '1.27',
            ],
            [
                'vehicle' => 'Meal, vegan',
                'unit' => 'meal',
                'type' => 'Meal',
                'factors' => '1.69',
            ],
            [
                'vehicle' => 'Meal, vegetarian',
                'unit' => 'meal',
                'type' => 'Meal',
                'factors' => '2.85',
            ],
            [
                'vehicle' => 'Meal, with beef',
                'unit' => 'meal',
                'type' => 'Meal',
                'factors' => '6.93',
            ],
            [
                'vehicle' => 'Meal, with chicken',
                'unit' => 'meal',
                'type' => 'Meal',
                'factors' => '3.39',
            ],
        ];

        FoodCosumption::insert($FoodArr);
    }
}  
