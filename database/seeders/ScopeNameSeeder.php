<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Scope;
use Illuminate\Support\Facades\DB;

class ScopeNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Scope::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $scopeArray = [
            ['name'=>"Scope-1"],
            ['name'=>"Scope-2"],
            ['name'=>"Scope-3"],
        ];
        Scope::insert($scopeArray);
    }
}
