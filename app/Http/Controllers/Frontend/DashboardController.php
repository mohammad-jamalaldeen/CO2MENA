<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\CompanyDetailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Config;
use PDF;
use Carbon\Carbon;
use App\Models\{
    User,
    Datasheet,
    industryScope,
    StaffCompany,
    UserRole,
    Company,
    CompanyPublishSheet
};
use Illuminate\Support\Facades\DB;
use Sabberworm\CSS\Value\URL;


class DashboardController extends Controller
{
    private $companyDetailController;
    function __construct()
    {
        $this->companyDetailController = new CompanyDetailController();
    }
    public function index(Request $request)
    {
        $sums = $this->calculateTotalSum($request);
        // Access the sums as needed
        $sumTotal1 = $sums['sumTotal1'];
        $sumtotalFuel1 = $sums['sumtotalFuel1'];
        $sumTotal3 = $sums['sumTotal3'];
        $sumtotalFuel3 = $sums['sumtotalFuel3'];
        $sumtotalEnergy = $sums['sumtotalEnergy'];
        $sumTotal2 = $sums['sumTotal2'];
        $sumtotalEnergyUsed2 = $sums['sumtotalEnergyUsed2'];
        $sumtotalTonOfRefrigeration2 = $sums['sumtotalTonOfRefrigeration2'];
        $totalSum = $sumTotal1 + $sumTotal2 + $sumTotal3;
        $totalFuel = $sumtotalFuel1 + $sumtotalFuel3;
        $totalEnergy = $sumtotalEnergy + $sumtotalEnergyUsed2;
        $sumtotalFuelArray = [
            'Scope One' => $sumtotalFuel1,
            'Scope Two' => 0,
            'Scope Three' => $sumtotalFuel3,
        ];


        $sumtotalEnerygArray = [
            'labels' => [
                // 'Scope One',
                'Scope Two',
                'Scope Three'
            ],
            'datasets' => [
                // [
                //     'label' => 'Scope One (0)',
                //     'data' => [0,0,0],
                //     'backgroundColor' => colorCode()
                // ],
                [
                    'label' => 'Scope Two(' . $sumtotalEnergyUsed2 . ')',
                    'data' => [$sumtotalEnergyUsed2, 0],
                    'backgroundColor' => colorCode(0)
                ],
                [
                    'label' => 'Scope Three (' . $sumtotalEnergy . ')',
                    'data' => [0, $sumtotalEnergy],
                    'backgroundColor' => colorCode(1)
                ],
            ]
        ];

        // $sumtotalEnerygArray = [
        //     'Scope One' => 0,
        //     'Scope Two' => $sumtotalEnergyUsed2,
        //     'Scope Three' => $sumtotalEnergy,
        // ];
        return view('dashboard', compact('totalSum', 'totalFuel', 'totalEnergy', 'sumTotal1', 'sumTotal2', 'sumTotal3', 'sumtotalFuelArray', 'sumtotalEnerygArray'));
    }

    public function generatePdf(Request $request)
    {
        $userModel = Auth::guard('web')->user();
        $id = $userModel->id;
        if ($userModel->user_role_id == '7' || $userModel->user_role_id == '8' || $userModel->user_role_id == '9') {
            $companyID = StaffCompany::select('company_id')->where('user_id', Auth::guard('web')->user()->id)->first();
            $companyData = Company::where('id', $companyID->company_id)->first();
        } else {
            $companyData = Company::where('user_id', $id)->first();
        }
        $datasheet = Datasheet::where('status', '3')->where('company_id', $companyData->id)->first();
        $sheet_name = $datasheet->calculated_file_name;
        $sheet_start_date= $datasheet->reporting_start_date;
        $sheet_end_date= $datasheet->reporting_start_date;
        $name = $sheet_name.'-'.$sheet_start_date.'-'.$sheet_end_date;
        $totalEmissions = $request->input('totalEmissions');
        $totalfuelused = $request->input('totalfuelused');
        $totalenergyused = $request->input('totalenergyused');

        $allChatArr = json_decode($request->input('allchart'), true);
        $chartBarArr = [];
        foreach ($allChatArr as $key => $barArr) {
            foreach ($barArr as $key => $value) {
                $chartBarArr[$key] = $value;
            }
        }

        $pdf = PDF::loadView('frontend.charts.dashboard-charts', compact('totalEmissions', 'totalfuelused', 'totalenergyused', 'chartBarArr', 'companyData', 'datasheet'));
        $timestamp = Carbon::now()->format('His');
        $pdfName = $name. '.pdf';
        return $pdf->download($pdfName);
    }

