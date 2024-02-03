<?php

use App\Models\{
    UserEmissionBusinessTravel,
    UserEmissionEmployeesCommuting,
    UserEmissionFoodCosumption,
    UserEmissionFuel,
    UserEmissionMaterialUse,
    UserEmissionRefrigerant,
    UserEmissionWasteDisposal,
    UserEmissionWatersupplytreatment,
    UserEmissionWttFule,
    UserEmissionVehicle,
    UserEmissionElectricity,
    UserEmissionFreightingGoodsVansHgv,
    UserEmissionFreightingGoodsFlightsRail,
    UserEmissionTransmissionAndDistribution,
    Country,
    City
};
use Illuminate\Support\Facades\Config;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\{
    Alignment,
    Fill
};
use PhpOffice\PhpSpreadsheet\Style\Protection;

//Dynamic Sheet Genrate Function
if (!function_exists('sheetGenerate')) {
    function sheetGenerate($emissionNames, $companyId)
    {
        $spreadsheet = new Spreadsheet();
        $i = 0;

        foreach ($emissionNames as $value) {
            $sheetTitle = getValidSheetTitle($value);
            $sheet = ($i == 0) ? $spreadsheet->getActiveSheet() : $spreadsheet->createSheet();
            $sheet->setTitle($sheetTitle);
            $sheet->getProtection()->setPassword('password');
            $sheet->getProtection()->setSheet(true);
            getDataArrayForSheet($value, $companyId, $sheet);
            $i++;
        }

        $filename = uniqid() . '.xlsx';
        $spreadsheet->setActiveSheetIndex(0);
        $writer = new Xlsx($spreadsheet);
        $writer->save(\Illuminate\Support\Facades\Storage::disk('sample_datasheet')->path('') . $filename);
        return $filename;
    }
}
if (!function_exists('getValidSheetTitle')) {
    function getValidSheetTitle($title)
    {
        // Remove invalid characters from the title
        $cleanedTitle = preg_replace('/[\/\\\?\*\[\]:]/', '_', $title);

        // Trim the title to a maximum of 31 characters (maximum allowed for Excel sheet title)
        return substr($cleanedTitle, 0, 31);
    }
}

if (!function_exists('getDataArrayForSheet')) {
    function getDataArrayForSheet($sheetName, $companyId, $sheet)
    {
        switch ($sheetName) {
            case 'Fuels':
                $sheet->fromArray(getDataForFuelsSheet($companyId, $sheet), null, 'A2');
                break;
            case 'Refrigerants':
                $sheet->fromArray(getDataForRefrigerantsSheet($companyId, $sheet), null, 'A2');
                break;
            case 'Owned vehicles':
                $sheet->fromArray(getDataForOwnedVehiclesSheet($companyId, $sheet), null, 'A3');
                break;
            case 'Food':
                $sheet->fromArray(getDataForFoodSheet($companyId, $sheet), null, 'A2');
                break;
            case 'Freighting goods':
                $sheet->fromArray(getDataForFreightingGoodsSheet($companyId, $sheet), null, 'A3');
                break;
            case 'Business travel - land and sea':
                $sheet->fromArray(getDataForBusinessTravelSheet($companyId, $sheet), null, 'A2');
                break;
            case 'Employees commuting':
                $sheet->fromArray(getDataForEmployeesCommutingSheet($companyId, $sheet), null, 'A2');
                break;
            case 'Waste disposal':
                $sheet->fromArray(getDataForWasteDisposelSheet($companyId, $sheet), null, 'A2');
                break;
            case 'WTT-fules':
                $sheet->fromArray(getDataForWTTFulesSheet($companyId, $sheet), null, 'A2');
                break;
            case 'T&D':
                $sheet->fromArray(getDataForTandDSheet($companyId, $sheet), null, 'A2');
                break;
            case 'Water':
                $sheet->fromArray(getDataForWaterSheet($companyId, $sheet), null, 'A2');
                break;
            case 'Material use':
                $sheet->fromArray(getDataForMaterialUseSheet($companyId, $sheet), null, 'A2');
                break;
            case 'Electricity, heat, cooling':
                $sheet->fromArray(getDataForElectricityHeatCoolingUseSheet($companyId, $sheet), null, 'A2');
                break;
            case 'Flight and Accommodation':
                $sheet->fromArray(getDataForFlightAndAccommodationUseSheet($companyId, $sheet), null, 'A2');
                break;
            case 'Home Office':
                $sheet->fromArray(getDataForHomeOfficeUseSheet($companyId, $sheet), null, 'A2');
                break;
        }

        return $sheet;
    }
}

if (!function_exists('getDataForFuelsSheet')) {
    function getDataForFuelsSheet($companyId, $sheet)
    {
        $titleCollumn = ['Type', 'Fuel', 'Unit', 'Amount'];
        $fuelArray = [$titleCollumn];
        setTitleDesign($sheet, 'Fuels', $titleCollumn, 'A1', '1');

        $sheet = titleCollumnDesign($sheet, $titleCollumn);
        $fuelData =  UserEmissionFuel::where('company_id', $companyId)
            ->with('fules')
            ->get()
            ->toArray();

        $collmnIndex = 2;
        if (count($fuelData) > 0) {
            foreach ($fuelData as $value) {
                if (isset($value['fules'])) {
                    subCollumnDesignset($sheet, $titleCollumn, $collmnIndex);
                    subCollumnProtectionset($sheet, $titleCollumn, $collmnIndex, "G");
                    $fuelObject = [
                        $value['fules']['type'],
                        $value['fules']['fuel'],
                        $value['fules']['unit'],
                        '',
                        '',
                        '',
                        $value['fules']['id']
                    ];
                    $fuelArray[] = $fuelObject;

                    $collmnIndex++;
                }
            }
        }
        return $fuelArray;
    }
}

if (!function_exists('getDataForFoodSheet')) {
    function getDataForFoodSheet($companyId, $sheet)
    {
        $foodCosumptionData = UserEmissionFoodCosumption::where('company_id', $companyId)->with('foodcosumption')->get()->toArray();
        $titleCollumn = ['Type', 'Vehicle', 'Unit', 'Amount'];
        $foodCosumptionArray = [$titleCollumn];
        setTitleDesign($sheet, 'Food consumption', $titleCollumn, 'A1', '1');

        $sheet = titleCollumnDesign($sheet, $titleCollumn);
        $collmnIndex = 2;
        foreach ($foodCosumptionData as $value) {
            if (isset($value['foodcosumption'])) {
                subCollumnDesignset($sheet, $titleCollumn, $collmnIndex);
                subCollumnProtectionset($sheet, $titleCollumn, $collmnIndex, "G");
                $foodCosumptionObject = [
                    $value['foodcosumption']['type'],
                    $value['foodcosumption']['vehicle'],
                    trim($value['foodcosumption']['unit']),
                    '',
                    '',
                    '',
                    $value['foodcosumption']['id']
                ];
                $foodCosumptionArray[] = $foodCosumptionObject;
                $collmnIndex++;
            }
        }
        return $foodCosumptionArray;
    }
}

