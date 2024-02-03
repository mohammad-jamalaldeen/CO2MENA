<?php

use App\Mail\CommonEmail;
use App\Models\{
    Activity,
    BusinessTravels,
    EmployeesCommuting,
    FoodCosumption,
    Fuels,
    MaterialUse,
    Refrigerant,
    TransmissionAndDistribution,
    UserEmissionBusinessTravel,
    UserEmissionEmployeesCommuting,
    UserEmissionFoodCosumption,
    UserEmissionFuel,
    UserEmissionMaterialUse,
    UserEmissionRefrigerant,
    UserEmissionWasteDisposal,
    UserEmissionWatersupplytreatment,
    UserEmissionWttFule,
    Watersupplytreatment,
    WasteDisposal,
    WttFules,
    Vehicle,
    UserEmissionVehicle,
    Electricity,
    UserEmissionElectricity,
    FreightingGoodsVansHgvs,
    FreightingGoodsFlightsRails,
    UserEmissionFreightingGoodsVansHgv,
    UserEmissionFreightingGoodsFlightsRail,
    UserEmissionTransmissionAndDistribution,
    Flight,
    UserEmissionFlight,
    UserSubscription,
    Company,
    Country,
    User,
    Permission,
    UserRole
};
use App\Models\City;
use Illuminate\Support\Facades\{
    Auth,
    Mail
};
use Illuminate\Support\Str;

function dateFormat($date, $format)
{
    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($format);
}