    public function scopeOne(Request $request, $action = "")
    {
        // try {
        $fuelDataArr = [];
        $userDetails = Auth::guard('web')->user();
        $staffRoleId = UserRole::whereNot('role', 'Company Admin')->where('type', 'Frontend')->pluck('id')->toArray();
        if (in_array($userDetails->user_role_id, $staffRoleId)) {
            $companyStaffData = StaffCompany::select('id', 'user_id', 'company_id')->where('user_id', $userDetails->id)->first();
            $Company = Company::where('id', $companyStaffData->company_id)->first();
            $companyData = Company::where('user_id', $Company->user_id)->with('companyactivities.activity:id,name', 'companyactivities.activitydata:id,name', 'companyaddresses', 'user')->first();
            $publishSheetArr = CompanyPublishSheet::with(['datasheets'])->where('publisher_id', $Company->user_id)->whereNull('deleted_at')->groupBy('datasheet_id')->get()->toArray();
        } else {
            $companyData = Company::where('user_id', $userDetails->id)->with('companyactivities.activity:id,name', 'companyactivities.activitydata:id,name', 'companyaddresses', 'user')->first();
            $publishSheetArr = CompanyPublishSheet::with(['datasheets'])->where('publisher_id', $userDetails->id)->whereNull('deleted_at')->groupBy('datasheet_id')->get()->toArray();
        }

        $industryScopeData = industryScope::with('activity')->where('industry_id', $companyData->company_industry_id)->get()->toArray();
        $companySelectedActivity =   \Illuminate\Support\Arr::pluck($companyData->companyactivities->toArray(), 'activitydata.id');
        // $scopeOne = $this->companyDetailController->processScopeData($industryScopeData, $companySelectedActivity, 1);
        $scopeOne = [0 => "Fuels", 1 => "Owned vehicles", 2 => "Refrigerants"];
        $allowedDataSheetArray = Config::get('constants.allowedDataSheetArray');
        $datasheetNew = '';
        if (!empty($request->datasheet)) {
            $datasheet = $request->datasheet;
            $datasheetNew = $request->datasheet;
        } else {
            $datasheet = Datasheet::where('status', '3')->where('company_id', $companyData->id)->pluck('emission_calculated')->first();
        }

        $fileUrl = $datasheet;
        $excelFile = '';
        if ($datasheet != "-"  && $datasheet != null) {
            $lastSlashPos = strrpos($fileUrl, '/');
            if ($lastSlashPos !== false) {
                $result = substr($fileUrl, $lastSlashPos + 1);
                $excelFile = $result;
            } else {
                $result = $datasheet;
                $excelFile = $datasheet;
            }
            $excelFile = (\Illuminate\Support\Facades\Storage::disk('calculated_datasheet')->path('') . $excelFile);
        } else {
            $excelFile = "";
        }

        // if (!empty($excelFile) && (!empty($scopeOne) && count($scopeOne) > 0)) {
        //     // $spreadsheet = IOFactory::load($excelFile);
        //     $sheetNames = $spreadsheet->getSheetNames();
        //     $filteredArray = array_intersect($sheetNames, $scopeOne);
        //     $dataArray = [];
        //     $newDataArray = [];
        //     $unsetlabels = [];
        //     foreach ($scopeOne as $sheet) {
        //         if (in_array($sheet, $sheetNames)) {
        //             $sheet_key = Config::get('constants.graphXYArray')[$sheet];
        //             $newsheet_key = Config::get('constants.newgraphXYArray')[$sheet];
        //         }

        //         $worksheet = $spreadsheet->getSheetByName($sheet);
        //         if ($worksheet !== null) {
        //             $sheetData = $worksheet->toArray();
        //             // print_R($sheet);
        //             $dataArray[$sheet] = $this->graphDataOne($sheetData, $sheet_key, $sheet);

        //             if ($sheet == 'Owned vehicles') {
        //                 $newDataArray['Passenger Vehicles'] = $this->ownVehicleData($sheetData, $newsheet_key, $sheet, 'Passenger Vehicles');
        //                 $newDataArray['Delivery Vehicles'] = $this->ownVehicleData($sheetData, $newsheet_key, $sheet, 'Delivery Vehicles');
        //             }

        //             if ($sheet == 'Fuels' || $sheet == 'Refrigerants') {
        //                 $newDataArray[$sheet] = $this->graphDataOneNew($sheetData, $newsheet_key, $sheet);
        //             }
        //         }

        //         if (array_key_exists($sheet, $dataArray) && array_sum($dataArray[$sheet]) == 0) {
        //             if ($sheet == 'Owned vehicles') {
        //                 if (array_sum($dataArray[$sheet]['passenger']) == 0) {
        //                     $unsetlabels[] = 'Passenger Vehicles';
        //                 }
        //                 if (array_sum($dataArray[$sheet]['delivery']) <= 0) {
        //                     $unsetlabels[] = 'Delivery Vehicles';
        //                 }
        //             } else {
        //                 $unsetlabels[] = $sheet;
        //             }
        //         }
        //     }

        //     if (array_key_exists('Owned vehicles', $dataArray)) {
        //         $dataArray['Passenger Vehicles'] = $dataArray['Owned vehicles']['passenger'];
        //         $dataArray['Delivery Vehicles'] = $dataArray['Owned vehicles']['delivery'];
        //         unset($dataArray['Owned vehicles']);
        //     }
        //     $total = [];
        //     $totalEnergy = [];
        //     $totalFuel = [];
        //     foreach ($dataArray as $key => $data) {
        //         $total[$key] = array_sum($data);
        //         if ($key == "Fuels" || $key == "Passenger Vehicles" || $key == "Delivery Vehicles") {
        //             $totalFuel[$key] = array_sum($data);
        //         }
        //     }

        //     $overallPiesum = array_sum($total);
        //     $piecahrtArr = [];
        //     foreach ($total as $key => $item) {
        //         if ($item != '0') {
        //             $piecahrtArr[$key] = $item;
        //         }
        //     }

        //     return view('dashboard-scope-one', compact('scopeOne', 'dataArray', 'total', 'totalFuel', 'piecahrtArr', 'publishSheetArr', 'result', 'unsetlabels', 'filteredArray', 'newDataArray', 'datasheetNew'));
        // } else {
        //     if ($action != 'overview') {
        //         return redirect()->back()->with('error', 'No Data Found.');
        //     }
        // }
        // } catch (\Exception $e) {
        //     return redirect()->back()->with('error', $e->getMessage());
        // }
    }

    public function graphDataOne($sheetData, $keys, $name)
    {
        $fuelarray = [];
        if (is_array($keys)) {
            if ($name == "Owned vehicles") {
                $passengerExplode  = explode(',', $keys['passenger_vehicles']);
                $passengerOne = $passengerExplode[0];
                $passengerTwo = $passengerExplode[1];
                $deliveryExplode = explode(',', $keys['delivery_vehicles']);
                $deliveryOne = $deliveryExplode[0];
                $deliveryTwo = $deliveryExplode[1];
                foreach ($sheetData as $index => $value) {
                    if ($index <= 3) {
                        continue;
                    }
                    $type = $value[$passengerOne];
                    $co2e = (float)$value[$passengerTwo];
                    if (!empty($object[$type])) {
                        $object[$type] += $co2e;
                    } else {
                        $object[$type] = $co2e;
                    }
                    $fuelarray['passenger'] = $object;
                    $type2 = $value[$deliveryOne];
                    $co2e1 = (float) $value[$deliveryTwo];
                    if (isset($object1[$type2])) {
                        $object1[$type2] += $co2e1;
                    } else {
                        $object1[$type2] = $co2e1;
                    }
                    $fuelarray['delivery'] = $object1;
                }
            }

            return $fuelarray;
        } else {
            $explodekey = explode(',', $keys);
            $type_key = $explodekey[0];
            $co2e_key = $explodekey[1];

            foreach ($sheetData as $key => $item) {
                if ($key == 0 || $key == 1) {
                    continue;
                }
                $type = $item[$type_key];
                $co2e = isset($item[$co2e_key]) ? (float)str_replace(',', '', $item[$co2e_key])  : '-';

                if (isset($fuelarray[$type]) && $co2e != "-") {
                    $fuelarray[$type] = (float)$fuelarray[$type];
                    $fuelarray[$type] += $co2e;
                } else {
                    $fuelarray[$type] = $co2e;
                }
            }
            return $fuelarray;
        }
    }