if (!function_exists('getDataForFreightingGoodsSheet')) {
    function getDataForFreightingGoodsSheet($companyId, $sheet)
    {
        $titleCollumn = ['Vehicle', 'Type', 'Fuel', 'Distance (km)', '', '', '', 'Vehicle', 'Type', 'Unit', 'Tonne.km'];
        $sheet = freightingGoodsTitleCollumnDesign($sheet, $titleCollumn);
        $freightingGoodsVansHgvsArray = [$titleCollumn];
        //title design set
        setTitleDesign($sheet, 'Freighting goods', $titleCollumn, 'A1', '1');
        freightingGoodsSubTitleCollumnDesign($sheet, 'Freighting goods -> vans and HGVs:', 'A2', 'F2');
        freightingGoodsSubTitleCollumnDesign($sheet, 'Freighting goods -> flights, rail, sea tanker and cargo ship:', 'H2', 'L2');

        $freightingGoodsVansHgvsData = UserEmissionFreightingGoodsVansHgv::where('company_id', $companyId)->with('freightingGoodsVansHgvs')->get()->toArray();
        $freightingGoodsFlightData = UserEmissionFreightingGoodsFlightsRail::where('company_id', $companyId)->with('freightingGoodsFlight')->get()->toArray();
        $maxValue = max(count($freightingGoodsVansHgvsData), count($freightingGoodsFlightData));
        $collmnIndex = 3;
        for ($i = 0; $i < $maxValue; $i++) {
            freightingGoodsSubCollumnDesignset($sheet, $titleCollumn, $collmnIndex, count($freightingGoodsVansHgvsData),  count($freightingGoodsFlightData),  $i);
            subCollumnProtectionsetTwoTable($sheet, $titleCollumn, $collmnIndex, count($freightingGoodsVansHgvsData),  count($freightingGoodsFlightData),  $i, ['F','M']);
            $freightingGoodsVansHgvsObject = [
                isset($freightingGoodsVansHgvsData[$i]['freighting_goods_vans_hgvs']['vehicle']) ? $freightingGoodsVansHgvsData[$i]['freighting_goods_vans_hgvs']['vehicle'] : '',
                isset($freightingGoodsVansHgvsData[$i]['freighting_goods_vans_hgvs']['type']) ? $freightingGoodsVansHgvsData[$i]['freighting_goods_vans_hgvs']['type'] : '',
                isset($freightingGoodsVansHgvsData[$i]['freighting_goods_vans_hgvs']['fuel']) ? $freightingGoodsVansHgvsData[$i]['freighting_goods_vans_hgvs']['fuel'] : '',
                '',
                '',
                isset($freightingGoodsVansHgvsData[$i]['freighting_goods_vans_hgvs']['id']) ? $freightingGoodsVansHgvsData[$i]['freighting_goods_vans_hgvs']['id'] : '',
                '',
                isset($freightingGoodsFlightData[$i]['freighting_goods_flight']['vehicle']) ? $freightingGoodsFlightData[$i]['freighting_goods_flight']['vehicle'] : '',
                isset($freightingGoodsFlightData[$i]['freighting_goods_flight']['type']) ? $freightingGoodsFlightData[$i]['freighting_goods_flight']['type'] : '',
                isset($freightingGoodsFlightData[$i]['freighting_goods_flight']['unit']) ? $freightingGoodsFlightData[$i]['freighting_goods_flight']['unit'] : '',
                '',
                '',
                isset($freightingGoodsFlightData[$i]['freighting_goods_flight']['id']) ? $freightingGoodsFlightData[$i]['freighting_goods_flight']['id'] : '',
            ];

            array_push($freightingGoodsVansHgvsArray, $freightingGoodsVansHgvsObject);
            $collmnIndex++;
        }

        return $freightingGoodsVansHgvsArray;
    }
}

if (!function_exists('getDataForBusinessTravelSheet')) {
    function getDataForBusinessTravelSheet($companyId, $sheet)
    {
        $titleCollumn = ["Vehicle", "Type", "Fuel", "Unit", "Total distance"];
        $businessTravelArray = [$titleCollumn];
        setTitleDesign($sheet, 'Business travel: land and sea', $titleCollumn, 'A1', '1');

        $sheet = titleCollumnDesign($sheet, $titleCollumn);
        $businessTravelData = UserEmissionBusinessTravel::where('company_id', $companyId)->with('businesstravels')->get()->toArray();
        $collmnIndex = 2;
        foreach ($businessTravelData as $value) {
            if (isset($value['businesstravels'])) {
                subCollumnDesignset($sheet, $titleCollumn, $collmnIndex);
                subCollumnProtectionset($sheet, $titleCollumn, $collmnIndex, "G");
                $businessTravelObject = [
                    $value['businesstravels']['vehicles'],
                    $value['businesstravels']['type'],
                    $value['businesstravels']['fuel'],
                    $value['businesstravels']['unit'],
                    '',
                    '',
                    $value['businesstravels']['id']
                ];
                array_push($businessTravelArray, $businessTravelObject);
                $collmnIndex++;
            }
        }
        return $businessTravelArray;
    }
}

if (!function_exists('getDataForEmployeesCommutingSheet')) {
    function getDataForEmployeesCommutingSheet($companyId, $sheet)
    {
        $titleCollumn = ["Vehicle", "Type", "Fuel", "Unit", "Total distance"];
        $employeesCommutingArray = [$titleCollumn];
        setTitleDesign($sheet, 'Employees commuting', $titleCollumn, 'A1', '1');
        $sheet = titleCollumnDesign($sheet, $titleCollumn);

        $employeesCommutingData = UserEmissionEmployeesCommuting::where('company_id', $companyId)->with('employeescommutings')->get()->toArray();
        $collmnIndex = 2;

        foreach ($employeesCommutingData as $value) {
            if (isset($value['employeescommutings'])) {
                subCollumnDesignset($sheet, $titleCollumn, $collmnIndex);
                subCollumnProtectionset($sheet, $titleCollumn, $collmnIndex, "G");
                $employeesCommutingObject = [
                    $value['employeescommutings']['vehicle'],
                    $value['employeescommutings']['type'],
                    $value['employeescommutings']['fuel'],
                    $value['employeescommutings']['unit'],
                    '',
                    '',
                    $value['employeescommutings']['id']
                ];

                array_push($employeesCommutingArray, $employeesCommutingObject);
                $collmnIndex++;
            }
        }

        return $employeesCommutingArray;
    }
}

if (!function_exists('getDataForWasteDisposelSheet')) {
    function getDataForWasteDisposelSheet($companyId, $sheet)
    {
        $titleCollumn = ['Waste type', 'Type', 'Amount (tonnes)'];
        // $titleCollumn = ['Waste type', 'Amount (tonnes)'];
        $wasteDisposalArray = [$titleCollumn];
        setTitleDesign($sheet, 'Waste disposal', $titleCollumn, 'A1', '1');
        $sheet = titleCollumnDesign($sheet, $titleCollumn);

        $wasteDisposalData = UserEmissionWasteDisposal::where('company_id', $companyId)->with('wastedisposal')->get()->toArray();
        $collmnIndex = 2;
        foreach ($wasteDisposalData as $value) {
            if (isset($value['wastedisposal'])) {
                subCollumnDesignset($sheet, $titleCollumn, $collmnIndex);
                subCollumnProtectionset($sheet, $titleCollumn, $collmnIndex, "G");
                $wasteDisposalObject = [
                    $value['wastedisposal']['waste_type'],
                    $value['wastedisposal']['type'],
                    '',
                    '',
                    '',
                    '',
                    $value['wastedisposal']['id']
                ];

                array_push($wasteDisposalArray, $wasteDisposalObject);
                $collmnIndex++;
            }
        }
        return $wasteDisposalArray;
    }
}

if (!function_exists('getDataForRefrigerantsSheet')) {
    function getDataForRefrigerantsSheet($companyId, $sheet)
    {
        $titleCollumn = ['Type','Emission', 'Unit', 'Amount (kg)'];
        // $titleCollumn = ['Emission', 'Unit', 'Amount (kg)'];
        $refrigerantArray = [$titleCollumn];
        setTitleDesign($sheet, 'Refrigerant and others', $titleCollumn, 'A1', '1');
        $sheet = titleCollumnDesign($sheet, $titleCollumn);

        $refrigerantData = UserEmissionRefrigerant::with('refrigerants')->where('company_id', $companyId)->get()->toArray();

        $collmnIndex = 2;
        foreach ($refrigerantData as $value) {
            if (isset($value['refrigerants'])) {
                subCollumnDesignset($sheet, $titleCollumn, $collmnIndex);
                subCollumnProtectionset($sheet, $titleCollumn, $collmnIndex, "G");
                $refrigerantObject = [
                    $value['refrigerants']['type'],
                    $value['refrigerants']['emission'],
                    $value['refrigerants']['unit'],
                    '',
                    '',
                    '',
                    $value['refrigerants']['id']
                ];
                array_push($refrigerantArray, $refrigerantObject);

                $collmnIndex++;
            }
        }

        return $refrigerantArray;
    }
}