// Genrate randum string
if (!function_exists('generateRandomNumericString')) {
    function generateRandomString($length = 10)
    {
        $characters = '0123456789';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}

function generatePassword()
{
    //Initialize the random password
    // $password = '';
    // //Initialize a random desired length
    // $desired_length = rand(8, 8);

    // for ($length = 0; $length < $desired_length; $length++) {
    //     //Append a random ASCII character (including symbols)
    //     $password .= chr(rand(32, 126));
    // }
    // return $password;

    // //Initialize the random password
    // $password = '';
    // //Initialize a random desired length
    // $desired_length = rand(8, 8);

    // for($length = 0; $length < $desired_length; $length++) {
    //   //Append a random ASCII character (including symbols)
    //   $password .= chr(rand(32, 126));
    // }
    // return $password;

    $specialChars = '@$&';
    $numericChars = '0123456789';
    $uppercaseChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    $password = '';

    // Add one special character
    $password .= $specialChars[rand(0, strlen($specialChars) - 1)];

    // Add one numeric character
    $password .= $numericChars[rand(0, strlen($numericChars) - 1)];

    // Add one uppercase letter
    $password .= $uppercaseChars[rand(0, strlen($uppercaseChars) - 1)];

    // Fill the remaining characters with random characters
    $remainingLength = 5; // 8 characters total minus the 3 we've added
    $allChars = $specialChars . $numericChars . $uppercaseChars;

    for ($i = 0; $i < $remainingLength; $i++) {
        $password .= $allChars[rand(0, strlen($allChars) - 1)];
    }

    // Shuffle the password to make it more random
    $password = str_shuffle($password);

    return $password;
}

/**
 * Rename file name
 * Replace all special character
 * Or custom random name
 * @param $fileName
 * @param string $customName
 * @return string
 */
if (!function_exists('renameFile')) {
    function renameFile($fileName, $customName = '')
    {
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $fileName = pathinfo($fileName, PATHINFO_FILENAME);
        $fileName = trim($fileName); // Trim the file name
        $fileName = preg_replace('/[^A-Za-z0-9_-]/', '-', $fileName); // Allow letters numbers and dash characters
        $fileName = preg_replace('/[-]+/', '-', $fileName); // replace consecutive dashes from string
        $fileName = rtrim($fileName, '-,_'); // Replace dash which is not followed by number or character
        $fileName = ltrim($fileName, '-,_'); // Replace dash which is not followed by number or character

        $fileName = $fileName . '_' . time() . '.' . $extension;
        if (!empty($customName)) {
            $customName = str_replace("/", "-", $customName);
            $fileName = $customName . '-' . rand(1111111111, 9999999999) . '.' . $extension;
        }

        return $fileName;
    }
}


/**
 * Company logo upload
 * @param $file
 * @param array $customName
 * @return string
 */
if (!function_exists('companyLogoFileUpload')) {
    function companyLogoFileUpload($diskName, $file)
    {
        $imageName = renameFile($file->getClientOriginalName());
        // Upload main image
        \Illuminate\Support\Facades\Storage::disk($diskName)->put("/{$imageName}", file_get_contents($file->getRealPath()));
        return $imageName;
    }
}


if (!function_exists('companyDataSheetFileUpload')) {
    function companyDataSheetFileUpload($diskName, $file, $dataSheetName)
    {
        // $imageName = renameFile($file->getClientOriginalName());
        // Upload main image
        \Illuminate\Support\Facades\Storage::disk($diskName)->put("/{$dataSheetName}", file_get_contents($file->getRealPath()));
        return $dataSheetName;
    }
}


/**
 * Remove File
 * @param string $diskName, 
 * @param string $filePath, 
 * @return boolean
 */
if (!function_exists('removeFile')) {
    function removeFile($diskName, $filePath)
    {
        $storagePath = \Illuminate\Support\Facades\Storage::disk($diskName)->url($filePath);
        return file_exists($storagePath) && unlink($storagePath);
    }
}

if (!function_exists('userHistoryManage')) {
    function userHistoryManage($jsonCompanyhis, $moduleid, $userId, $action)
    {
        $history = new App\Models\UserActivity();
        $history->user_id = $userId;
        $history->module_id = $moduleid;
        $history->description = $jsonCompanyhis;
        $history->action = $action;
        $history->save();

        return $history;
    }
}


/**
 * Scope list 
 * @param number $draftStep, 
 * @return route
 */
if (!function_exists('companyDetailPage')) {
    function companyDetailPage($draftStep)
    {
        $routeNames = [
            1 => 'company-detail-step-one.index',
            2 => 'company-detail-step-two.index',
            3 => 'company-detail-step-three.index',
            4 => 'company-detail-step-four.index',
            5 => 'company-detail-step-five.index',
        ];

        $defaultRouteName = 'company-detail-step-one.index';

        return redirect()->route($routeNames[$draftStep] ?? $defaultRouteName)->with("success", 'You have Successfully login.');;
    }
}

/**
 * side bar menu active class check
 * @param array $routeNames, 
 * @param string $currentRouteName, 
 * @return array
 */
if (!function_exists('activeClass')) {
    function activeClass(array $routeNames, string $currentRouteName)
    {
        return in_array($currentRouteName, $routeNames) ? 'active' : '';
    }
}


/**
 * side bar menu active class check
 * @param array $routeNames, 
 * @param string $currentRouteName, 
 * @return array
 */
if (!function_exists('sendEmail')) {
    function sendEmail($email, $data, $subject, $viewPath, $filePaths = array(), $fileType = 'attachment', $cc = '', $bcc='')
    {
        $mailSend = Mail::to($email);
        if ($cc != '') {
            $mailSend = $mailSend->cc($cc);
        }

        if ($bcc != '') {
            $mailSend = $mailSend->bcc($bcc);
        }
        return $mailSend->send(new CommonEmail($data, $subject, $viewPath, $filePaths, $fileType));
    }
}

//Slug Create function 
if (!function_exists('generateSlug')) {
    function generateSlug($string)
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '_', $string), '_'));
    }
}

if (!function_exists('getActivity')) {
    function getActivity($activity)
    {

        $activityModelMapping = [
            Activity::REFRIGERANTS => Refrigerant::class,
            Activity::FUELS => Fuels::class,
            Activity::WTT_FULES => WttFules::class,
            Activity::T_D => TransmissionAndDistribution::class,
            Activity::WATER => Watersupplytreatment::class,
            Activity::MATERIAL_USE => MaterialUse::class,
            Activity::FOOD => FoodCosumption::class,
            Activity::BUSSINESSTRAVEL => BusinessTravels::class,
            Activity::EMPLOYEECOMMUNTING => EmployeesCommuting::class,
            Activity::WASTEDISPOSAL => WasteDisposal::class,
            Activity::OWNED_VEHICLES => Vehicle::class,
            Activity::ELECTRICITY_HEAT_COOLING => Electricity::class,
            Activity::FREIGHTING_GOODS_VansHgv => FreightingGoodsVansHgvs::class,
            Activity::FREIGHTING_GOODS_FlightsRail => FreightingGoodsFlightsRails::class,
            Activity::FLIGHT_AND_ACCOMMODATION => Flight::class,
        ];

        return isset($activityModelMapping[$activity])
            ? $activityModelMapping[$activity]::get()->toArray()
            : [];
    }
}