    public function graphDataOneNew($sheetData, $keys, $name)
    {
        $explodekey = explode(',', $keys);
        $type_key = $explodekey[0];
        $co2e_key = $explodekey[1];
        $newKey = $explodekey[2];

        $label = [];
        $labelCount = [];
        $xaxArray = [];

        foreach ($sheetData as $key => $item) {
            if ($key == 0 || $key == 1) {
                continue;
            }

            if (!in_array($item[$type_key], $label)) {
                array_push($label, $item[$type_key]);
                array_push($labelCount, 0);
            }
        }

        $i = 0;
        foreach ($sheetData as $key => $item) {
            if ($key == 0 || $key == 1) {
                continue;
            }

            if ($i == 84) {
                $i = 0;
            }

            $result = [
                'type' => $item[$type_key],
                'label' => $item[$co2e_key],
                'data' => $labelCount,
                'backgroundColor' => colorCode($i),
                'count' => 0
            ];

            $index = $this->findIndex($xaxArray, $item[$type_key], $item[$co2e_key]);


            // if($index === NULL)
            // {    
            // $result['data'][array_search($item[$type_key], $label)] = $result['data'][array_search($item[$type_key], $label)] + (float) $item[$newKey];
            // // $result['label'] = $result['label']. ' ('.$result['data'][array_search($item[$type_key], $label)] .')';

            // if($result['data'][array_search($item[$type_key], $label)] != 0)
            // {
            //     array_push($xaxArray, $result);
            // }    
            // } else{
            //     $xaxArray[$index]['data'][array_search($item[$type_key], $label)] = $xaxArray[$index][array_search($item[$type_key], $label)] + (float) $item[$newKey];
            //     $xaxArray[$index]['count'] =   $xaxArray[$index]['data'][array_search($item[$type_key], $label)] ;
            // }

            // if($name == 'Employees commuting')
            // {
            if ($index === NULL) {
                if ($item[$newKey] != '' ||  $item[$newKey] != '-') {
                    $result['data'][array_search($item[$type_key], $label)] = $result['data'][array_search($item[$type_key], $label)] + (float) $item[$newKey];
                    $result['count'] = $result['data'][array_search($item[$type_key], $label)];

                    if ($result['data'][array_search($item[$type_key], $label)] != 0) {
                        array_push($xaxArray, $result);
                    }
                }
            } else {

                $xaxArray[$index]['data'][array_search($item[$type_key], $label)] = $xaxArray[$index]['data'][array_search($item[$type_key], $label)] + (float) $item[$newKey];
                $xaxArray[$index]['count'] = $xaxArray[$index]['data'][array_search($item[$type_key], $label)];
                // var_dump($item[$newKey]);
                // print_r($xaxArray[$index]);
                // exit;   
                // echo "d";
            }
            // var_dump($index);
            // } else 
            // {
            //     $result['data'][array_search($item[$type_key], $label)] = $result['data'][array_search($item[$type_key], $label)] + (float) $item[$newKey];
            //       if($result['data'][array_search($item[$type_key], $label)] != 0)
            //     {
            //         array_push($xaxArray, $result);
            //     }   
            // }

            $i++;

            // $result = [
            //     'type' => $item[$type_key],
            //     'label' => $item[$co2e_key],
            //     'data' => $labelCount,
            //     'backgroundColor' => colorCode($i),
            //     'count' => 0
            // ];

            // $index = $this->findIndex($xaxArray, $item[$type_key], $item[$co2e_key]);

            // if($index === NULL)
            // {
            // $result['data'][array_search($item[$type_key], $label)] = $result['data'][array_search($item[$type_key], $label)] + (float) $item[$newKey];

            // if($result['data'][array_search($item[$type_key], $label)] != 0)
            // {
            // array_push($xaxArray, $result);
            // }  
            // } else 
            // {
            // $xaxArray[$index]['data'][array_search($item[$type_key], $label)] = $xaxArray[$index]['data'][array_search($item[$type_key], $label)]  + (float) $item[$newKey];         
            // }

            $i++;
        }

        $xaxArray = array_map(function ($item) {
            unset($item['type']);
            return $item;
        }, $xaxArray);

        $xaxArray = array_map(function ($item) {
            $item['label'] = $item['label'] . '(' . $item['count']  . ')';
            return $item;
        }, $xaxArray);
        $xaxArray = array_map(function ($item) {
            unset($item['count']);
            return $item;
        }, $xaxArray);

        $xaxArray = array_values(array_filter($xaxArray));

        return ['labels' => $label, 'datasets' => $xaxArray];
    }


    public function ownVehicleData($sheetData, $keys, $name, $type)
    {
        if ($type == 'Passenger Vehicles') {
            $explodekey = explode(',', $keys['passenger_vehicles']);
        } elseif ($type == 'Delivery Vehicles') {
            $explodekey = explode(',', $keys['delivery_vehicles']);
        } elseif ($type == 'Flights') {
            $explodekey = explode(',', $keys['flight']);
        } elseif ($type == 'Hotel') {
            $explodekey = explode(',', $keys['hotel']);
        } elseif ($type == 'FREIGHTING GOODS VANS AND HGVS') {
            $explodekey = explode(',', $keys['vans']);
        } elseif ($type == 'FREIGHTING GOODS FLIGHTS, RAIL, SEA TANKER AND CARGO SHIP') {
            $explodekey = explode(',', $keys['flights']);
        } elseif ($type == 'Water') {
            $explodekey = explode(',', $keys);
        }

        $type_key = $explodekey[0];
        $co2e_key = $explodekey[1];
        $newKey = $explodekey[2];

        $label = ($type == 'Hotel') ? ['1 Night', '2 Nights', '3 Nights', '4 Nights', '>4 Nights'] : [];
        $labelCount = ($type == 'Hotel') ? [0, 0, 0, 0, 0]  : [];
        $xaxArray = [];

        foreach ($sheetData as $key => $item) {
            if (isset($keys['passenger_vehicles']) || isset($keys['delivery_vehicles']) ||  isset($keys['vans']) ||  isset($keys['flights'])) {
                if ($key == 0 || $key == 1 || $key == 2) {
                    continue;
                }
            } else {
                if ($key == 0 || $key == 1) {
                    continue;
                }
            }

            if ($type == 'Water') {
                if ($key == 0 || $key == 1 || $key == 2 ||  $key == 5 ||  $key == 6) {
                    continue;
                }
            }

            if (!in_array($item[$type_key], $label) && $item[$type_key] != null &&  $type != 'Hotel') {
                array_push($label, $item[$type_key]);
                array_push($labelCount, 0);
            }
        }

        $i = 0;
        foreach ($sheetData as $key => $item) {
            if (isset($keys['passenger_vehicles']) || isset($keys['delivery_vehicles']) ||  isset($keys['vans']) ||  isset($keys['flights'])) {
                if ($key == 0 || $key == 1 || $key == 2) {
                    continue;
                }
            } else {
                if ($key == 0 || $key == 1) {
                    continue;
                }
            }

            if ($type == 'Water') {
                if ($key == 0 || $key == 1 || $key == 2 ||  $key == 5 ||  $key == 6) {
                    continue;
                }
            }

            if ($i == 83) {
                $i = 0;
            }

            if ($item[$co2e_key] != null || $item[$co2e_key] != '') {
                if ($type == 'Hotel') {

                    $result = [
                        'type' => $item[$type_key],
                        'label' => $item[$co2e_key],
                        'data' => $labelCount,
                        'backgroundColor' => colorCode($i),
                        'count' => 0
                    ];

                    $index = $this->findIndex($xaxArray, $item[$type_key], $item[$co2e_key]);
                    if ($index === NULL) {
                        $number = (int) $item[$type_key];
                        if ($number == 1) {
                            $result['data'][0] = $result['data'][0] + (float) $item[$newKey];

                            $result['count'] = $result['data'][0];
                        } elseif ($number == 2) {
                            $result['data'][1] = $result['data'][1] + (float) $item[$newKey];

                            $result['count'] = $result['data'][1];
                        } elseif ($number == 3) {
                            $result['data'][2] = $result['data'][2] + (float) $item[$newKey];

                            $result['count'] = $result['data'][2];
                        } elseif ($number == 4) {
                            $result['data'][3] = $result['data'][3] + (float) $item[$newKey];

                            $result['count'] = $result['data'][3];
                        } else {
                            $result['data'][4] = $result['data'][4] + (float) $item[$newKey];

                            $result['count'] = $result['data'][4];
                        }

                        array_push($xaxArray, $result);
                    } else {
                        $number = (int) $item[$type_key];
                        if ($number == 1) {
                            $xaxArray[$index]['data'][0] =  $xaxArray[$index]['data'][0] + (float) $item[$newKey];

                            $xaxArray[$index]['count'] =  $xaxArray[$index]['data'][0];
                        } elseif ($number == 2) {
                            $xaxArray[$index]['data'][1] =  $xaxArray[$index]['data'][1] + (float) $item[$newKey];

                            $xaxArray[$index]['count'] =  $xaxArray[$index]['data'][1];
                        } elseif ($number == 3) {
                            $xaxArray[$index]['data'][2] =  $xaxArray[$index]['data'][2] + (float) $item[$newKey];

                            $xaxArray[$index]['count'] =  $xaxArray[$index]['data'][2];
                        } elseif ($number == 4) {
                            $xaxArray[$index]['data'][3] =  $xaxArray[$index]['data'][3] + (float) $item[$newKey];

                            $xaxArray[$index]['count'] =  $xaxArray[$index]['data'][3];
                        } else {
                            $xaxArray[$index]['data'][4] =  $xaxArray[$index]['data'][4] + (float) $item[$newKey];

                            $xaxArray[$index]['count'] =  $xaxArray[$index]['data'][4];
                        }
                    }
                } elseif ($type == 'Water') {
                    $result = [
                        'type' => $item[$type_key],
                        'label' => $item[$co2e_key],
                        'data' => $labelCount,
                        'backgroundColor' => colorCode($i),
                        'count' => 0
                    ];

                    $index = $this->findIndex($xaxArray, $item[$type_key], $item[$co2e_key]);
                    if ($index === NULL) {
                        if ($item[$newKey] != '-' && $item[$newKey] != '') {
                            $result['data'][array_search($item[$type_key], $label)] = $result['data'][array_search($item[$type_key], $label)] + (float) $item[$newKey];

                            $result['count'] = $result['data'][array_search($item[$type_key], $label)];
                        }
                        array_push($xaxArray, $result);
                    } else {
                        if ($item[$newKey] != '-' && $item[$newKey] != '') {
                            $xaxArray[$index]['data'][array_search($item[$type_key], $label)] =  $xaxArray[$index]['data'][array_search($item[$type_key], $label)] + (float) $item[$newKey];

                            $xaxArray[$index]['count'] = $xaxArray[$index]['data'][array_search($item[$type_key], $label)];
                        }
                    }
                } else {
                    $result = [
                        'type' => $item[$type_key],
                        'label' => $item[$co2e_key],
                        'data' => $labelCount,
                        'backgroundColor' => colorCode($i),
                        'count' => 0
                    ];

                    $index = $this->findIndex($xaxArray, $item[$type_key], $item[$co2e_key]);
                    if ($index === NULL) {
                        if ($item[$newKey] != '-' && $item[$newKey] != '') {
                            $result['data'][array_search($item[$type_key], $label)] = $result['data'][array_search($item[$type_key], $label)] + (float) $item[$newKey];
                            $result['count'] = $result['data'][array_search($item[$type_key], $label)];
                        }
                        array_push($xaxArray, $result);
                    } else {
                        if ($item[$newKey] != '-' && $item[$newKey] != '') {
                            $xaxArray[$index]['data'][array_search($item[$type_key], $label)] =  $xaxArray[$index]['data'][array_search($item[$type_key], $label)] + (float) $item[$newKey];

                            $xaxArray[$index]['count'] = $xaxArray[$index]['data'][array_search($item[$type_key], $label)];
                        }
                    }
                }
            }
            $i++;
        }




        $xaxArray = array_map(function ($item) {
            $item['label'] = $item['label'] . '(' . $item['count']  . ')';
            return $item;
        }, $xaxArray);

        $xaxArray = array_map(function ($item) {
            if ($item['count'] == 0) {
                unset($item);
                return;
            }

            return $item;
        }, $xaxArray);

        $xaxArray = array_map(function ($item) {
            unset($item['type']);
            unset($item['count']);
            return $item;
        }, $xaxArray);

        $xaxArray = array_values(array_filter($xaxArray));

        return ['labels' => $label, 'datasets' => $xaxArray];
    }