if (!function_exists('getDataForOwnedVehiclesSheet')) {
    function getDataForOwnedVehiclesSheet($companyId, $sheet)
    {

        $titleCollumn = ['Vehicle', 'Type', 'Fuel', 'Distance (km)', '', '', '','Vehicle', 'Type', 'Fuel', 'Distance (km)'];
        
        $vehicleArray = [$titleCollumn];
        setTitleDesign($sheet, 'Own or controlled vehicles', $titleCollumn, 'A1', '1');
        freightingGoodsSubTitleCollumnDesign($sheet, 'Passenger vehicles', 'A2', 'F2');
        freightingGoodsSubTitleCollumnDesign($sheet, 'Delivery vehicles', 'H2', 'L2');
        $sheet = freightingGoodsTitleCollumnDesign($sheet, $titleCollumn);
        $vehicleData = UserEmissionVehicle::with('vehicles')->where('company_id', $companyId)->get()->toArray();
        $passangerVehicleArray = [];
        $deliveryVehicleArray = [];
        foreach ($vehicleData as $value) {
            if (isset($value['vehicles'])) {
                $vehicleType = $value['vehicles']['vehicle_type'];
                if ($vehicleType == '1') {
                    array_push($passangerVehicleArray, $value);
                } else {
                    array_push($deliveryVehicleArray, $value);
                }
            }
        }

        $maxValue = max(count($passangerVehicleArray), count($deliveryVehicleArray));
        $collmnIndex = 3;
        for ($i = 0; $i < $maxValue; $i++) {
            $passengerVehicle = $passangerVehicleArray[$i] ?? null;
            $deliveryVehicle = $deliveryVehicleArray[$i] ?? null;
            ownVehicleSubCollumnDesignset($sheet, $titleCollumn, $collmnIndex, $passengerVehicle, $deliveryVehicle);
            subCollumnProtectionsetOwnedVehicle($sheet, $titleCollumn, $collmnIndex, $passengerVehicle, $deliveryVehicle,  $i, ['F','M']);
            $vehicleObject = [
                isset($passengerVehicle['vehicles']['vehicle']) ? $passengerVehicle['vehicles']['vehicle'] : '',
                isset($passengerVehicle['vehicles']['type']) ? $passengerVehicle['vehicles']['type'] : '',
                isset($passengerVehicle['vehicles']['fuel']) ? $passengerVehicle['vehicles']['fuel'] : '',
                '',
                '',
                isset($passengerVehicle['vehicles']['id']) ? $passengerVehicle['vehicles']['id'] : '',
                '',
                isset($deliveryVehicle['vehicles']['vehicle']) ? $deliveryVehicle['vehicles']['vehicle'] : '',
                isset($deliveryVehicle['vehicles']['type']) ? $deliveryVehicle['vehicles']['type'] : '',
                isset($deliveryVehicle['vehicles']['fuel']) ? $deliveryVehicle['vehicles']['fuel'] : '',
                '',
                '',
                isset($deliveryVehicle['vehicles']['id']) ? $deliveryVehicle['vehicles']['id'] : '',
            ];

            array_push($vehicleArray, $vehicleObject);
            $collmnIndex++;
        }

        return $vehicleArray;
    }
}

if (!function_exists('getDataForWTTFulesSheet')) {
    function getDataForWTTFulesSheet($companyId, $sheet)
    {
        $wttFulesData = UserEmissionWttFule::where('company_id', $companyId)->with('wttfules')->get()->toArray();
        $titleCollumn = ['Type', 'Fuel', 'Unit', 'Amount'];
        setTitleDesign($sheet, 'Well to tank (WTT) - fuels', $titleCollumn, 'A1', '1');
        $wttFulesArray = [$titleCollumn];
        $sheet = titleCollumnDesign($sheet, $titleCollumn);
        $collmnIndex = 2;
        foreach ($wttFulesData as $value) {
            if (isset($value['wttfules'])) {
                subCollumnDesignset($sheet, $titleCollumn, $collmnIndex);
                subCollumnProtectionset($sheet, $titleCollumn, $collmnIndex, "G");
                $wttFulesObject = [
                    $value['wttfules']['type'],
                    $value['wttfules']['fuel'],
                    $value['wttfules']['unit'],
                    '',
                    '',
                    '',
                    $value['wttfules']['id']
                ];
                array_push($wttFulesArray, $wttFulesObject);
                $collmnIndex++;
            }
        }

        return $wttFulesArray;
    }
}
if (!function_exists('getDataForTandDSheet')) {
    function getDataForTandDSheet($companyId, $sheet)
    {
        $transmissionAndDistributionData = UserEmissionTransmissionAndDistribution::where('company_id', $companyId)->with('transmissionanddistribution')->get()->toArray();
        $titleCollumn = ['Activity', 'Unit', 'Amount'];
        setTitleDesign($sheet, 'Transmission and distribution', $titleCollumn, 'A1', '1');

        $transmissionAndDistributionArray = [$titleCollumn];
        $sheet = titleCollumnDesign($sheet, $titleCollumn);
        $collmnIndex = 2;
        foreach ($transmissionAndDistributionData as $key => $value) {
            if (isset($value['transmissionanddistribution'])) {
                subCollumnDesignset($sheet, $titleCollumn, $collmnIndex);
                subCollumnProtectionset($sheet, $titleCollumn, $collmnIndex, "G");
                $transmissionAndDistributionObject = [
                    $value['transmissionanddistribution']['activity'],
                    $value['transmissionanddistribution']['unit'],
                    '',
                    '',
                    '',
                    '',
                    $value['transmissionanddistribution']['id']
                ];

                array_push($transmissionAndDistributionArray, $transmissionAndDistributionObject);
                $collmnIndex++;
            }
        }

        return $transmissionAndDistributionArray;
    }
}

