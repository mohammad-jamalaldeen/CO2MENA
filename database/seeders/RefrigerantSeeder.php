<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Refrigerant;

class RefrigerantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Refrigerant::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $refrigerantArray = [
                ['type' => Refrigerant::TYPE[0], 'emission' => 'Carbon dioxide', 'unit' => Refrigerant::UNIT[0], 'factors'=> '1' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'Methane', 'unit' => Refrigerant::UNIT[0], 'factors'=> '25' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'Nitrous oxide', 'unit' => Refrigerant::UNIT[0], 'factors'=> '298' ],
                ['type' => Refrigerant::TYPE[1], 'emission' => 'HFC-23', 'unit' => Refrigerant::UNIT[0], 'factors'=> '14,800' ],
                ['type' => Refrigerant::TYPE[1], 'emission' => 'HFC-32', 'unit' => Refrigerant::UNIT[0], 'factors'=> '675' ],
                ['type' => Refrigerant::TYPE[1], 'emission' => 'HFC-41', 'unit' => Refrigerant::UNIT[0], 'factors'=> '92' ],
                ['type' => Refrigerant::TYPE[1], 'emission' => '12 HFC-125', 'unit' => Refrigerant::UNIT[0], 'factors'=> '3,500' ],
                ['type' => Refrigerant::TYPE[1], 'emission' => 'HFC-134', 'unit' => Refrigerant::UNIT[0], 'factors'=> '1,100' ],
                ['type' => Refrigerant::TYPE[1], 'emission' => '14 HFC-134a', 'unit' => Refrigerant::UNIT[0], 'factors'=> '1,430' ],
                ['type' => Refrigerant::TYPE[1], 'emission' => 'HFC-143', 'unit' => Refrigerant::UNIT[0], 'factors'=> '353' ],
                ['type' => Refrigerant::TYPE[1], 'emission' => 'HFC-143a', 'unit' => Refrigerant::UNIT[0], 'factors'=> '4,470' ],
                ['type' => Refrigerant::TYPE[1], 'emission' => '17 HFC-152a', 'unit' => Refrigerant::UNIT[0], 'factors'=> '124' ],
                ['type' => Refrigerant::TYPE[1], 'emission' => 'HFC-227ea', 'unit' => Refrigerant::UNIT[0], 'factors'=> '3,220' ],
                ['type' => Refrigerant::TYPE[1], 'emission' => '19 HFC-236fa', 'unit' => Refrigerant::UNIT[0], 'factors'=> '9,810' ],
                ['type' => Refrigerant::TYPE[1], 'emission' => 'HFC-245fa', 'unit' => Refrigerant::UNIT[0], 'factors'=> '1,030' ],
                ['type' => Refrigerant::TYPE[1], 'emission' => 'HFC-43-10mee', 'unit' => Refrigerant::UNIT[0], 'factors'=> '1,640' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => '22 Perfluoromethane (PFC-14)', 'unit' => Refrigerant::UNIT[0], 'factors'=> '7,390' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'Perfluoroethane (PFC-116)', 'unit' => Refrigerant::UNIT[0], 'factors'=> '12,200' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => '24 Perfluoropropane (PFC-218)', 'unit' => Refrigerant::UNIT[0], 'factors'=> '8,830' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'Perfluorocyclobutane (PFC-318)', 'unit' => Refrigerant::UNIT[0], 'factors'=> '10,300' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'Perfluorobutane (PFC-3-1-10)', 'unit' => Refrigerant::UNIT[0], 'factors'=> '8,860' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'Perfluoropentane (PFC-4-1-12)', 'unit' => Refrigerant::UNIT[0], 'factors'=> '9,160' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'Perfluorohexane (PFC-5-1-14)', 'unit' => Refrigerant::UNIT[0], 'factors'=> '9,300' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'Sulphur hexafluoride (SF6)', 'unit' => Refrigerant::UNIT[0], 'factors'=> '22,800' ],
                ['type' => Refrigerant::TYPE[1], 'emission' => 'HFC-152', 'unit' => Refrigerant::UNIT[0], 'factors'=> '53' ],
                ['type' => Refrigerant::TYPE[1], 'emission' => 'HFC-161', 'unit' => Refrigerant::UNIT[0], 'factors'=> '12' ],
                ['type' => Refrigerant::TYPE[1], 'emission' => 'HFC-236cb', 'unit' => Refrigerant::UNIT[0], 'factors'=> '1,340' ],
                ['type' => Refrigerant::TYPE[1], 'emission' => 'HFC-236ea', 'unit' => Refrigerant::UNIT[0], 'factors'=> '1,370' ],
                ['type' => Refrigerant::TYPE[1], 'emission' => 'HFC-245ca', 'unit' => Refrigerant::UNIT[0], 'factors'=> '693' ],
                ['type' => Refrigerant::TYPE[1], 'emission' => 'HFC-365mfc', 'unit' => Refrigerant::UNIT[0], 'factors'=> '794' ],
                ['type' => Refrigerant::TYPE[2], 'emission' => 'R404A', 'unit' => Refrigerant::UNIT[0], 'factors'=> '3,922' ],
                ['type' => Refrigerant::TYPE[2], 'emission' => 'R407A', 'unit' => Refrigerant::UNIT[0], 'factors'=> '2,107' ],
                ['type' => Refrigerant::TYPE[2], 'emission' => 'R407C', 'unit' => Refrigerant::UNIT[0], 'factors'=> '1,774' ],
                ['type' => Refrigerant::TYPE[2], 'emission' => 'R407F', 'unit' => Refrigerant::UNIT[0], 'factors'=> '1,825' ],
                ['type' => Refrigerant::TYPE[2], 'emission' => 'R408A', 'unit' => Refrigerant::UNIT[0], 'factors'=> '3,152' ],
                ['type' => Refrigerant::TYPE[2], 'emission' => 'R410A', 'unit' => Refrigerant::UNIT[0], 'factors'=> '2,088' ],
                ['type' => Refrigerant::TYPE[2], 'emission' => 'R507A', 'unit' => Refrigerant::UNIT[0], 'factors'=> '3.985' ],
                ['type' => Refrigerant::TYPE[2], 'emission' => 'R508B', 'unit' => Refrigerant::UNIT[0], 'factors'=> '13,396' ],
                ['type' => Refrigerant::TYPE[2], 'emission' => 'R403A', 'unit' => Refrigerant::UNIT[0], 'factors'=> '3,124' ],
                ['type' => Refrigerant::TYPE[3], 'emission' => 'CFC-11/R11 = trichlorofluoromethane', 'unit' => Refrigerant::UNIT[0], 'factors'=> '4,750' ],
                ['type' => Refrigerant::TYPE[3], 'emission' => 'CFC-12/R12 = dichlorodifluoromethane', 'unit' => Refrigerant::UNIT[0], 'factors'=> '10,900' ],
                ['type' => Refrigerant::TYPE[3], 'emission' => 'CFC-13', 'unit' => Refrigerant::UNIT[0], 'factors'=> '14,400' ],
                ['type' => Refrigerant::TYPE[3], 'emission' => 'CFC-113', 'unit' => Refrigerant::UNIT[0], 'factors'=> '6,130' ],
                ['type' => Refrigerant::TYPE[3], 'emission' => 'CFC-114', 'unit' => Refrigerant::UNIT[0], 'factors'=> '10,000' ],
                ['type' => Refrigerant::TYPE[3], 'emission' => 'CFC-115', 'unit' => Refrigerant::UNIT[0], 'factors'=> '7,370' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'Halon-1211', 'unit' => Refrigerant::UNIT[0], 'factors'=> '1,890' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'Halon-1301', 'unit' => Refrigerant::UNIT[0], 'factors'=> '7,140' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'Halon-2402', 'unit' => Refrigerant::UNIT[0], 'factors'=> '1,640' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'Carbon tetrachloride', 'unit' => Refrigerant::UNIT[0], 'factors'=> '1,400' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'Methyl bromide', 'unit' => Refrigerant::UNIT[0], 'factors'=> '5' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => '56 Methyl chloroform', 'unit' => Refrigerant::UNIT[0], 'factors'=> '146' ],
                ['type' => Refrigerant::TYPE[1], 'emission' => 'HCFC-22/R22 = chlorodifluoromethane', 'unit' => Refrigerant::UNIT[0], 'factors'=> '1,810' ],
                ['type' => Refrigerant::TYPE[1], 'emission' => 'HCFC-123', 'unit' => Refrigerant::UNIT[0], 'factors'=> '77' ],
                ['type' => Refrigerant::TYPE[1], 'emission' => 'HCFC-124', 'unit' => Refrigerant::UNIT[0], 'factors'=> '690' ],
                ['type' => Refrigerant::TYPE[1], 'emission' => 'HCFC-141b', 'unit' => Refrigerant::UNIT[0], 'factors'=> '725' ],
                ['type' => Refrigerant::TYPE[1], 'emission' => 'HCFC-142b', 'unit' => Refrigerant::UNIT[0], 'factors'=> '2,310' ],
                ['type' => Refrigerant::TYPE[1], 'emission' => 'HCFC-225ca', 'unit' => Refrigerant::UNIT[0], 'factors'=> '122' ],
                ['type' => Refrigerant::TYPE[1], 'emission' => 'HCFC-225cb', 'unit' => Refrigerant::UNIT[0], 'factors'=> '595' ],
                ['type' => Refrigerant::TYPE[1], 'emission' => 'HCFC-21', 'unit' => Refrigerant::UNIT[0], 'factors'=> '151' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'Nitrogen trifluoride', 'unit' => Refrigerant::UNIT[0], 'factors'=> '17,200' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'PFC-9-1-18', 'unit' => Refrigerant::UNIT[0], 'factors'=> '7,500' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => ' Trifluoromethyl sulphur pentafluoride', 'unit' => Refrigerant::UNIT[0], 'factors'=> '17,700' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'Perfluorocyclopropane', 'unit' => Refrigerant::UNIT[0], 'factors'=> '17,340' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'HFE-125', 'unit' => Refrigerant::UNIT[0], 'factors'=> '14,900' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'HFE-134', 'unit' => Refrigerant::UNIT[0], 'factors'=> '6,320' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'HFE-143a', 'unit' => Refrigerant::UNIT[0], 'factors'=> '756' ],
                ['type' => Refrigerant::TYPE[1], 'emission' => 'HCFE-235da2', 'unit' => Refrigerant::UNIT[0], 'factors'=> '350' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'HFE-245cb2', 'unit' => Refrigerant::UNIT[0], 'factors'=> '708' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'HFE-245fa2', 'unit' => Refrigerant::UNIT[0], 'factors'=> '659' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'HFE-254cb2', 'unit' => Refrigerant::UNIT[0], 'factors'=> '359' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'HFE-347mcc3', 'unit' => Refrigerant::UNIT[0], 'factors'=> '575' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'HFE-347pcf2', 'unit' => Refrigerant::UNIT[0], 'factors'=> '580' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'HFE-356pcc3', 'unit' => Refrigerant::UNIT[0], 'factors'=> '110' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'HFE-449sl (HFE-7100)', 'unit' => Refrigerant::UNIT[0], 'factors'=> '297' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'HFE-569s/2 (HFE-7200)', 'unit' => Refrigerant::UNIT[0], 'factors'=> '59' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'HFE-43-10pccc124 (H-Galden1040x)', 'unit' => Refrigerant::UNIT[0], 'factors'=> '1,870' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'HFE-236ca12 (HG-10)', 'unit' => Refrigerant::UNIT[0], 'factors'=> '2,800' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => '83 HFE-338pcc13 (HG-01)', 'unit' => Refrigerant::UNIT[0], 'factors'=> '1,500' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'PFPMIE', 'unit' => Refrigerant::UNIT[0], 'factors'=> '10,300' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'Dimethylether', 'unit' => Refrigerant::UNIT[0], 'factors'=> '1' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'Methylene chloride', 'unit' => Refrigerant::UNIT[0], 'factors'=> '9' ],
                ['type' => Refrigerant::TYPE[0], 'emission' => 'Methyl chloride', 'unit' => Refrigerant::UNIT[0], 'factors'=> '13' ],
                ['type' => Refrigerant::TYPE[2], 'emission' => 'R290 = propane', 'unit' => Refrigerant::UNIT[0], 'factors'=> '3' ],
                ['type' => Refrigerant::TYPE[2], 'emission' => 'R600A = isobutane', 'unit' => Refrigerant::UNIT[0], 'factors'=> '3' ],
                ['type' => Refrigerant::TYPE[2], 'emission' => 'R406A', 'unit' => Refrigerant::UNIT[0], 'factors'=> '1,943' ],
                ['type' => Refrigerant::TYPE[2], 'emission' => 'R409A', 'unit' => Refrigerant::UNIT[0], 'factors'=> '1,585' ],
                ['type' => Refrigerant::TYPE[2], 'emission' => 'R502', 'unit' => Refrigerant::UNIT[0], 'factors'=> '4,657' ],

        ];

        Refrigerant::insert($refrigerantArray);
    }
}