    // Function to find index based on type and label
    function findIndex($dataArray, $type, $label)
    {
        foreach ($dataArray as $key => $item) {
            if ($item['type'] === $type && $item['label'] === $label) {
                return $key;
            }
        }

        return null; // Return null if not found
    }


    public function scopetwo(Request $request, $action = "")
    {
        $userDetails = Auth::guard('web')->user();
        $staffRoleId = UserRole::whereNot('role', 'Company Admin')->where('type', 'Frontend')->pluck('id')->toArray();
        if (in_array($userDetails->user_role_id, $staffRoleId)) {
            $companyStaffData = StaffCompany::select('id', 'user_id', 'company_id')->where('user_id', $userDetails->id)->first();
            $Company = Company::where('id', $companyStaffData->company_id)->first();
            $companyData = Company::where('user_id', $Company->user_id)->with('companyactivities.activity:id,name', 'companyactivities.activitydata:id,name', 'companyaddresses', 'user')->first();
            $publishSheetArr = CompanyPublishSheet::with(['datasheets'])->where('publisher_id', $Company->user_id)->whereNull('deleted_at')->groupBy('datasheet_id')->get()->toArray();
        } else {
            $companyData = Company::where('user_id', $userDetails->id)->with('companyactivities.activity:id,name', 'companyactivities.activitydata:id,name', 'companyaddresses', 'user')->first();
            $publishSheetArr = CompanyPublishSheet::with(['datasheets'])->where('publisher_id', $userDetails->id)->whereNull('deleted_at')->groupBy('datasheet_id')->get()->toArray();
        }
        $industryScopeData = industryScope::with('activity')->where('industry_id', $companyData->company_industry_id)->get()->toArray();
        $companySelectedActivity =   \Illuminate\Support\Arr::pluck($companyData->companyactivities->toArray(), 'activitydata.id');
        // $scopeTwo = $this->companyDetailController->processScopeData($industryScopeData, $companySelectedActivity, 2);
        $scopeTwo = [0 => "Electricity, heat, cooling"];
        $allowedDataSheetArray = Config::get('constants.allowedDataSheetArray');
        $datasheetNew = '';
        if (!empty($request->datasheet)) {
            $datasheet = $request->datasheet;
            $datasheetNew = $request->datasheet;
        } else {
            $datasheet = Datasheet::where('status', '3')->where('company_id', $companyData->id)->pluck('emission_calculated')->first();
            if($datasheet)
            {
                $datasheetArray = explode('/', $datasheet);
                $datasheetNew = $datasheetArray[count($datasheetArray) -1];
            }
        }

        $fileUrl = $datasheet;
        $excelFile = '';
        $dataArray = [];
        $electricityGridNameArray = [];
        $electricityGridValueArray = [];
        $heatAndSteamNameArray = [];
        $heatAndSteamvalueArray = [];
        $districtCoolingNameArray = [];
        $districtCoolingValueArray = [];
        $electricityPieChartArray = [];
        $fuelDataArr = [];
        $totalEmission = 0;
        $totalTonOfRefrigeration = 0;
        $totalEnergyUsed = 0;
        $electricityGridCount = 0;
        $heatAandSteamCount = 0;
        $districtCoolingCount = 0;

        if ($datasheet != "-"  && $datasheet != null) {
            $lastSlashPos = strrpos($fileUrl, '/');
            if ($lastSlashPos !== false) {
                $result = substr($fileUrl, $lastSlashPos + 1);
                $excelFile = $result;
            } else {
                $result = $datasheet;
                $excelFile = $datasheet;
            }
            $excelFile = (\Illuminate\Support\Facades\Storage::disk('calculated_datasheet')->path('') . $excelFile);
        }

        // if (!empty($excelFile) && (!empty($scopeTwo) && count($scopeTwo) > 0)) {
        //     $spreadsheet = IOFactory::load($excelFile);
        //     $sheetNames = $spreadsheet->getSheetNames();
        //     $i = 0;
        //     foreach ($scopeTwo as $sheet) {

        //         if (in_array($sheet, $sheetNames)) {
        //             $sheet_key = Config::get('constants.graphXYArray')[$sheet];
        //         }

        //         $worksheet = $spreadsheet->getSheetByName($sheet);
        //         if ($worksheet !== null) {
        //             $sheetData = $worksheet->toArray();
        //             if ($sheet == 'Electricity, heat, cooling') {
        //                 $sheetKeyValue = explode(',', $sheet_key);
        //                 if (count($sheetData) > 0) {
        //                     unset($sheetData[0]);
        //                     $sheetData = array_values($sheetData);
        //                     $heatandStrimCommingFlag = false;
        //                     $DistrictCommingFlag = false;

        //                     foreach ($sheetData as $key => $value) {
        //                         if ($key != 0) {
        //                             if ($value[0] != '' && $value[0] != 'Activity') {
        //                                 if ($value[0] == 'Heat and steam') {
        //                                     $heatandStrimCommingFlag = true;
        //                                     $DistrictCommingFlag = false;
        //                                 }

        //                                 if ($value[0] == 'District cooling') {
        //                                     $DistrictCommingFlag = true;
        //                                     $heatandStrimCommingFlag = false;
        //                                 }

        //                                 if ($heatandStrimCommingFlag == false && $DistrictCommingFlag == false) {
        //                                     array_push($electricityGridNameArray, $value[$sheetKeyValue[0]]);
        //                                     array_push($electricityGridValueArray, $value[$sheetKeyValue[1]]);
        //                                     if ($value[$sheetKeyValue[1]] != '' && $value[$sheetKeyValue[1]] != '-') {
        //                                         if (array_key_exists("Electricity Grid", $electricityPieChartArray)) {
        //                                             $electricityPieChartArray['Electricity Grid'] = $electricityPieChartArray['Electricity Grid'] + $value[$sheetKeyValue[1]];
        //                                         } else {
        //                                             $electricityPieChartArray['Electricity Grid'] = $value[$sheetKeyValue[1]];
        //                                         }

        //                                         $totalEmission +=  $value[$sheetKeyValue[1]];

        //                                         if ($value[2] == 'Ton of refrigeration') {
        //                                             $totalTonOfRefrigeration += $value[$sheetKeyValue[1]];
        //                                         } else {
        //                                             $totalEnergyUsed += $value[$sheetKeyValue[1]];
        //                                         }

        //                                         $electricityGridCount += $value[$sheetKeyValue[1]];
        //                                     }
        //                                 }

        //                                 if ($heatandStrimCommingFlag == true &&  $value[0] != 'Heat and steam') {
        //                                     array_push($heatAndSteamNameArray, $value[$sheetKeyValue[0]]);
        //                                     array_push($heatAndSteamvalueArray, $value[$sheetKeyValue[1]]);
        //                                     if ($value[$sheetKeyValue[1]] != '' && $value[$sheetKeyValue[1]] != '-') {
        //                                         if (array_key_exists("Heat and steam", $electricityPieChartArray)) {
        //                                             $electricityPieChartArray['Heat and steam'] = $electricityPieChartArray['Heat and steam'] + $value[$sheetKeyValue[1]];
        //                                         } else {
        //                                             $electricityPieChartArray['Heat and steam'] = $value[$sheetKeyValue[1]];
        //                                         }

        //                                         $totalEmission +=  $value[$sheetKeyValue[1]];

        //                                         if ($value[2] == 'Ton of refrigeration') {
        //                                             $totalTonOfRefrigeration += $value[$sheetKeyValue[1]];
        //                                         } else {
        //                                             $totalEnergyUsed += $value[$sheetKeyValue[1]];
        //                                         }

        //                                         $heatAandSteamCount +=  $value[$sheetKeyValue[1]];
        //                                     }
        //                                 }

        //                                 if ($DistrictCommingFlag == true && $value[0] == 'District cooling' && $value[1] != '') {
        //                                     array_push($districtCoolingNameArray, $value[$sheetKeyValue[0]]);
        //                                     array_push($districtCoolingValueArray, $value[$sheetKeyValue[1]]);
        //                                     if ($value[$sheetKeyValue[1]] != '' && $value[$sheetKeyValue[1]] != '-') {
        //                                         if (array_key_exists("District cooling", $electricityPieChartArray)) {
        //                                             $electricityPieChartArray['District cooling'] = $electricityPieChartArray['District cooling'] + $value[$sheetKeyValue[1]];
        //                                         } else {
        //                                             $electricityPieChartArray['District cooling'] = $value[$sheetKeyValue[1]];
        //                                         }

        //                                         $totalEmission +=  $value[$sheetKeyValue[1]];

        //                                         if ($value[2] == 'Ton of refrigeration') {
        //                                             $totalTonOfRefrigeration += $value[$sheetKeyValue[1]];
        //                                         } else {
        //                                             $totalEnergyUsed += $value[$sheetKeyValue[1]];
        //                                         }

        //                                         $districtCoolingCount +=  $value[$sheetKeyValue[1]];
        //                                     }
        //                                 }
        //                             }
        //                         }
        //                     }

        //                     if (count($electricityGridNameArray) > 0) {
        //                         $electricArray = [];
        //                         $electricArray['label'] = $electricityGridNameArray;

        //                         for ($i = 0; $i < count($electricityGridValueArray); $i++) {
        //                             $dataValueArray =  array_fill(0, count($electricityGridValueArray), '0');
        //                             $dataValueArray[$i] = $electricityGridValueArray[$i];
        //                             $result = [
        //                                 'label' => $electricityGridNameArray[$i],
        //                                 'data' => $dataValueArray,
        //                                 'backgroundColor' => colorCode($i)
        //                             ];
        //                             $electricArray['datasets'] = $result;
        //                         }

        //                         // $dataArray[$sheet]['Electricity Grid New'] =  array_combine($electricityGridNameArray, $electricityGridValueArray);
        //                         $electricityStateChartData = $this->electricityStateChartArrayData($electricityGridNameArray, $electricityGridValueArray);
        //                         if (count($electricityStateChartData) != 0) {
        //                             $dataArray[$sheet]['Electricity Grid'] = $electricityStateChartData;
        //                         }
        //                     }

        //                     if (count($heatAndSteamNameArray) > 0) {
        //                         // $dataArray[$sheet]['Heat and steam'] =  array_combine($heatAndSteamNameArray, $heatAndSteamvalueArray);
        //                         $electricityStateChartData =  $this->electricityStateChartArrayData($heatAndSteamNameArray, $heatAndSteamvalueArray);

        //                         if (count($electricityStateChartData) != 0) {
        //                             $dataArray[$sheet]['Heat and steam'] =   $electricityStateChartData;
        //                         }
        //                     }

        //                     if (count($districtCoolingNameArray) > 0) {
        //                         $electricityStateChartData = $this->electricityStateChartArrayData($districtCoolingNameArray, $districtCoolingValueArray);
        //                         // $dataArray[$sheet]['District cooling'] =  array_combine($districtCoolingNameArray, $districtCoolingValueArray);
        //                         if (count($electricityStateChartData) != 0) {
        //                             $dataArray[$sheet]['District cooling'] =  $electricityStateChartData;
        //                         }
        //                     }
        //                 }
        //             }

        //             if ($sheet != 'Electricity, heat, cooling') {
        //                 $dataArray[$sheet] = $this->graphDataOne($sheetData, $sheet_key, $sheet);
        //             }
        //         }

        //         $i++;
        //     }

        //     // $unlabeled = [];

        //     // foreach ($dataArray as $key => $data) {
        //     //     foreach ($data as $value => $values) {
        //     //         if (isset($values["Electricity"]) && $values["Electricity"] === "-") {
        //     //             $unlabeled[] = $value;
        //     //         }
        //     //         if (isset($values["District heat and steam"]) && $values["District heat and steam"] === "-") {
        //     //             $unlabeled[] = $value;
        //     //         }
        //     //         if (isset($values["District cooling"]) && $values["District cooling"] === "-") {
        //     //             $unlabeled[] = $value;
        //     //         }
        //     //     }
        //     // }
        //     return view('dashboard-scope-two', compact('scopeTwo', 'dataArray', 'electricityPieChartArray', 'totalEmission', 'totalEnergyUsed', 'totalTonOfRefrigeration', 'publishSheetArr', 'result', 'electricityGridCount', 'heatAandSteamCount', 'districtCoolingCount','datasheet' ,'datasheetNew'));
        // } else {
        //     if ($action != 'overview') {
        //         return redirect()->back()->with('error', 'No Data Found.');
        //     }
        // }
    }