if (!function_exists('getDataForWaterSheet')) {
    function getDataForWaterSheet($companyId, $sheet)
    {
        $watersupplytreatmentData = UserEmissionWatersupplytreatment::where('company_id', $companyId)->with('watersupplytreatments')->get()->toArray();

        $titleColumn = ['Type', 'Unit', 'Amount'];
        $waterSupplyArray = [];
        $waterTretmentArray = [];
        $watersupplytreatmentArray = [];
        $currentRowIndex = 3;
        $collmnIndex = 3;
        setTitleDesign($sheet, 'Water', $titleColumn, 'A1', '1');
        foreach ($watersupplytreatmentData as $key => $value) {
            if (isset($value['watersupplytreatments'])) {
                if ($value['watersupplytreatments']['type'] == 'Water Supply') {
                    $waterSupplyArray[] = $value['watersupplytreatments'];
                } else {
                    $waterTretmentArray[] = $value['watersupplytreatments'];
                }
            } else {
                $waterSupplyArray[] = '';
                $waterTretmentArray[] = '';
            }
        }

        $totalNumberofCollumn = count($titleColumn) - 1;
        $sheet->mergeCells('A1:' . Config::get('constants.collumn')[$totalNumberofCollumn] . '1');
        $sheet->getStyle('A1')->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle('A1')->getFont()->getColor()->setARGB('ff1f4e78');
        if (count($waterSupplyArray) > 0) {
            $sheet->setCellValue('A2', 'Water supply');
            $totalNumberofCollumn = count($titleColumn) - 1;
            $sheet->mergeCells('A2:' . Config::get('constants.collumn')[$totalNumberofCollumn] . '2');
            $sheet->getStyle('A2')->getFont()->setSize(12)->setBold(true);
            $sheet->getStyle('A2')->getFont()->getColor()->setARGB('ff1f4e78');

            $watersupplytreatmentArray[] = ['', '', '', '', ''];
            $sheet = waterTitleCollumnDesign($sheet, $titleColumn, $currentRowIndex);
            $watersupplytreatmentArray[] = $titleColumn;
            foreach ($waterSupplyArray as $key => $value) {
                $watersupplytreatmentObject = [
                    $value['type'],
                    $value['unit'],
                    '',
                    '',
                    '',
                    '',
                    $value['id'],
                ];
                $watersupplytreatmentArray[] = $watersupplytreatmentObject;
                $sheet = subCollumnDesignset($sheet, $titleColumn, $collmnIndex);
                subCollumnProtectionset($sheet, $titleColumn, $collmnIndex, "G");
                $collmnIndex++;
            }
            $watersupplytreatmentArray[] = ['', '', '', '', '', '', ''];
        }

        if (count($waterTretmentArray) > 0) {
            $userEmissionTotal = count($watersupplytreatmentArray) + 2;
            $watersupplytreatmentArray[] = ['', '', '', '', '', '', ''];
            $sheet->setCellValue('A' . $userEmissionTotal, 'Water treatment');

            $totalNumberofCollumn = count($titleColumn) - 1;
            $sheet->mergeCells('A' . $userEmissionTotal . ':' . Config::get('constants.collumn')[$totalNumberofCollumn] . $userEmissionTotal);
            $sheet->getStyle('A' . $userEmissionTotal)->getFont()->setSize(12)->setBold(true);
            $sheet->getStyle('A' . $userEmissionTotal)->getFont()->getColor()->setARGB('ff1f4e78');

            $sheet = waterTitleCollumnDesign($sheet, $titleColumn, $userEmissionTotal + 1);
            $watersupplytreatmentArray[] = $titleColumn;
            foreach ($waterTretmentArray as $key => $value) {
                $watersupplytreatmentObject = [
                    $value['type'],
                    $value['unit'],
                    '',
                    '',
                    '',
                    '',
                    $value['id'],
                ];
                $watersupplytreatmentArray[] = $watersupplytreatmentObject;
                $sheet = subCollumnDesignset($sheet, $titleColumn, $userEmissionTotal + 1);
                subCollumnProtectionset($sheet, $titleColumn, $userEmissionTotal + 1, "G");
                $userEmissionTotal++;
            }
        }

        return $watersupplytreatmentArray;
    }
}


if (!function_exists('getDataForMaterialUseSheet')) {
    function getDataForMaterialUseSheet($companyId, $sheet)
    {
        $materialUseData = UserEmissionMaterialUse::where('company_id', $companyId)->with('materialuses')->get()->toArray();
        $titleCollumn = ['Activity', 'Waste type', 'Amount (tonnes)'];
        setTitleDesign($sheet, 'Material use', $titleCollumn, 'A1', '1');
        $materialUseArray = [$titleCollumn];
        $sheet = titleCollumnDesign($sheet, $titleCollumn);
        $collmnIndex = 2;

        foreach ($materialUseData as $value) {
            if (isset($value['materialuses'])) {
                subCollumnDesignset($sheet, $titleCollumn, $collmnIndex);
                subCollumnProtectionset($sheet, $titleCollumn, $collmnIndex, "G");
                $materialUseObject = [
                    $value['materialuses']['activity'],
                    $value['materialuses']['waste_type'],
                    '',
                    '',
                    '',
                    '',
                    $value['materialuses']['id']
                ];
                array_push($materialUseArray, $materialUseObject);
                $collmnIndex++;
            }
        }
        return $materialUseArray;
    }
}

if (!function_exists('getDataForElectricityHeatCoolingUseSheet')) {
    function getDataForElectricityHeatCoolingUseSheet($companyId, $sheet)
    {
        $UserEmissionelectricityData =  UserEmissionElectricity::where('company_id', $companyId)->with('electricity', 'electricity.country')->get()->toArray();
        $typeOneArray = [];
        $typeTwoArray = [];
        $typeThreeArray = [];
        $UserEmissionelectricityArray = [];
        $titleOneAndThreeObject = [
            'Activity',
            'Country',
            'Unit',
            'Amount'
        ];
        $titleTwoObject = [
            'Activity',
            'Type',
            'Unit',
            'Amount'
        ];
        setTitleDesign($sheet, 'Electricity and heating', $titleOneAndThreeObject, 'A1', '1');

        foreach ($UserEmissionelectricityData as $key => $value) {
            if ($value['electricity']['electricity_type'] == 1) {
                $typeOneArray[] = $value['electricity'];
            } elseif ($value['electricity']['electricity_type'] == 2) {
                $typeTwoArray[] = $value['electricity'];
            } else {
                $typeThreeArray[] = $value['electricity'];
            }
        }

        $currentRowIndex = 3;
        $collmnIndex = 3;
        if (count($typeOneArray) > 0) {
            $sheet->setCellValue('A2', 'Electricity Grid');
            $totalNumberofCollumn = count($titleOneAndThreeObject) - 1;
            $sheet->mergeCells('A2:' . Config::get('constants.collumn')[$totalNumberofCollumn] . '2');
            $sheet->getStyle('A2')->getFont()->setSize(12)->setBold(true);
            $sheet->getStyle('A2')->getFont()->getColor()->setARGB('ff1f4e78');

            $UserEmissionelectricityArray[] = ['', '', '', '', ''];
            $sheet = electricityTitleCollumnDesign($sheet, $titleOneAndThreeObject, $currentRowIndex);
            $UserEmissionelectricityArray[] = $titleOneAndThreeObject;

            foreach ($typeOneArray as $key => $value) {
                $dataObject = [
                    $value['activity'],
                    $value['country']['name'],
                    $value['unit'],
                    '',
                    '',
                    '',
                    $value['id'],
                ];
                $UserEmissionelectricityArray[] = $dataObject;
                $sheet = electricitySubCollumnDesignset($sheet, $titleOneAndThreeObject, $collmnIndex);
                subCollumnProtectionset($sheet, $titleOneAndThreeObject, $collmnIndex, "G");
                $collmnIndex++;
            }
            $UserEmissionelectricityArray[] = ['', '', '', '', ''];
        }


        if (count($typeTwoArray) > 0) {
            $userEmissionTotal = count($UserEmissionelectricityArray) + 2;
            $UserEmissionelectricityArray[] = ['', '', '', '', ''];
            $sheet->setCellValue('A' . $userEmissionTotal, 'Heat and steam');

            $totalNumberofCollumn = count($titleTwoObject) - 1;
            $sheet->mergeCells('A' . $userEmissionTotal . ':' . Config::get('constants.collumn')[$totalNumberofCollumn] . $userEmissionTotal);
            $sheet->getStyle('A' . $userEmissionTotal)->getFont()->setSize(12)->setBold(true);
            $sheet->getStyle('A' . $userEmissionTotal)->getFont()->getColor()->setARGB('ff1f4e78');

            $sheet = electricityTitleCollumnDesign($sheet, $titleTwoObject, $userEmissionTotal + 1);
            $UserEmissionelectricityArray[] = $titleTwoObject;

            foreach ($typeTwoArray as $value) {
                $dataObject = [
                    $value['activity'],
                    $value['type'],
                    $value['unit'],
                    '',
                    '',
                    '',
                    $value['id'],
                ];
                $UserEmissionelectricityArray[] = $dataObject;
                $sheet = electricitySubCollumnDesignset($sheet, $titleTwoObject, $userEmissionTotal + 1);
                subCollumnProtectionset($sheet, $titleTwoObject, $userEmissionTotal + 1, "G");
                $userEmissionTotal++;
            }

            $UserEmissionelectricityArray[] = ['', '', '', '', '', '', ''];
        }


        if (count($typeThreeArray) > 0) {
            $userEmissionTotal = count($UserEmissionelectricityArray) + 2;
            $UserEmissionelectricityArray[] = ['', '', '', '', '', '', ''];
            $sheet->setCellValue('A' . $userEmissionTotal, 'District cooling');

            $totalNumberofCollumn = count($titleOneAndThreeObject) - 1;
            $sheet->mergeCells('A' . $userEmissionTotal . ':' . Config::get('constants.collumn')[$totalNumberofCollumn] . $userEmissionTotal);
            $sheet->getStyle('A' . $userEmissionTotal)->getFont()->setSize(12)->setBold(true);
            $sheet->getStyle('A' . $userEmissionTotal)->getFont()->getColor()->setARGB('ff1f4e78');
            $sheet = electricityTitleCollumnDesign($sheet, $titleOneAndThreeObject, $userEmissionTotal + 1);
            $UserEmissionelectricityArray[] = $titleOneAndThreeObject;

            foreach ($typeThreeArray as $value) {
                $dataObject = [
                    $value['activity'],
                    $value['country']['name'],
                    $value['unit'],
                    '',
                    '',
                    '',
                    $value['id'],
                ];
                $UserEmissionelectricityArray[] = $dataObject;
                $sheet = electricitySubCollumnDesignset($sheet, $titleOneAndThreeObject, $userEmissionTotal + 1);
                subCollumnProtectionset($sheet, $titleOneAndThreeObject, $userEmissionTotal + 1, "G");
                $userEmissionTotal++;
            }
        }

        return $UserEmissionelectricityArray;
    }
}