//Selected Activity value return 
if (!function_exists('getSelectedActivity')) {
    function getSelectedActivity($activity, $company_id)
    {
        $activityModelMapping = [
            Activity::REFRIGERANTS => UserEmissionRefrigerant::class,
            Activity::FUELS => UserEmissionFuel::class,
            Activity::WTT_FULES => UserEmissionWttFule::class,
            Activity::T_D => UserEmissionTransmissionAndDistribution::class,
            Activity::WATER  => UserEmissionWatersupplytreatment::class,
            Activity::MATERIAL_USE => UserEmissionMaterialUse::class,
            Activity::FOOD => UserEmissionFoodCosumption::class,
            Activity::BUSSINESSTRAVEL => UserEmissionBusinessTravel::class,
            Activity::EMPLOYEECOMMUNTING => UserEmissionEmployeesCommuting::class,
            Activity::WASTEDISPOSAL => UserEmissionWasteDisposal::class,
            Activity::OWNED_VEHICLES => UserEmissionVehicle::class,
            Activity::ELECTRICITY_HEAT_COOLING => UserEmissionElectricity::class,
            Activity::FREIGHTING_GOODS_VansHgv => UserEmissionFreightingGoodsVansHgv::class,
            Activity::FREIGHTING_GOODS_FlightsRail => UserEmissionFreightingGoodsFlightsRail::class,
            Activity::FLIGHT_AND_ACCOMMODATION => UserEmissionFlight::class,
        ];

        return isset($activityModelMapping[$activity])
            ? $activityModelMapping[$activity]::where('company_id', $company_id)->pluck('factor_id')->toArray()
            : [];
    }
}


if (!function_exists('getVehicleData')) {
    function getVehicleData($type)
    {
        return Vehicle::where('vehicle_type', $type)->get()->toArray();
    }
}

if (!function_exists('getElectrticityData')) {
    function getElectrticityData($electricity_type)
    {
        return  Electricity::with('country')->where('electricity_type', $electricity_type)->get()->toArray();
    }
}


if (!function_exists('getFreightingGgoods')) {
    function getFreightingGgoods($type = '')
    {
        return ($type == 'vans') ? FreightingGoodsVansHgvs::get()->toArray() : FreightingGoodsFlightsRails::get()->toArray();
    }
}

if (!function_exists('getSelectedFreightingGgoods')) {
    function getSelectedFreightingGgoods($type, $companyId)
    {
        return ($type == 'vans') ? UserEmissionFreightingGoodsVansHgv::where('company_id', $companyId)->pluck('factor_id')->toArray() : UserEmissionFreightingGoodsFlightsRail::where('company_id', $companyId)->pluck('factor_id')->toArray();
    }
}


if (!function_exists('convertToDubaiTimezone')) {
    function convertToDubaiTimezone($date)
    {
        $utcDate = new DateTime($date, new DateTimeZone('UTC'));
        $utcDate->setTimezone(new DateTimeZone('Asia/Dubai'));
        $dubaiTime = $utcDate->format('M d, Y h:i A');
        return $dubaiTime;
    }
}

if (!function_exists('getSelectedOwnedVehicle')) {
    function getSelectedOwnedVehicle($type, $companyId)
    {
        return UserEmissionVehicle::with('vehicles')->whereHas('vehicles', function ($query) use ($type) {
            $query->where('vehicle_type', $type);
        })->where('company_id', $companyId)->pluck('factor_id')->toArray();
    }
}