    public function electricityStateChartArrayData($electricityGridNameArray, $electricityGridValueArray)
    {
        $electricArray = [];

        for ($i = 0; $i < count($electricityGridValueArray); $i++) {
            $dataValueArray =  array_fill(0, count($electricityGridValueArray), 0);
            $dataValueArray[$i] = (float) $electricityGridValueArray[$i];
            if ($dataValueArray[$i] > 0) {
                $result = [
                    'label' => $electricityGridNameArray[$i] . ' (' . $dataValueArray[$i] . ')',
                    'data' => $dataValueArray,
                    'backgroundColor' => colorCode($i)
                ];
                $electricArray['datasets'][] = $result;
            }
        }

        if (isset($electricArray['datasets'])) {
            $electricArray['labels'] = $electricityGridNameArray;
        }

        return $electricArray;
    }

    public function scopeThree(Request $request, $action = "")
    {
        $userDetails = Auth::guard('web')->user();
        $staffRoleId = \App\Models\UserRole::whereNot('role', 'Company Admin')->where('type', 'Frontend')->pluck('id')->toArray();
        if (in_array($userDetails->user_role_id, $staffRoleId)) {
            $companyStaffData = \App\Models\StaffCompany::select('id', 'user_id', 'company_id')->where('user_id', $userDetails->id)->first();
            $Company = \App\Models\Company::where('id', $companyStaffData->company_id)->first();
            $companyData = Company::where('user_id', $Company->user_id)->with('companyactivities.activity:id,name', 'companyactivities.activitydata:id,name', 'companyaddresses', 'user')->first();
            $publishSheetArr = CompanyPublishSheet::with(['datasheets'])->where('publisher_id', $Company->user_id)->whereNull('deleted_at')->groupBy('datasheet_id')->get()->toArray();
        } else {
            $companyData = Company::where('user_id', $userDetails->id)->with('companyactivities.activity:id,name', 'companyactivities.activitydata:id,name', 'companyaddresses', 'user')->first();
            $publishSheetArr = CompanyPublishSheet::with(['datasheets'])->where('publisher_id', $userDetails->id)->whereNull('deleted_at')->groupBy('datasheet_id')->get()->toArray();
        }
        $industryScopeData = industryScope::with('activity')->where('industry_id', $companyData->company_industry_id)->get()->toArray();

        $companySelectedActivity =   \Illuminate\Support\Arr::pluck($companyData->companyactivities->toArray(), 'activitydata.id');

        //$scopeThree = $this->companyDetailController->processScopeData($industryScopeData, $companySelectedActivity, 3);
        $scopeThree = [0 => "Business travel - land and sea", 1 => "Employees commuting", 2 => "Flight and Accommodation", 3 => "Food", 4 => "Freighting goods", 5 => "Home Office", 6 => "Material use", 7 => "T&D", 8 => "Waste disposal", 9 => "Water", 10 => "WTT-fules"];
        $allowedDataSheetArray = Config::get('constants.allowedDataSheetArray');
        $fuelDataArr = [];
        $unsetlabels = [];
        if (!empty($request->datasheet)) {
            $datasheet = $request->datasheet;
        } else {
            $datasheet = Datasheet::where('status', '3')->where('company_id', $companyData->id)->pluck('emission_calculated')->first();
        }

        $excelFile = "";
        if ($datasheet != "-"  && $datasheet != null) {
            $fileUrl = $datasheet;
            $excelFile = '';
            $lastSlashPos = strrpos($fileUrl, '/');
            if ($lastSlashPos !== false) {
                $result = substr($fileUrl, $lastSlashPos + 1);
                $excelFile = $result;
            } else {
                $result = $datasheet;
                $excelFile = $datasheet;
            }
            $excelFile = (\Illuminate\Support\Facades\Storage::disk('calculated_datasheet')->path('') . $excelFile);
        } else {
            $excelFile = "";
        }
        // if (!empty($excelFile) && (!empty($scopeThree) && count($scopeThree) > 0)) {
        //     $spreadsheet = IOFactory::load($excelFile);
        //     $sheetNames = $spreadsheet->getSheetNames();
        //     $filteredArray = array_intersect($sheetNames, $scopeThree);
        //     $dataArray = [];
        //     $newDataArray = [];
        //     foreach ($filteredArray as $sheet) {
        //         // if (!in_array($sheet, ['Food'])) {
        //         if (in_array($sheet, $sheetNames)) {
        //             $sheet_key = Config::get('constants.graphXYArray')[$sheet];
        //             $newsheet_key = Config::get('constants.newgraphXYArray')[$sheet];
        //         }
        //         $worksheet = $spreadsheet->getSheetByName($sheet);
        //         // if ($worksheet !== null) {
        //         //     $sheetData = $worksheet->toArray();
        //         //     $dataArray[$sheet] = $this->graphData($sheetData, $sheet_key, $sheet);
        //         //     if (array_sum($dataArray[$sheet]) == 0) {
        //         //         $unsetlabels[] = $sheet;
        //         //     }
        //         // }
        //         if ($worksheet !== null) {
        //             $sheetData = $worksheet->toArray();
        //             $dataArray[$sheet] = $this->graphData($sheetData, $sheet_key, $sheet);

        //             if ($sheet == 'Flight and Accommodation') {
        //                 $newDataArray['Flight'] = $this->ownVehicleData($sheetData, $newsheet_key, $sheet, 'Flights');
        //                 $newDataArray['Hotel'] = $this->ownVehicleData($sheetData, $newsheet_key, $sheet, 'Hotel');
        //             }

        //             if ($sheet == 'Freighting goods') {
        //                 $newDataArray['FREIGHTING GOODS VANS AND HGVS '] = $this->ownVehicleData($sheetData, $newsheet_key, $sheet, 'FREIGHTING GOODS VANS AND HGVS');
        //                 $newDataArray['FREIGHTING GOODS FLIGHTS, RAIL, SEA TANKER AND CARGO SHIP'] = $this->ownVehicleData($sheetData, $newsheet_key, $sheet, 'FREIGHTING GOODS FLIGHTS, RAIL, SEA TANKER AND CARGO SHIP');
        //             }

        //             if ($sheet == 'Water') {
        //                 $newDataArray[$sheet] = $this->ownVehicleData($sheetData, $newsheet_key, $sheet, 'Water');
        //             }

        //             if ($sheet == 'WTT-fules' || $sheet == 'Material use' || $sheet == 'Waste disposal' || $sheet == 'Business travel - land and sea' || $sheet == 'Employees commuting' || $sheet == 'Food' || $sheet == 'Home Office' || $sheet == 'T&D') {
        //                 $newDataArray[$sheet] = $this->graphDataOneNew($sheetData, $newsheet_key, $sheet);
        //             }

        //             if ($sheet == "Freighting goods") {
        //                 if (isset($dataArray[$sheet]['vans'])) {
        //                     $vansSum = array_sum($dataArray[$sheet]['vans']);

        //                     if ($vansSum == 0) {
        //                         $unsetlabels[] = 'Freighting goods vans and HGVs';
        //                     }
        //                 }

        //                 if (isset($dataArray[$sheet]['flights'])) {
        //                     $flightsSum = array_sum($dataArray[$sheet]['flights']);

        //                     if ($flightsSum == 0) {
        //                         $unsetlabels[] = 'Freighting goods flights, rail, sea tanker and cargo ship';
        //                     }
        //                     //dd($flightsSum);
        //                 }
        //             } elseif ($sheet == "Flight and Accommodation") {
        //                 if (isset($dataArray[$sheet]['flight'])) {
        //                     $FlightSum = array_sum($dataArray[$sheet]['flight']);
        //                     if ($FlightSum == 0) {
        //                         $unsetlabels[] = 'Flight';
        //                     }
        //                 }

        //                 if (isset($dataArray[$sheet]['hotel'])) {
        //                     $HotelSum = array_sum($dataArray[$sheet]['hotel']);
        //                     if ($HotelSum == 0) {
        //                         $unsetlabels[] = 'Hotel';
        //                     }
        //                 }
        //             } else {
        //                 if (array_sum($dataArray[$sheet]) == 0) {
        //                     $unsetlabels[] = $sheet;
        //                 }
        //             }
        //         }
        //     }

        //     if (array_key_exists('Freighting goods', $dataArray)) {
        //         $dataArray['Freighting goods vans and HGVs'] = $dataArray['Freighting goods']['vans'];
        //         $dataArray['Freighting goods flights, rail, sea tanker and cargo ship'] = $dataArray['Freighting goods']['flights'];
        //         unset($dataArray['Freighting goods']);
        //     }

        //     if (array_key_exists('Flight and Accommodation', $dataArray)) {
        //         $dataArray['Flight'] = $dataArray['Flight and Accommodation']['flight'];
        //         $dataArray['Hotel'] = $dataArray['Flight and Accommodation']['hotel'];
        //         unset($dataArray['Flight and Accommodation']);
        //     }
        //     $total = [];
        //     $totalEnergy = [];
        //     $totalFuel = [];
        //     $totalhome = [];
        //     $totalSum = 0;
        //     foreach ($dataArray as $key => $data) {

        //         $total[$key] = array_sum($data);
        //         if ($key == "Freighting goods vans and HGVs" || $key == "Freighting goods flights, rail, sea tanker and cargo ship" || $key == "Employees commuting" || $key == "Business travel - land and sea" || $key == "WTT-fules") {
        //             $totalFuel[$key] = array_sum($data);
        //         }
        //         if ($key == "T&D") {
        //             $totalSum = array_sum($data);
        //             $totalEnergy[$key] = $totalSum;
        //         }
        //     }

        //     $overallPiesum = array_sum($total);
        //     $piecahrtArr = [];
        //     foreach ($total as $key => $item) {
        //         $piecahrtArr[$key] = 0;
        //         if ($overallPiesum != 0) {
        //             $piecahrtArr[$key] = $item;
        //         }
        //     }
        //     return view('dashboardscopethree', compact('scopeThree', 'dataArray', 'total', 'totalFuel', 'totalEnergy', 'piecahrtArr', 'unsetlabels', 'publishSheetArr', 'result', 'filteredArray', 'newDataArray'));
        // } else {
        //     if ($action != 'overview') {
        //         return redirect()->back()->with('error', 'No Data Found.');
        //     }
        // }
    }
    public function graphData($sheetData, $keys, $sheet)
    {
        $fuelarray = [];
        if (is_array($keys)) {
            $object = [];
            $object1 = [];
            $type2 = "";
            foreach ($sheetData as $index => $value) {
                if ($index == 0 || $index == 1 || ($index == 2 && $sheet != "Flight and Accommodation")) {
                    continue;
                }
                if ($sheet == "Flight and Accommodation") {
                    $type = $value[2];
                    $co2e = isset($value[6]) ? (float)str_replace(',', '', $value[6])  : '';
                    if (isset($object[$type])) {
                        $object[$type] = (float) $object[$type];
                        $object[$type] += (float)$co2e;
                    } else {
                        $object[$type] = (float)$co2e;
                    }
                    $fuelarray['flight'] = $object;
                    $type2 = "";
                    if ($value[10] == "1") {
                        $type2 = "1 Night";
                    } else if ($value[10] == "2") {
                        $type2 = "2 Night";
                    } else if ($value[10] == "3") {
                        $type2 = "3 Night";
                    } else if ($value[10] == "4") {
                        $type2 = "4 Nights";
                    } else if ($value[10] > 4) {
                        $type2 = "> 4 Nights";
                    }
                    $co2e1 = isset($value[11]) ? (float)str_replace(',', '', $value[11])  : '';
                    if (isset($object1[$type2])) {
                        $object1[$type2] += (float)$co2e1;
                    } else {
                        $object1[$type2] = (float)$co2e1;
                    }
                    $fuelarray['hotel'] = $object1;
                } else {
                    $type = $value[0];
                    $co2e = (float) $value[4];

                    if (isset($object[$type])) {
                        $object[$type] = (float) $object[$type];
                        $object[$type] += $co2e;
                    } else {
                        $object[$type] = $co2e;
                    }
                    $fuelarray['vans'] = $object;

                    $type2 = $value[6];
                    $co2e1 = (float) $value[10];
                    if (isset($object1[$type2])) {
                        $object1[$type2] = (float)$object1[$type2];
                        $object1[$type2] += $co2e1;
                    } else {
                        $object1[$type2] = $co2e1;
                    }
                    $fuelarray['flights'] = $object1;
                }
            }
            return $fuelarray;
        } else {
            $explodekey = explode(',', $keys);
            $type_key = $explodekey[0];
            $co2e_key = $explodekey[1];
            foreach ($sheetData as $key => $item) {
                if ($key == 0 || $key == 1) {
                    continue;
                }
                $type = $item[$type_key];
                $co2e = isset($item[$co2e_key]) ? (float)str_replace(',', '', $item[$co2e_key])  : '-';
                if (isset($fuelarray[$type])) {
                    $fuelarray[$type] = (float)$fuelarray[$type];
                    $fuelarray[$type] += (float)$co2e;
                } else {
                    $fuelarray[$type] = $co2e;
                }
            }
            return $fuelarray;
        }
    }