if (!function_exists('getDataForFlightAndAccommodationUseSheet')) {
    function getDataForFlightAndAccommodationUseSheet($companyId, $sheet)
    {
        $titleCollumn = ['Origin (city or IATA code)', 'Destination (city or IATA code)', 'Class', 'Single way/ return', 'Number of passengers', 'Distance (km)', '', 'Country', 'Number of occupied rooms', 'Number of nights per room'];
        $flightAndAccommodationArray = [$titleCollumn];
        // setTitleDesign($sheet, 'Flight and Accommodation', $titleCollumn, 'A1', '1');
        freightingGoodsSubTitleCollumnDesign($sheet, 'Flights', 'A1', 'F1');
        freightingGoodsSubTitleCollumnDesign($sheet, 'Hotel', 'H1', 'J1');
        $sheet = flightAndAccommodationTitleCollumnDesign($sheet, $titleCollumn);
        $cityData = City::pluck('name')->toArray();
        // $countryData = Country::whereIn('name', ['United Arab Emirates'])->whereNotNull('hotel_factor')->whereNull('deleted_at')->pluck('name')->toArray();
        // $countryData = Country::where('name', 'United Arab Emirates')->whereNotNull('hotel_factor')->whereNull('deleted_at')->pluck('name')->toArray();
        $countryData = Country::whereNotNull('hotel_factor')->whereNull('deleted_at')->limit(25)->pluck('name')->toArray();
        $b = 3;
        $c = 2;

        // $countryString = 'Afghanistan,Åland Islands,Albania,Algeria,American Samoa,Andorra,Angola,Anguilla,Antarctica,Antigua and Barbuda,Argentina,Armenia,Aruba,Australia,Austria,Azerbaijan,Bahamas,Bahrain,Bangladesh,Barbados,Belarus,Belgium,Belize,Benin,Bermuda,Bhutan,Bolivia (Plurinational State of),Bonaire, Sint Eustatius and Saba,Bosnia and Herzegovina,Botswana,Bouvet Island,Brazil,British Indian Ocean Territory,British Virgin Islands,Brunei Darussalam,Bulgaria,Burkina Faso,Burundi,Cabo Verde,Cambodia,Cameroon,Canada,Cayman Islands,Central African Republic,Chad,Chile,China,China, Hong Kong Special Administrative Region,China, Macao Special Administrative Region,Christmas Island,Cocos (Keeling) Islands,Colombia,Comoros,Congo,Cook Islands,Costa Rica,Côte dIvoire,Croatia,Cuba,Curaçao,Cyprus,Czechia,Democratic Peoples Republic of Korea,Democratic Republic of the Congo,Denmark,Djibouti,Dominica,Dominican Republic,Ecuador,Egypt,El Salvador,Equatorial Guinea,Eritrea,Estonia,Eswatini,Ethiopia,Falkland Islands (Malvinas),Faroe Islands,Fiji,Finland,France,French Guiana,French Polynesia,French Southern Territories,Gabon,Gambia,Georgia,Germany,Ghana,Gibraltar,Greece,Greenland,Grenada,Guadeloupe,Guam,Guatemala,Guernsey,Guinea,Guinea-Bissau,Guyana,Haiti,Heard Island and McDonald Islands,Holy See,Honduras,Hungary,Iceland,India,Indonesia,Iran (Islamic Republic of),Iraq,Ireland,Isle of Man,Israel,Italy,Jamaica,Japan,Jersey,Jordan,Kazakhstan,Kenya,Kiribati,Kuwait,Kyrgyzstan,Lao Peoples Democratic Republic,Latvia,Lebanon,Lesotho,Liberia,Libya,Liechtenstein,Lithuania,Luxembourg,Madagascar,Malawi,Malaysia,Maldives,Mali,Malta,Marshall Islands,Martinique,Mauritania,Mauritius,Mayotte,Mexico,Micronesia (Federated States of),Monaco,Mongolia,Montenegro,Montserrat,Morocco,Mozambique,Myanmar,Namibia,Nauru,Nepal,Netherlands,New Caledonia,New Zealand,Nicaragua,Niger,Nigeria,Niue,Norfolk Island,North Macedonia,Northern Mariana Islands,Norway,Oman,Pakistan,Palau,Panama,Papua New Guinea,Paraguay,Peru,Philippines,Pitcairn,Poland,Portugal,Puerto Rico,Qatar,Republic of Korea,Republic of Moldova,Réunion,Romania,Russian Federation,Rwanda,Saint Barthélemy,Saint Helena,Saint Kitts and Nevis,Saint Lucia,Saint Martin (French Part),Saint Pierre and Miquelon,Saint Vincent and the Grenadines,Samoa,San Marino,Sao Tome and Principe,Sark,Saudi Arabia,Senegal,Serbia,Seychelles,Sierra Leone,Singapore,Sint Maarten (Dutch part),Slovakia,Slovenia,Solomon Islands,Somalia,South Africa,South Georgia and the South Sandwich Islands,South Sudan,Spain,Sri Lanka,State of Palestine,Sudan,Suriname,Svalbard and Jan Mayen Islands,Sweden,Switzerland,Syrian Arab Republic,Tajikistan,Thailand,Timor-Leste,Togo,Tokelau,Tonga,Trinidad and Tobago,Tunisia,Turkey,Turkmenistan,Turks and Caicos Islands,Tuvalu,Uganda,Ukraine,United Arab Emirates,United Kingdom of Great Britain and Northern Ireland,United Republic of Tanzania,United States Minor Outlying Islands,United States of America,United States Virgin Islands,Uruguay,Uzbekistan,Vanuatu,Venezuela (Bolivarian Republic of),Viet Nam,Wallis and Futuna Islands,Western Sahara,Yemen,Zambia,Zimbabwe';
        // $countryArray = explode(',', $countryString);
        // $countryCount = count($countryArray);
        // $i = 1;
        // foreach($countryArray as $country)
        // {
        //     $sheet->setCellValue('S'.$i, $country);
        //     $sheet->getStyle('S'.$i)->getFont()->setColor(new Color(Color::COLOR_WHITE));
        //     $i++;
        // }
        
        // $validation = $sheet->getCell('T1')
        // ->getDataValidation();
        // $validation->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
        // $validation->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION );
        // $validation->setAllowBlank(false);
        // $validation->setShowInputMessage(true);
        // $validation->setShowErrorMessage(true);
        // $validation->setShowDropDown(true);
        // $validation->setFormula1('\'Flight and Accommodation\'!$S$1:$S$'.$countryCount);

    
        for($i = 0; $i<=94; $i++)
        {
            $flightObject = [
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
            ];
            flightSubColumnProtectionSet($sheet, $titleCollumn, $c);

    
            //setDropDown($sheet, $cityData,  'A'.$b);
            //setDropDown($sheet, $cityData,  'B'.$b);

            setDropDown($sheet, ['Economy Class', 'Premium Economy Class', 'First Class', 'Business Class'],  'C'.$b);
            setDropDown($sheet, ['One Way', 'Two Way'],  'D'.$b);
            countryDropDown($sheet, 'H' . $b);
            // setDropDown($sheet, $countryData, 'H' . $b);

            // setDropDown($sheet, ['Bharat', 'England', 'Canada', 'USA'], 'H' . $b);
            flightAccommodationSubCollumnDesignset($sheet, $titleCollumn, $c);
            $flightAndAccommodationArray[] = $flightObject;
            $b++;
            $c++;
        }
        
        return $flightAndAccommodationArray;
    }
}