if (!function_exists('checkSubscriptions')) {
    function checkSubscriptions()
    {
        $userRole = UserRole::where('Role', 'Company Admin')->first();
        if (Auth::guard('web')->user()->user_role_id == $userRole->id) {
            $companyData = Company::select('id', 'user_id')->where('user_id', Auth::guard('web')->user()->id)->first();
            if (isset($companyData)) {
                $userSubscription = UserSubscription::select('id', 'user_id', 'company_id', 'end_date')->where('user_id', Auth::guard('web')->user()->id)->where('company_id', $companyData->id)->orderBy('id', 'Desc')->first();
                if (isset($userSubscription)) {
                    $currentDate = date('Y-m-d');
                    $subscriptionEndDate = $userSubscription->end_date;
                    $expirationDate = date('Y-m-d', strtotime($subscriptionEndDate));
                    $differenceInSeconds = strtotime($expirationDate) - strtotime($currentDate);
                    $daysUntilExpiration = $differenceInSeconds / (60 * 60 * 24);
                    return $daysUntilExpiration <= 7;
                }
            }
        }
        return false;
    }
}

//Selected Activity selected values return 
if (!function_exists('getSelectedActivityData')) {
    function getSelectedActivityData($slug, $companyId)
    {
        switch ($slug) {
            case Activity::REFRIGERANTS:
                return  UserEmissionRefrigerant::where('company_id', $companyId)
                    ->with('refrigerants')
                    ->get()
                    ->pluck('refrigerants.emission')
                    ->toArray();

            case Activity::FUELS:
                return UserEmissionFuel::where('company_id', $companyId)->with('fules')->get()->pluck('fules.fuel')->toArray();

            case Activity::OWNED_VEHICLES:
                $vehicleData = UserEmissionVehicle::where('company_id', $companyId)
                    ->with('vehicles')
                    ->get()
                    ->map(function ($item) {
                        $passengerVehicle = ($item->vehicles->vehicle_type == '1')
                            ? $item->vehicles->vehicle . ' - ' . $item->vehicles->type . ' - ' . $item->vehicles->fuel
                            : null;

                        $deliveryVehicle = ($item->vehicles->vehicle_type != '1')
                            ? $item->vehicles->vehicle . ' - ' . $item->vehicles->type . ' - ' . $item->vehicles->fuel
                            : null;

                        return compact('passengerVehicle', 'deliveryVehicle');
                    })
                    ->toArray();

                // Separate passenger and delivery vehicles into separate arrays
                $passengerVehicle = array_column($vehicleData, 'passengerVehicle');
                $deliveryVehicle = array_column($vehicleData, 'deliveryVehicle');

                // Remove null values
                $passengerVehicle = array_values(array_filter($passengerVehicle));
                $deliveryVehicle = array_values(array_filter($deliveryVehicle));

                return ['passengerVehicle' => $passengerVehicle, 'deliveryVehicle' => $deliveryVehicle];

            case Activity::ELECTRICITY_HEAT_COOLING:
                $electricityKey = array_keys(Electricity::TYPE);
                $userEmisssionElectricityData =  UserEmissionElectricity::where('company_id', $companyId)
                    ->with('electricity', 'electricity.country')
                    ->get()
                    ->map(function ($item) use ($electricityKey) {
                        if (isset($item->electricity->electricity_type)) {
                            if ($item->electricity->electricity_type == $electricityKey[0]) {
                                $countryData = Country::where('id', $item->electricity->country)->first();
                                $countryName = ($countryData) ? $countryData->name : '';
                                return [
                                    'concatenated_electricity' => $item->electricity->activity . ' - ' . $countryName
                                ];
                            } elseif ($item->electricity->electricity_type == $electricityKey[1]) {
                                return [
                                    'concatenated_electricity' => $item->electricity->activity . ' - ' . ($item->electricity->type ? $item->electricity->type : '')
                                ];
                            } else {
                                $countryData = Country::where('id', $item->electricity->country)->first();
                                $countryName = ($countryData) ? $countryData->name : '';
                                return [
                                    'concatenated_electricity' => $item->electricity->activity . ' - ' . $countryName
                                ];
                            }
                        } else {
                            return ['concatenated_electricity' => ''];
                        }
                    })
                    ->pluck('concatenated_electricity')
                    ->toArray();

                return array_values(array_filter($userEmisssionElectricityData));

            case Activity::WTT_FULES:
                return UserEmissionWttFule::where('company_id', $companyId)->with('wttfules')->get()
                    ->pluck('wttfules.fuel')
                    ->toArray();

            case Activity::T_D:
                return UserEmissionTransmissionAndDistribution::where('company_id', $companyId)
                    ->with('transmissionanddistribution')
                    ->get()
                    ->pluck('transmissionanddistribution.activity')
                    ->toArray();

            case Activity::WATER:
                return UserEmissionWatersupplytreatment::where('company_id', $companyId)->with('watersupplytreatments')
                    ->get()
                    ->pluck('watersupplytreatments.type')
                    ->toArray();

            case Activity::MATERIAL_USE:
                return UserEmissionMaterialUse::where('company_id', $companyId)->with('materialuses')->get()->pluck('materialuses.waste_type')->toArray();

            case Activity::WASTEDISPOSAL:
                return UserEmissionWasteDisposal::where('company_id', $companyId)->with('wastedisposal')
                    ->get()
                    ->pluck('wastedisposal.waste_type')
                    ->toArray();

            case Activity::FLIGHT_AND_ACCOMMODATION:
                $flights =  UserEmissionFlight::where('company_id', $companyId)
                    ->with('flight', 'flight.origin', 'flight.destination')
                    ->get()
                    ->map(function ($item) {
                        $cityOriginData = City::select('name')->where('id', $item->flight->origin)->first();
                        $cityDestinationData = City::select('name')->where('id', $item->flight->destination)->first();
                        return $cityOriginData->name . ' - ' . $cityDestinationData->name  . ' - ' . $item->flight->class;
                    })
                    ->toArray();

                return ['flights' => $flights, 'hotels' => []];

            case Activity::FREIGHTING_GOODS:
                $vansHgsData = UserEmissionFreightingGoodsVansHgv::where('company_id', $companyId)
                    ->with('freightingGoodsVansHgvs')
                    ->get()
                    ->map(function ($item) {
                        return $item->freightingGoodsVansHgvs->vehicle . ' - ' . $item->freightingGoodsVansHgvs->type . ' - ' . $item->freightingGoodsVansHgvs->fuel;
                    })
                    ->toArray();

                $flightRailData = UserEmissionFreightingGoodsFlightsRail::where('company_id', $companyId)
                    ->with('freightingGoodsFlight')
                    ->get()
                    ->map(function ($item) {
                        return  $item->freightingGoodsFlight->vehicle . ' - ' . $item->freightingGoodsFlight->type;
                    })
                    ->toArray();

                return ['vansHgsData' => $vansHgsData, 'flightRailData' => $flightRailData];

            case Activity::EMPLOYEECOMMUNTING:
                return UserEmissionEmployeesCommuting::where('company_id', $companyId)
                    ->with('employeescommutings')
                    ->get()
                    ->map(function ($item) {
                        return  $item->employeescommutings->vehicle . ' - ' . $item->employeescommutings->type  . ' - ' . $item->employeescommutings->fuel;
                    })
                    ->toArray();

            case Activity::FOOD:
                return UserEmissionFoodCosumption::where('company_id', $companyId)
                    ->with('foodcosumption')
                    ->get()
                    ->map(function ($item) {
                        return  $item->foodcosumption->vehicle;
                    })
                    ->toArray();

            case Activity::BUSSINESSTRAVEL:
                return UserEmissionBusinessTravel::where('company_id', $companyId)
                    ->with('businesstravels')
                    ->get()
                    ->map(function ($item) {
                        return  $item->businesstravels->vehicles . ' - ' . $item->businesstravels->type . ' - ' . $item->businesstravels->fuel;
                    })
                    ->toArray();

            default:
                return [];
        }
    }
}