    public function permission()
    {
        return view('permission');
    }

    public function scopeOnePdf(Request $request)
    {
        $userModel = Auth::guard('web')->user();
        $id = $userModel->id;
        if ($userModel->user_role_id == '7' || $userModel->user_role_id == '8' || $userModel->user_role_id == '9') {
            $companyID = StaffCompany::select('company_id')->where('user_id', Auth::guard('web')->user()->id)->first();
            $companyData = Company::where('id', $companyID->company_id)->first();
        } else {
            $companyData = Company::where('user_id', $id)->first();
        }
        $datasheet = Datasheet::where('status', '3')->where('company_id', $companyData->id)->first();
        $totalEmissions = $request->input('totalEmissions');
        $totalFuel = $request->input('totalFuel');
        $allChatArr = json_decode($request->input('allchart'), true);
        $chartBarArr = [];
        foreach ($allChatArr as $key => $barArr) {
            foreach ($barArr as $key => $value) {
                $chartBarArr[$key] = $value;
            }
        }
        // return view('frontend.charts.scope-one-chart', compact('totalEmissions', 'totalFuel', 'chartBarArr'));

        $pdf = \PDF::loadView('frontend.charts.scope-one-chart', compact('totalEmissions', 'totalFuel', 'chartBarArr', 'companyData', 'datasheet'));
        $timestamp = Carbon::now()->format('His');
        // $pdfName = 'dashboard_scope1_' . $timestamp . '.pdf';
        $pdfName = $request->input('name'). '.pdf';
        return $pdf->download($pdfName);
    }