if (!function_exists('countryDropDown')) {
    function countryDropDown($sheet, $cell)
    {
        $countryString = Config::get('constants.country');
        $countryArray = explode(',', $countryString);
        $countryCount = count($countryArray);
        $i = 1;
        foreach($countryArray as $country)
        {
            $sheet->setCellValue('S'.$i, $country);
            $sheet->getStyle('S'.$i)->getFont()->setColor(new Color(Color::COLOR_WHITE));
            $i++;
        }
        
        $validation = $sheet->getCell($cell)
        ->getDataValidation();
        $validation->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
        $validation->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION );
        $validation->setAllowBlank(false);
        $validation->setShowInputMessage(true);
        $validation->setShowErrorMessage(true);
        $validation->setShowDropDown(true);
        $validation->setFormula1('\'Flight and Accommodation\'!$S$1:$S$'.$countryCount);
        return $validation;
    }
}

if (!function_exists('flightAccommodationSubCollumnDesignset')) {
    function flightAccommodationSubCollumnDesignset($sheet, $titleCollumn, $collmnIndex)
    {
        for ($i = 0; $i < count($titleCollumn); $i++) {
            if($titleCollumn[$i] != '' &&  ($i <= 5 && $collmnIndex <= 97) ||
            ($i > 6 && $collmnIndex <= 97))
            {
                boderColumnDesignSet($i, $collmnIndex, $sheet);
            }            
        }

        return $sheet;
    }
}

if (!function_exists('titleCollumnDesign')) {
    function titleCollumnDesign($sheet, $titleCollumn)
    {
        for ($i = 0; $i < count($titleCollumn); $i++) {
            if ($titleCollumn[$i] != '') {
                $sheet->getColumnDimension(Config::get('constants.collumn')[$i])->setAutoSize(true);

                $sheet->getRowDimension(2)->setRowHeight(Config::get('constants.titleCollumnRowHeight'));
                $cellCoordinate = Config::get('constants.collumn')[$i] . '2';

                //title  style add
                $style = $sheet->getStyle($cellCoordinate);

                $style->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);
                $style->getFont()->setSize(Config::get('constants.titleFontSize'))->setBold(true);

                // Set the fill type to solid and the custom ARGB color
                $sheet->getStyle($cellCoordinate)->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB(Config::get('constants.titleCollumnColor')); // Custom color in ARGB format: #FF8496B0
                $sheet->getStyle($cellCoordinate)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            }
        }

        return $sheet;
    }
}



if (!function_exists('homeOfficeTitleCollumnDesign')) {
    function homeOfficeTitleCollumnDesign($sheet, $titleCollumn)
    {
        for ($i = 0; $i < count($titleCollumn); $i++) {
            if ($titleCollumn[$i] != '') {
                if(Config::get('constants.collumn')[$i] == 'A')
                {
                    $sheet->getColumnDimension(Config::get('constants.collumn')[$i])->setWidth(20);
                }else if(Config::get('constants.collumn')[$i] == 'C')
                {
                    $sheet->getColumnDimension(Config::get('constants.collumn')[$i])->setWidth(20);
                } else 
                {
                    $sheet->getColumnDimension(Config::get('constants.collumn')[$i])->setAutoSize(true);
                }
                

                $sheet->getRowDimension(2)->setRowHeight(Config::get('constants.titleCollumnRowHeight'));
                $cellCoordinate = Config::get('constants.collumn')[$i] . '2';

                //title  style add
                $style = $sheet->getStyle($cellCoordinate);

                $style->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);
                $style->getFont()->setSize(Config::get('constants.titleFontSize'))->setBold(true);

                // Set the fill type to solid and the custom ARGB color
                $sheet->getStyle($cellCoordinate)->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB(Config::get('constants.titleCollumnColor')); // Custom color in ARGB format: #FF8496B0
                $sheet->getStyle($cellCoordinate)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            }
        }

        return $sheet;
    }
}

if (!function_exists('flightAndAccommodationTitleCollumnDesign')) {
    function flightAndAccommodationTitleCollumnDesign($sheet, $titleCollumn)
    {
        for ($i = 0; $i < count($titleCollumn); $i++) {
            if ($titleCollumn[$i] != '') {
               
                if(Config::get('constants.collumn')[$i] == 'C')
                {
                    $sheet->getColumnDimension(Config::get('constants.collumn')[$i])->setWidth(25);
                } else if(Config::get('constants.collumn')[$i] == 'H')
                {
                    $sheet->getColumnDimension(Config::get('constants.collumn')[$i])->setWidth(35);
                } else 
                {
                    $sheet->getColumnDimension(Config::get('constants.collumn')[$i])->setAutoSize(true);
                }
                
                $sheet->getRowDimension(2)->setRowHeight(Config::get('constants.titleCollumnRowHeight'));
                $cellCoordinate = Config::get('constants.collumn')[$i] . '2';

                //title  style add
                $style = $sheet->getStyle($cellCoordinate);

                $style->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);
                $style->getFont()->setSize(Config::get('constants.titleFontSize'))->setBold(true);

                // Set the fill type to solid and the custom ARGB color
                $sheet->getStyle($cellCoordinate)->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB(Config::get('constants.titleCollumnColor')); // Custom color in ARGB format: #FF8496B0
                $sheet->getStyle($cellCoordinate)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            }
        }
        
        return $sheet;
    }
}

if (!function_exists('electricityTitleCollumnDesign')) {
    function electricityTitleCollumnDesign($sheet, $titleCollumn, $collmnIndex)
    {

        for ($i = 0; $i < count($titleCollumn); $i++) {
            $sheet->getColumnDimension(Config::get('constants.collumn')[$i])->setAutoSize(true);

            $sheet->getRowDimension($collmnIndex)->setRowHeight(Config::get('constants.titleCollumnRowHeight'));
            $cellCoordinate = Config::get('constants.collumn')[$i] . $collmnIndex;

            //title  style add
            $style = $sheet->getStyle($cellCoordinate);

            $style->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER);
            $style->getFont()->setSize(Config::get('constants.titleFontSize'))->setBold(true);

            // Set the fill type to solid and the custom ARGB color
            $sheet->getStyle($cellCoordinate)->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB(Config::get('constants.titleCollumnColor')); // Custom color in ARGB format: #FF8496B0

            $sheet->getStyle($cellCoordinate)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        }

        return $sheet;
    }
}

if (!function_exists('electricitySubCollumnDesignset')) {
    function electricitySubCollumnDesignset($sheet, $titleCollumn, $collmnIndex)
    {
        for ($i = 0; $i < count($titleCollumn); $i++) {
            boderColumnDesignSet($i, $collmnIndex, $sheet);
            if (!strstr($titleCollumn[$i], 'Amount') || !strstr($titleCollumn[$i], '')) {
                collumnDesignSet($i, $collmnIndex, $sheet);
            }
        }

        return $sheet;
    }
}