if (!function_exists('convertDateTimeZoneUTCToDubai')) {
    function convertDateTimeZoneUTCToDubai($date)
    {
        $utcDate = new DateTime($date, new DateTimeZone('UTC'));
        $utcDate->setTimezone(new DateTimeZone('Asia/Dubai'));
        return $utcDate;
    }
}

//New Comapny Account id generate
if (!function_exists('generateAccountId')) {
    function generateAccountId()
    {
        $countRecord = User::count();
        $lastRecord = User::latest()->first();
        if ($countRecord != 0) {
            $lastId = $countRecord + 1;
            $lastRecord = $lastRecord->id + 1;
            $lastId = $lastRecord . $lastId;
        } else {
            $lastId = 11;
        }
        return 'CMA' . str_pad($lastId, 8, '0', STR_PAD_LEFT);
    }
}

// Remove user emission
if (!function_exists('userEmissionDelete')) {
    function userEmissionDelete($name, $companyId)
    {
        $activityModelMapping = [
            'Refrigerants' => UserEmissionRefrigerant::class,
            'Fuels' => UserEmissionFuel::class,
            'WTT-fules' => UserEmissionWttFule::class,
            'T&D' => UserEmissionTransmissionAndDistribution::class,
            'Water'  => UserEmissionWatersupplytreatment::class,
            'Material use' => UserEmissionMaterialUse::class,
            'Food' => UserEmissionFoodCosumption::class,
            'Business travel - land and sea' => UserEmissionBusinessTravel::class,
            'Employees commuting' => UserEmissionEmployeesCommuting::class,
            'Waste disposal' => UserEmissionWasteDisposal::class,
            'Owned vehicles' => UserEmissionVehicle::class,
            'Electricity, heat, cooling' => UserEmissionElectricity::class,
            'Electricity,heat,cooling' => UserEmissionElectricity::class,
            'Flight and Accommodation' => UserEmissionFlight::class,
        ];

        if ($name) {
            if ($name == "Freighting goods") {
                UserEmissionFreightingGoodsVansHgv::where('company_id', $companyId)->delete();
                UserEmissionFreightingGoodsFlightsRail::where('company_id', $companyId)->delete();
                return true;
            } else {
                $activityModelMapping[$name]::where('company_id', $companyId)->delete();
                return true;
            }
        } else {
            return false;
        }
    }
}