    public function scopeThreePdf(Request $request)
    {
        $userModel = Auth::guard('web')->user();
        $id = $userModel->id;
        if ($userModel->user_role_id == '7' || $userModel->user_role_id == '8' || $userModel->user_role_id == '9') {
            $companyID = StaffCompany::select('company_id')->where('user_id', Auth::guard('web')->user()->id)->first();
            $companyData = Company::where('id', $companyID->company_id)->first();
        } else {
            $companyData = Company::where('user_id', $id)->first();
        }
        $datasheet = Datasheet::where('status', '3')->where('company_id', $companyData->id)->first();
        $totalEmissions = $request->input('totalEmissions');
        $totalFuel = $request->input('totalFuel');
        $totalEnergyUsed = $request->input('totalEnergyUsed');
        $allChatArr = json_decode($request->input('allchart'), true);
        $chartBarArr = [];
        foreach ($allChatArr as $key => $barArr) {
            foreach ($barArr as $key => $value) {
                $chartBarArr[$key] = $value;
            }
        }
        // return View('frontend.charts.scope3chart', compact('totalEmissions', 'totalFuel', 'totalEnergyUsed', 'chartBarArr','companyData','datasheet'));
        $pdf = \PDF::loadView('frontend.charts.scope3chart', compact('totalEmissions', 'totalFuel', 'totalEnergyUsed', 'chartBarArr', 'companyData', 'datasheet'));
        $timestamp = Carbon::now()->format('His');
        $pdfName = $request->input('name'). '.pdf';
        return $pdf->download($pdfName);
    }