if (!function_exists('subCollumnDesignset')) {
    function subCollumnDesignset($sheet, $titleCollumn, $collmnIndex)
    {
        for ($i = 0; $i < count($titleCollumn); $i++) {
            boderColumnDesignSet($i, $collmnIndex, $sheet);
            if (!strstr($titleCollumn[$i], 'Amount') && !strstr($titleCollumn[$i], 'Total distance')) {
                collumnDesignSet($i, $collmnIndex, $sheet);
            }
        }

        return $sheet;
    }
}


if (!function_exists('ownVehicleSubCollumnDesignset')) {
    function ownVehicleSubCollumnDesignset($sheet, $titleCollumn, $collmnIndex, $passengerVehicle, $deliveryVehicle)
    {
        for ($i = 0; $i < count($titleCollumn); $i++) {
            if($titleCollumn[$i] != '' &&  ($i <= 3 && isset($passengerVehicle['vehicles']['vehicle'])) ||
            ($i > 6 && isset($deliveryVehicle['vehicles']['vehicle'])))
            {
                boderColumnDesignSet($i, $collmnIndex, $sheet);
            }
            
            if (!strstr($titleCollumn[$i], 'Distance (km)') || !strstr($titleCollumn[$i], '')) {
                if (
                    ($i <= 3 && isset($passengerVehicle['vehicles']['vehicle'])) ||
                    ($i > 6 && isset($deliveryVehicle['vehicles']['vehicle']))
                ) {
                    collumnDesignSet($i, $collmnIndex, $sheet);
                }
            }
        }

        return $sheet;
    }
}

if (!function_exists('freightingGoodsSubCollumnDesignset')) {
    function freightingGoodsSubCollumnDesignset($sheet, $titleCollumn, $collmnIndex, $freightingGoodsVansHgvsData, $freightingGoodsFlightData, $currentIndex)
    {
        for ($i = 0; $i < count($titleCollumn); $i++) {
            if (($i <= 3 &&  $freightingGoodsVansHgvsData - 1 >= $currentIndex) || ($i > 6 &&  $freightingGoodsFlightData - 1 >= $currentIndex)) {
                boderColumnDesignSet($i, $collmnIndex, $sheet);
            }

            if (($i <= 3 &&  $freightingGoodsVansHgvsData - 1 >= $currentIndex &&  !strstr($titleCollumn[$i], 'Distance (km)')) || ($i > 6 &&  $freightingGoodsFlightData - 1 >= $currentIndex  &&  !strstr($titleCollumn[$i], 'Tonne.km'))) {
                collumnDesignSet($i, $collmnIndex, $sheet);
            }
        }

        return $sheet;
    }
}

if (!function_exists('collumnDesignSet')) {
    function collumnDesignSet($index, $collmnIndex, $sheet)
    {
        $cellCoordinate = Config::get('constants.collumn')[$index] . $collmnIndex + 1;
        $sheet->getStyle($cellCoordinate)->getFont()->setSize(Config::get('constants.valueFontSize'));
        $sheet->getStyle($cellCoordinate)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB(Config::get('constants.valueCollumnColor'));
        $sheet->getStyle($cellCoordinate)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    }
}

if (!function_exists('boderColumnDesignSet')) {
    function boderColumnDesignSet($index, $collmnIndex, $sheet)
    {
        $cellCoordinate = Config::get('constants.collumn')[$index] . $collmnIndex + 1;
        $sheet->getStyle($cellCoordinate)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        return $sheet;
    }
}


if (!function_exists('waterTitleCollumnDesign')) {
    function waterTitleCollumnDesign($sheet, $titleCollumn, $collmnIndex)
    {
        for ($i = 0; $i < count($titleCollumn); $i++) {
            $sheet->getColumnDimension(Config::get('constants.collumn')[$i])->setAutoSize(true);

            $sheet->getRowDimension($collmnIndex)->setRowHeight(Config::get('constants.titleCollumnRowHeight'));
            $cellCoordinate = Config::get('constants.collumn')[$i] . $collmnIndex;

            //title  style add
            $style = $sheet->getStyle($cellCoordinate);

            $style->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER);
            $style->getFont()->setSize(Config::get('constants.titleFontSize'))->setBold(true);

            // Set the fill type to solid and the custom ARGB color
            $sheet->getStyle($cellCoordinate)->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB(Config::get('constants.titleCollumnColor')); // Custom color in ARGB format: #FF8496B0
        }

        return $sheet;
    }
}


if (!function_exists('setTitleDesign')) {
    function setTitleDesign($sheet, $title, $titleCollumn, $cell, $endCollumn)
    {
        $sheet->setCellValue($cell, $title);
        $totalNumberofCollumn = count($titleCollumn) - 1;
        $sheet->mergeCells($cell . ':' . Config::get('constants.collumn')[$totalNumberofCollumn] . $endCollumn);
        $sheet->getStyle($cell)->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle($cell)->getFont()->getColor()->setARGB(Config::get('constants.titleFontColor'));
        return $sheet;
    }
}


if (!function_exists('freightingGoodsTitleCollumnDesign')) {
    function freightingGoodsTitleCollumnDesign($sheet, $titleCollumn)
    {
        for ($i = 0; $i < count($titleCollumn); $i++) {
            if ($titleCollumn[$i] != '') {
                $sheet->getColumnDimension(Config::get('constants.collumn')[$i])->setAutoSize(true);

                $sheet->getRowDimension(3)->setRowHeight(Config::get('constants.titleCollumnRowHeight'));
                $cellCoordinate = Config::get('constants.collumn')[$i] . '3';

                //title  style add
                $style = $sheet->getStyle($cellCoordinate);

                $style->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);
                $style->getFont()->setSize(Config::get('constants.titleFontSize'))->setBold(true);

                // Set the fill type to solid and the custom ARGB color
                $sheet->getStyle($cellCoordinate)->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB(Config::get('constants.titleCollumnColor')); // Custom color in ARGB format: #FF8496B0
                $sheet->getStyle($cellCoordinate)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            }
        }

        return $sheet;
    }
}

if (!function_exists('freightingGoodsSubTitleCollumnDesign')) {
    function freightingGoodsSubTitleCollumnDesign($sheet, $title, $cellOne, $cellTwo)
    {
        $sheet->setCellValue($cellOne, $title);
        $sheet->mergeCells($cellOne . ':' . $cellTwo);
        $sheet->getStyle($cellOne)->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle($cellOne)->getFont()->getColor()->setARGB('ff1f4e78');
        return $sheet;
    }
}

//Home Office tab design set function
if (!function_exists('getDataForHomeOfficeUseSheet')) {
    function getDataForHomeOfficeUseSheet($companyId, $sheet)
    {
        $titleCollumn = ['Type', 'Type of home office', 'Country', 'Unit', 'Number of employees', 'Working time(For full-time: 100%)', '% working from home (e.g. 50% from home)', 'Number of months'];
        $homeOfficeArray = [$titleCollumn];
        setTitleDesign($sheet, 'Home Office', $titleCollumn, 'A1', '1');
        $comment = $sheet->getComment('E2');        
        $comment->getText()->createTextRun("40h/week: 100%\n30h/week: 75%\n20h/week: 50%");
        $comment->setAuthor('CO2MENA'); 
        $commentF = $sheet->getComment('F2');        
        $commentF->getText()->createTextRun("e.g. I work 3 days from home and 2 from the office. \nEntry: 40%");
        $commentF->setAuthor('CO2MENA');
        
        // $sheet = titleCollumnDesign($sheet, $titleCollumn);
        $sheet = homeOfficeTitleCollumnDesign($sheet, $titleCollumn);
        // $countryData = Country::whereNull('deleted_at')->pluck('name')->toArray();
        // $countryData = Country::whereIn('name', ['United Arab Emirates', 'Qatar', 'Saudi Arabia'])->whereNull('deleted_at')->pluck('name')->toArray();        
        $countryData = Country::where('name', 'United Arab Emirates')->whereNull('deleted_at')->pluck('name')->toArray();
        $b = 3;
        $c = 2;
        for ($i = 0; $i <= 31; $i++) {
            $homeOfficeObject = [
                '',
                '',
                '',
                'kWh',
                '',
                '',
                '',
                ''
            ];

            homeOfficeSubColumnDesignset($sheet, $titleCollumn, $c);
            homeOfficeSubColumnProtectionSet($sheet, $titleCollumn, $c);
            setDropDown($sheet, ['Full Time WFH ', 'Part Time WFH '], 'A'.$b);
            setDropDown($sheet, ['No Heating No Cooling', 'With Cooling', 'With Heating'], 'B'.$b);
            setDropDown($sheet, $countryData, 'C' . $b);
            $b++;
            $c++;
            $homeOfficeArray[] = $homeOfficeObject;
        }

        return $homeOfficeArray;
    }
}