// Remove user emission
if (!function_exists('adminPermissionCheck')) {
    function adminPermissionCheck($route)
    {
        $adminUser = Auth::guard('admin')->user();
        if($adminUser)
        {
            if ($adminUser->user_role_id == 1) {
                return true;
            }
    
            $prefix = Str::before($route, '.');
            $userWiseAllowedPermissions = Permission::with('module')->where('user_id', $adminUser->id)->get();
    
            $userHasPermission = $userWiseAllowedPermissions->some(function ($permission) use ($route, $prefix) {
                return str_contains($route, $permission->action) && $prefix === $permission->module->module_slug;
            });
    
            if ($userHasPermission == true) {
                return $userHasPermission;
            }
    
            if (count($userWiseAllowedPermissions->toArray()) == 0) {
                $allowedPermissions = Permission::with('module')->where('user_role_id', $adminUser->user_role_id)->get();
    
                $hasPermission = $allowedPermissions->some(function ($permission) use ($route, $prefix) {
                    return str_contains($route, $permission->action) && $prefix === $permission->module->module_slug;
                });
                return $hasPermission;
            }
    
            return $userHasPermission;
        }

        return false;
    }
}

if (!function_exists('frontendPermissionCheck')) {
    function frontendPermissionCheck($route)
    {
        $user = Auth::guard('web')->user();
        if($user)
        {
            $prefix = Str::before($route, '.');
            $userWiseAllowedPermissions = Permission::with('module')->where('user_id', $user->id)->get();
    
            $userHasPermission = $userWiseAllowedPermissions->some(function ($permission) use ($route, $prefix) {
                return str_contains($route, $permission->action) && $prefix === $permission->module->module_slug;
            });
    
            if ($userHasPermission == true) {
                return $userHasPermission;
            }
    
            if (count($userWiseAllowedPermissions->toArray()) == 0) {
                $allowedPermissions = Permission::with('module')->where('user_role_id', $user->user_role_id)->get();
    
                $hasPermission = $allowedPermissions->some(function ($permission) use ($route, $prefix) {
    
                    return str_contains($route, $permission->action) && $prefix === $permission->module->module_slug;
                });
    
                return $hasPermission;
            }
    
            return $userHasPermission;
        }
        return false;
    }
}


// Remove user emission
if (!function_exists('adminMultiplePermissionCheck')) {
    function adminMultiplePermissionCheck($route, $prifix)
    {
        $adminUser = Auth::guard('admin')->user();
        if($adminUser)
        {
            if ($adminUser->user_role_id == 1) {
                return 1;
            }
    
            $userWiseAllowedPermissions = Permission::join('modules', 'permissions.module_id', '=', 'modules.id')
                ->where('module_slug', '=', $route)
                ->where('user_id', $adminUser->id)->whereIn('action', $prifix)->count();
    
    
            if ($userWiseAllowedPermissions > 0) {
                return $userWiseAllowedPermissions;
            }
    
            $userHasPermission = Permission::join('modules', 'permissions.module_id', '=', 'modules.id')
                ->where('module_slug', '=', $route)
                ->where('user_role_id', $adminUser->user_role_id)->whereIn('action', $prifix)->count();
    
            return $userHasPermission;
        }
        
        return 0;
    }
}