    public function scopeTwoPdf(Request $request)
    {
        $userModel = Auth::guard('web')->user();
        $id = $userModel->id;
        if ($userModel->user_role_id == '7' || $userModel->user_role_id == '8' || $userModel->user_role_id == '9') {
            $companyID = StaffCompany::select('company_id')->where('user_id', Auth::guard('web')->user()->id)->first();
            $companyData = Company::where('id', $companyID->company_id)->first();
        } else {
            $companyData = Company::where('user_id', $id)->first();
        }
        $datasheet = Datasheet::where('status', '3')->where('company_id', $companyData->id)->first();
        $totalEmission = $request->input('totalemission');
        $totalEnergyUsed = $request->input('totalenergyused');
        $totalTonOfRefrigeration = $request->input('totaltonofrefrigeration');
        $allChatArr = json_decode($request->input('allchart'), true);
        $chartBarArr = [];
        foreach ($allChatArr as $key => $barArr) {
            foreach ($barArr as $key => $value) {
                $chartBarArr[$key] = $value;
            }
        }
        $pdf = \PDF::loadView('frontend.charts.scope-two-chart', compact('totalEmission', 'totalEnergyUsed', 'totalTonOfRefrigeration', 'chartBarArr', 'companyData', 'datasheet'));
        $timestamp = Carbon::now()->format('His');
        $pdfName = $request->input('name'). '.pdf';
        return $pdf->download($pdfName);
    }

    public function calculateTotalSum(Request $request)
    {
        $view1 = $this->scopeOne($request, 'overview');
        $view2 = $this->scopetwo($request, 'overview');
        $view3 = $this->scopeThree($request, 'overview');
        $total1 = $totalFuel1 = $sumTotal2 = $sumtotalEnergyUsed2 = $sumtotalTonOfRefrigeration2 = $total3 = $totalFuel3 = $totalEnergy3 = 0;
        if (!empty($view1)) {
            $total1 = $view1->getData()['total'];
            $totalFuel1 = $view1->getData()['totalFuel'];
        }

        if (!empty($view2)) {
            $sumTotal2 = $view2->getData()['totalEmission'];
            $sumtotalEnergyUsed2 = $view2->getData()['totalEnergyUsed'];
            $sumtotalTonOfRefrigeration2 = $view2->getData()['totalTonOfRefrigeration'];
        }

        if (!empty($view3)) {
            $total3 = $view3->getData()['total'];
            $totalFuel3 = $view3->getData()['totalFuel'];
            $totalEnergy3 = $view3->getData()['totalEnergy'];
        }

        $sumTotal1 = !empty($total1) ? array_sum($total1) : 0;
        $sumtotalFuel1 = !empty($totalFuel1) ? array_sum($totalFuel1) : 0;
        $sumTotal3 = !empty($total3) ? array_sum($total3) : 0;
        $sumtotalFuel3 = !empty($totalFuel3) ? array_sum($totalFuel3) : 0;
        $sumtotalEnergy = !empty($totalEnergy3) ? array_sum($totalEnergy3) : 0;

        return [
            'sumTotal1' => $sumTotal1,
            'sumtotalFuel1' => $sumtotalFuel1,
            'sumTotal3' => $sumTotal3,
            'sumtotalFuel3' => $sumtotalFuel3,
            'sumtotalEnergy' => $sumtotalEnergy,
            'sumTotal2' => $sumTotal2,
            'sumtotalEnergyUsed2' => $sumtotalEnergyUsed2,
            'sumtotalTonOfRefrigeration2' => $sumtotalTonOfRefrigeration2,
        ];
    }
}
