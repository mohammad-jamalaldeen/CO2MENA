<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WasteDisposal;
use Illuminate\Support\Facades\DB;

class WasteDisposelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        WasteDisposal::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $waterDisposelArr = [
            ['type' => WasteDisposal::TYPE[1], 'row_id' => '1', 'waste_type' => 'Aggregates', 'factors' => '1.2489'],
            ['type' => WasteDisposal::TYPE[1], 'row_id' => '2', 'waste_type' => 'Asbestos', 'factors' => '5.9277'],
            ['type' => WasteDisposal::TYPE[0], 'row_id' => '3', 'waste_type' => 'Asphalt', 'factors' => '1.2489'],
            ['type' => WasteDisposal::TYPE[1], 'row_id' => '4', 'waste_type' => 'Batteries', 'factors' => '85.4344'],
            ['type' => WasteDisposal::TYPE[0], 'row_id' => '5', 'waste_type' => 'Bricks', 'factors' => '1.2489'],
            ['type' => WasteDisposal::TYPE[0], 'row_id' => '6', 'waste_type' => 'Clothing', 'factors' => '444.9759'],
            ['type' => WasteDisposal::TYPE[0], 'row_id' => '7', 'waste_type' => 'Commercial and industrial waste', 'factors' => '458.1763'],
            ['type' => WasteDisposal::TYPE[0], 'row_id' => '8', 'waste_type' => 'Concrete', 'factors' => '1.2489'],
            ['type' => WasteDisposal::TYPE[0], 'row_id' => '9', 'waste_type' => 'Glass', 'factors' => '8.9344'],
            ['type' => WasteDisposal::TYPE[0], 'row_id' => '10', 'waste_type' => 'Household residual', 'factors' => '437.3719'],
            ['type' => WasteDisposal::TYPE[0], 'row_id' => '11', 'waste_type' => 'Insulation', 'factors' => '1.2489'],
            ['type' => WasteDisposal::TYPE[1], 'row_id' => '12', 'waste_type' => 'Metal: aluminium cans and foil (excl. forming)', 'factors' => '8.9344'],
            ['type' => WasteDisposal::TYPE[1], 'row_id' => '13', 'waste_type' => 'Metal: mixed cans', 'factors' => '8.9344'],
            ['type' => WasteDisposal::TYPE[1], 'row_id' => '14', 'waste_type' => 'Metal: scrap metal', 'factors' => '8.9344'],
            ['type' => WasteDisposal::TYPE[1], 'row_id' => '15', 'waste_type' => 'Metal: steel cans', 'factors' => '8.9344'],
            ['type' => WasteDisposal::TYPE[1], 'row_id' => '16', 'waste_type' => 'Metals', 'factors' => '1.2643'],
            ['type' => WasteDisposal::TYPE[0], 'row_id' => '17', 'waste_type' => 'Organic: food and drink waste', 'factors' => '626.9073'],
            ['type' => WasteDisposal::TYPE[0], 'row_id' => '18', 'waste_type' => 'Organic: garden waste', 'factors' => '578.9916'],
            ['type' => WasteDisposal::TYPE[0], 'row_id' => '19', 'waste_type' => 'Organic: mixed food and garden waste', 'factors' => '587.3768'],
            ['type' => WasteDisposal::TYPE[2], 'row_id' => '20', 'waste_type' => 'Paper and board: board', 'factors' => '1041.8361'],
            ['type' => WasteDisposal::TYPE[2], 'row_id' => '21', 'waste_type' => 'Paper and board: mixed', 'factors' => '1041.8361'],
            ['type' => WasteDisposal::TYPE[2], 'row_id' => '22', 'waste_type' => 'Paper and board: paper', 'factors' => '1041.8361'],
            ['type' => WasteDisposal::TYPE[0], 'row_id' => '23', 'waste_type' => 'Plasteboard', 'factors' => '71.95'],
            ['type' => WasteDisposal::TYPE[3], 'row_id' => '24', 'waste_type' => 'Plastics: average plastics film', 'factors' => '8.9344'],
            ['type' => WasteDisposal::TYPE[3], 'row_id' => '25', 'waste_type' => 'Plastics: average plastic rigid', 'factors' => '8.9344'],
            ['type' => WasteDisposal::TYPE[3], 'row_id' => '26', 'waste_type' => 'Plastics: average plastic ', 'factors' => '8.9344'],
            ['type' => WasteDisposal::TYPE[3], 'row_id' => '27', 'waste_type' => 'Plastics: HDPE (incl. forming)', 'factors' => '8.9344'],
            ['type' => WasteDisposal::TYPE[3], 'row_id' => '28', 'waste_type' => 'Plastics: LDPE and LLDPE (incl. forming)', 'factors' => '8.9344'],
            ['type' => WasteDisposal::TYPE[3], 'row_id' => '29', 'waste_type' => 'Plastics: PET (incl. forming)', 'factors' => '8.9344'],
            ['type' => WasteDisposal::TYPE[3], 'row_id' => '30', 'waste_type' => 'Plastics: PP (incl. forming)', 'factors' => '8.9344'],
            ['type' => WasteDisposal::TYPE[3], 'row_id' => '31', 'waste_type' => 'Plastics: PS (incl. forming)', 'factors' => '8.9344'],
            ['type' => WasteDisposal::TYPE[3], 'row_id' => '32', 'waste_type' => 'Plastics: PVC(incl. forming)', 'factors' => '8.9344'],
            ['type' => WasteDisposal::TYPE[0], 'row_id' => '33', 'waste_type' => 'Soils', 'factors' => '17.5923'],
            ['type' => WasteDisposal::TYPE[0], 'row_id' => '34', 'waste_type' => 'WEEE-fridges and freezers', 'factors' => '8.9864'],
            ['type' => WasteDisposal::TYPE[0], 'row_id' => '35', 'waste_type' => 'WEEE - large', 'factors' => '8.9864'],
            ['type' => WasteDisposal::TYPE[0], 'row_id' => '36', 'waste_type' => 'WEEE - mixed', 'factors' => '8.9864'],
            ['type' => WasteDisposal::TYPE[0], 'row_id' => '37', 'waste_type' => 'WEEE - small', 'factors' => '8.9864'],
            ['type' => WasteDisposal::TYPE[0], 'row_id' => '38', 'waste_type' => 'Wood', 'factors' => '828.0647'],
        ];
        WasteDisposal::insert($waterDisposelArr);
    }
}