if (!function_exists('frontMultiplePermissionCheck')) {
    function frontMultiplePermissionCheck($route = '', $prifix = [])
    {
        $user = Auth::guard('web')->user();
        if($user)
        {
            $userWiseAllowedPermissions = Permission::join('modules', 'permissions.module_id', '=', 'modules.id')
            ->when($route, function ($query) use ($route) {
                return $query->where('module_slug', '=', $route);
            })->when($prifix, function ($query) use ($prifix) {
                return $query->whereIn('action', $prifix);
            })
            ->where('user_id', $user->id)
            ->count();

            if ($userWiseAllowedPermissions > 0) {
                return $userWiseAllowedPermissions;
            }

            $userHasPermission = Permission::join('modules', 'permissions.module_id', '=', 'modules.id')
                ->when($route, function ($query) use ($route) {
                    return $query->where('module_slug', '=', $route);
                })->when($prifix, function ($query) use ($prifix) {
                    return $query->whereIn('action', $prifix);
                })
                ->where('user_role_id', $user->user_role_id)
                ->count();

            return $userHasPermission;
        }
        return false;
    }
}
if (!function_exists('thousandsCountCustom')) {
function thousandsCountCustom($num)
{
    if ($num > 1000) {
        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = ['K', 'M', 'B', 'T'];
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];

        return $x_display;
    }

    return $num;
}
}

// Hex Color value set
if (!function_exists('colorCode')) {
    function colorCode($index)
    {
        return colorCodeStaticArray()[$index];
    }
}


// Color Code Array
if (!function_exists('colorCodeArray')) {
    function colorCodeArray($count)
    {
        return array_map('colorCode', range(1, $count));        
    }
}


// Hex Color value set
if (!function_exists('colorCodeStaticArray')) {
    function colorCodeStaticArray()
    {
        return [
        "#4A708B",
        "#5bb5e7",
        "#473C8B",
        "#428b7c",
        "#67df42",
        "#4F94CD",
        "#b4ee0f",
        "#7FFFD4",
        "#808000",
        "#CCFFFF",
        "#708090",
        "#a23939",
        "#4682B4",
        "#63B8FF",
        "#76EEC6",
        "#838B8B",
        "#828a8a",
        "#70DBDB",
        "#2F2F4F",
        "#23238E",
        "#4D4DFF",
        "#97f009",
        "#5959AB",
        "#3299CC",
        "#192225",
        "#6E7B8B",
        "#c2a925",
        "#8B6969",
        "#6B8E23",
        "#C0FF3E",
        "#2F4F2F",
        "#006300",
        "#4A766E",
        "#BDB76B",
        "#556B2F",
        "#CAFF70",
        "#0bf5d2",
        "#A2CD5A",
        "#6E8B3D",
        "#808000",
        "#8FBC8F",
        "#C1FFC1",
        "#228B22",
        "#ADFF2F",
        "#1b8a75",
        "#20B2AA",
        "#32CD32",
        "#3CB371",
        "#00FA9A",
        "#7e88e7",
        "#794ee6",
        "#af5c2a",
        "#aaecbf",
        "#00CD00",
        "#008B00",
        "#F0E68C",
        "#5a5204",
        "#C1CDCD",
        "#d3b51c",
        "#be4f7a",
        "#a76892",
        "#A2B5CD",
        "#70DB93",
        "#0000CD",
        "#878787",
        "#1e3d5c",
        "#C6E2FF",
        "#25d3c8",
        "#9FB6CD",
        "#6C7B8B",
        "#333333",
        "#3b5839",
        "#FF9933",
        "#33A1FF",
        "#33FF57",
        "#5733FF",
        "#33FFEC",
        "#FFD133",
        "#3366FF",
        "#72da89",
        "#6CA6CD",
        "#33FF66",
        "#4682E4"];
    }
}