if (!function_exists('setDropDown')) {
    function setDropDown($sheet, $dropdownOptions, $cell)
    {
     
        $validation = $sheet->getCell($cell)
        ->getDataValidation();
        $validation->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
        $validation->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION );
        $validation->setAllowBlank(false);
        $validation->setShowInputMessage(true);
        $validation->setShowErrorMessage(true);
        $validation->setShowDropDown(true);
        // $validation->setAllowBlank(false);
        // $validation->setShowInputMessage(true);
        // $validation->setShowErrorMessage(true);
        // $validation->setShowDropDown(true);

        $validation->setFormula1('"' . implode(',', $dropdownOptions) . '"');

        return $validation;

        //running code
        // $validation = $sheet->getCell($cell)->getDataValidation();
        // $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
        // $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);

        // $validation->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION );

        // $validation->setShowDropDown(true);
        // $validation->setFormula1('"'.implode('","', $dropdownOptions).'"');
        // return $sheet;
    }
}

if (!function_exists('removeSpecialChars')) {
    function removeSpecialChars($str)
    {
        $charsToRemove = ['(', ')', ',', '/', '-', '.'," "];
        $cleanedStr = str_replace($charsToRemove, '', $str);
        return $cleanedStr;
    }
}

//Home Office Sub column 
if (!function_exists('homeOfficeSubColumnDesignset')) {
    function homeOfficeSubColumnDesignset($sheet, $titleColumn, $collmnIndex)
    {
        for ($i = 0; $i < count($titleColumn); $i++) {
            boderColumnDesignSet($i, $collmnIndex, $sheet);
            if (strstr($titleColumn[$i], 'Unit')) {
                collumnDesignSet($i, $collmnIndex, $sheet);
            }
        }

        return $sheet;
    }
}

if (!function_exists('subCollumnProtectionset')) {
    function subCollumnProtectionset($sheet, $titleCollumn, $collmnIndex, $column)
    {
        for ($i = 0; $i < count($titleCollumn); $i++) {
            if (strstr($titleCollumn[$i], 'Amount (tonnes)') || strstr($titleCollumn[$i], 'Amount') || strstr($titleCollumn[$i], 'Amount (kg)') || strstr($titleCollumn[$i], 'Total distance')) {
                collumnProtectionSet($i, $collmnIndex, $sheet, $column);
            }
        }

        return $sheet;
    }
}
if (!function_exists('collumnProtectionSet')) {
    function collumnProtectionSet($index, $collmnIndex, $sheet, $column)
    {
        $idColumn = $column.$collmnIndex + 1;
        $cellCoordinate = Config::get('constants.collumn')[$index] . $collmnIndex + 1;
        $sheet->getStyle($idColumn)->getFont()->getColor()->setRGB('FFFFFF');
        $columnDimension = $sheet->getColumnDimension($column)->setVisible(true);
        $sheet->getStyle($cellCoordinate)->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
    }
}
if (!function_exists('subCollumnProtectionsetTwoTable')) {
    function subCollumnProtectionsetTwoTable($sheet, $titleCollumn, $collmnIndex, $freightingGoodsVansHgvsData,  $freightingGoodsFlightData,  $currentIndex, $column)
    {
        for ($i = 0; $i < count($titleCollumn); $i++) {
            if (($freightingGoodsVansHgvsData - 1 >= $currentIndex &&  strstr($titleCollumn[$i], 'Distance (km)')) || ($freightingGoodsFlightData - 1 >= $currentIndex  &&  strstr($titleCollumn[$i], 'Tonne.km'))) {
                collumnProtectionSetTwoTable($i, $collmnIndex, $sheet, $column);
            }
        }

        return $sheet;
    }
}
if (!function_exists('subCollumnProtectionsetOwnedVehicle')) {
    function subCollumnProtectionsetOwnedVehicle($sheet, $titleCollumn, $collmnIndex, $passengerVehicle, $deliveryVehicle,  $currentIndex, $column)
    {
        for ($i = 0; $i < count($titleCollumn); $i++) {  
            if (strstr($titleCollumn[$i], 'Distance (km)')) {
                if (
                    ($i == 3 && isset($passengerVehicle['vehicles']['vehicle'])) ||
                    ($i ==10 && isset($deliveryVehicle['vehicles']['vehicle']))
                ) {
                    collumnProtectionSetTwoTable($i, $collmnIndex, $sheet, $column);
                }
            }
        }
        return $sheet;
    }
}
if (!function_exists('collumnProtectionSetTwoTable')) {
    function collumnProtectionSetTwoTable($index, $collmnIndex, $sheet, $column)
    {
        $cellCoordinate = Config::get('constants.collumn')[$index] . $collmnIndex + 1;
        $idColumn0 = $column[0].$collmnIndex + 1;
        $idColumn1 = $column[1].$collmnIndex + 1;
        $sheet->getStyle($idColumn0)->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle($idColumn1)->getFont()->getColor()->setRGB('FFFFFF');
        $columnDimension = $sheet->getColumnDimension($column[0])->setVisible(true);
        $columnDimension = $sheet->getColumnDimension($column[1])->setVisible(true);
        $sheet->getStyle($cellCoordinate)->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
    }
}
if (!function_exists('homeOfficeSubColumnProtectionSet')) {
    function homeOfficeSubColumnProtectionSet($sheet, $titleColumn, $collmnIndex)
    {
        for ($i = 0; $i < count($titleColumn); $i++) {
            if (strstr($titleColumn[$i], 'Type') || strstr($titleColumn[$i], 'Type of home office') || strstr($titleColumn[$i], 'Country') || strstr($titleColumn[$i], 'Number of employees') || strstr($titleColumn[$i], 'Working time(For full-time: 100%)') || strstr($titleColumn[$i], '% working from home (e.g. 50% from home)') || strstr($titleColumn[$i], 'Number of months')) {
                $cellCoordinate = Config::get('constants.collumn')[$i] . $collmnIndex + 1;
                $sheet->getStyle($cellCoordinate)->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
            }
        }
        return $sheet;
    }
}
if (!function_exists('flightSubColumnProtectionSet')) {
    function flightSubColumnProtectionSet($sheet, $titleColumn, $collmnIndex)
    {
        for ($i = 0; $i < count($titleColumn); $i++) {
            if (strstr($titleColumn[$i], 'Origin (city or IATA code)') || strstr($titleColumn[$i], 'Destination (city or IATA code)') || strstr($titleColumn[$i], 'Class') || strstr($titleColumn[$i], 'Single way/ return') || strstr($titleColumn[$i], 'Number of passengers') || strstr($titleColumn[$i], 'Distance (km)') || strstr($titleColumn[$i], 'Country') || strstr($titleColumn[$i], 'Number of occupied rooms') || strstr($titleColumn[$i], 'Number of nights per room') || strstr($titleColumn[$i], 'Factors')) {
                $cellCoordinate = Config::get('constants.collumn')[$i] . $collmnIndex + 1;
                $sheet->getStyle($cellCoordinate)->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
            }
        }
        return $sheet;
    }
}

