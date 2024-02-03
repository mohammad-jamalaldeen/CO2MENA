<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Frontend\CompanyDetailController;
use Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Frontend\ManageProfileEmissionRequest;
use App\Models\{
    Company,
    CompanyAddress,
    CompanyDocument,
    User,
    CompanyIndustry,
    Country,
    StaffCompany,
    Activity,
    CompanyActivity,
    City,
    CmsPages,
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
    UserEmissionFlight,
    industryScope,
    UserRole
};


class ProfileController extends Controller
{
    private $companyDetailController;
    function __construct()
    {
        $this->companyDetailController = new CompanyDetailController();
    }

    public function index(Request $request)
    {
        try {
            $user = optional(Auth::guard('web')->user());
            $companyData = [];
            $companyIndustryData = [];
            $countryData = [];
            $companyDataForStaff = [];
            $activityData = [];
            $countryIds = [];
            $countryNames = [];
            $cityData = [];
            $cityIds = [];
            $cityNames = [];
            $page = [];
            $industryScopeData = [];
            $scopeOne = [];
            $scopeTwo = [];
            $scopeThree = [];

            $companyAdminRole = UserRole::where('role', 'Company Admin')->first();
            $staffRoles = UserRole::whereNot('role','Company Admin')->where('type','Frontend')->pluck('id')->toArray();
            if (Auth::guard('web')->user()->user_role_id == $companyAdminRole->id) {
                $companyData = Company::where('user_id', $user->id)->with('companyactivities.activity:id,name','companyactivities.activitydata:id,name' , 'companyaddresses', 'user')->first();
                $fileName = Company::getFileName($companyData->company_logo);
                $companyData['file_name'] = $fileName;
                $companyIndustryData = CompanyIndustry::select('id', 'name')->get()->toArray();
                
                $countryData = Country::WhereIn('name', Country::countries)->get()->toArray();
                // $countryData = Country::get()->toArray();
                $activityData = Activity::select('id', 'name')->get()->toArray();
                $countryIds = array_column($countryData, 'id');
                $countryNames = array_column($countryData, 'name');
                $cityData = City::get()->toArray();
                $cityIds = array_column($cityData, 'id');
                $cityNames = array_column($cityData, 'name');
                $page = CmsPages::where('slug', 'need-help')->first();
                $companySelectedActivity =   \Illuminate\Support\Arr::pluck($companyData->companyactivities->toArray(), 'activitydata.id');
                $industryScopeData = industryScope::with('activity')->where('industry_id', $companyData->company_industry_id)->get()->toArray();
                $scopeOne = $this->companyDetailController->processScopeData($industryScopeData, $companySelectedActivity, 1);
                $scopeTwo = $this->companyDetailController->processScopeData($industryScopeData, $companySelectedActivity, 2);
                $scopeThree = $this->companyDetailController->processScopeData($industryScopeData, $companySelectedActivity, 3);
            } elseif (in_array(Auth::guard('web')->user()->user_role_id, $staffRoles)) {
                $companyDataForStaff = StaffCompany::where('user_id', $user->id)->first();
                $companyData = $companyDataForStaff->company;
                $fileName = Company::getFileName($companyData->company_logo);             
                $companyData['file_name'] = $fileName;
            }
          
            return view('frontend.profile.index', compact('companyData',  'companyIndustryData', 'user', 'countryData', 'companyDataForStaff', 'activityData', 'page', 'countryIds', 'countryNames', 'cityIds', 'cityNames', 'scopeOne', 'scopeTwo', 'scopeThree', 'industryScopeData'));
        } catch (\Exception $e) {
            return view('frontend.profile.index')->with('error', $e->getMessage());
        }
    }
    public function changePassword(Request $request)
    {
        $userDetails = Auth::guard('web')->user();
        $userId = $userDetails->id;
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'password' => 'required|string|confirmed|min:8|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[^A-Za-z0-9]/',
            'password_confirmation' => 'required'
        ]);
        if ($validator->passes()) {
            if (Hash::check($request->current_password, Auth::guard('web')->user()->password)) {
                if ($request->password == $request->password_confirmation) {
                    if (Hash::check($request->password, Auth::guard('web')->user()->password)) {
                        return Response::json(['old_password_as_current' => 'You can not set old password as new password']);
                    }
                    $user = User::where('id', $userId)->update(['password' => Hash::make($request->password)]);
                    if (Auth::guard('web')->user()) {
                        $jsonCompanyhis = 'Password updated';
                        $moduleid = 13;
                        $userId = Auth::guard('web')->user()->id;
                        $action = "Updated";
                        $history = userHistoryManage($jsonCompanyhis, $moduleid, $userId, $action);
                    }
                    return Response::json(['success' => 'Your password has been successfully changed!']);
                } else {
                    return Response::json(['field_not_match' => 'Password and confirm password is incorrect']);
                }
            } else {
                return Response::json(['current_password' => 'Current password is incorrect']);
            }
        }
        return Response::json(['errors' => $validator->errors()]);
    }

    public function companyDetailsUpdate(\App\Http\Requests\Frontend\CreateCompanyDetailStepOneRequest $request)
    {
        try {
            $data = $this->companyObject($request);
            Company::updateOrInsert(['id' => $data['id']], $data);
            CompanyAddress::where('company_id', $data['id'])->delete();
            CompanyAddress::insert($this->companyDetailController->companyAddressObject($request, $data['id']));
            return response()->json(['status' => 'true', 'message' => 'Company details have been successfully updated.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'false', 'message' => $e->getMessage()]);
        }
    }

    public function isEmailDuplicate($request)
    {
        $companyId = $request->id ?? null;

        // If company ID is provided, check against the existing company's email
        if ($companyId) {
            $companyData = Company::find($companyId);
            return $companyData->company_email !== $request->company_email && Company::where('company_email', $request->company_email)->exists();
        }

        // If no company ID, directly check for email existence
        return Company::where('company_email', $request->company_email)->exists();
    }
    public function companyObject($request)
    {
        try {
            $companyData = Company::find($request->id);

            $data = [
                'company_name' => $request->company_name,
                'trade_licence_number' => $request->trade_licence_number,
                'no_of_employees' => $request->no_of_employees,
                'company_email' => $request->company_email,
                'company_phone' => $request->company_phone,
                'id' => $companyData->id,
            ];

            if ($request->hasFile('company_logo')) {
                $companyLogo = companyLogoFileUpload('company_user', $request->file('company_logo'));
                removeFile('company_user', $request->file('company_logo'));
                $data['company_logo'] = $companyLogo;
            }

            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function profileImageUpdate(\App\Http\Requests\Frontend\ProfileImageRequest $request)
    {
        try {
            if ($request->has('profile_picture')) {
                User::where('id', Auth::guard('web')->user()->id)->update([
                    'profile_picture' => companyLogoFileUpload('company_user', $request->file('profile_picture'))
                ]);
                $userData = User::find(Auth::guard('web')->user()->id);
                return response()->json(['status' => 'true', 'message' => 'Profile picture is successfully updated.', 'data' => $userData->profile_picture]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'false', 'message' => $e->getMessage()]);
        }
    }

    public function profileImageRemove(Request $request)
    {
        try {
            $companyDocument = CompanyDocument::findOrFail($request->id);
            $companyDocumentCount = CompanyDocument::where('document_type', $companyDocument->document_type)->where('company_id', $companyDocument->company_id)->count();

            if ($companyDocumentCount > 1 && $companyDocument->delete()) {
                return response()->json(['status' => 'true', 'message' => 'Document is successfully removed.', 'data'=>['id' => $request->id]]);
            }

            return response()->json(['status' => 'false', 'message' => ' At least one document is required', 'data'=> []]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data'=> []]);
        }
    }

    public function companyDocumentUpdate(\App\Http\Requests\Frontend\CreateCompanyDetailStepTwoRequest $request)
    {
        try {

            if ($request->hasFile('trade_license') || $request->hasFile('establishment')) {
                $user = Auth::guard('web')->user();
                $companyData = Company::select('id', 'user_id')->where('user_id', $user->id)->firstOrFail();
                $tradeLicenseImages = ($request->hasFile('trade_license')) ? $request->file('trade_license') : [];
                $establishmentImages = ($request->hasFile('establishment')) ?  $request->file('establishment') : [];
                $companyDocumentArray = $this->createCompanyDocumentArray($companyData->id, $tradeLicenseImages, $establishmentImages);
                CompanyDocument::insert($companyDocumentArray);
                return response()->json(['status' => 'true', 'message' => 'Documents have been successfully uploaded.']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'false', 'message' => $e->getMessage()]);
        }
    }

    public function createCompanyDocumentArray(int $id, array $tradeLicenseImages, array $establishmentImages): array
    {
        $companyDocumentArray = [];

        foreach ($tradeLicenseImages as $file) {
            $companyDocumentArray[] = $this->createCompanyDocument($id, $file, 'Trade License');
        }

        foreach ($establishmentImages as $file) {
            $companyDocumentArray[] = $this->createCompanyDocument($id, $file, 'Establishment');
        }

        return $companyDocumentArray;
    }

    private function createCompanyDocument($companyId, $file, $documentType)
    {
        return [
            'company_id' => $companyId,
            'document_type' => $documentType,
            'file_name' => companyLogoFileUpload('company_user', $file),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    }
    public function staffDetailsUpdate(Request $request)
    {
        try {
            $id = $request->id;
            $user = User::findOrFail($id);
            if (empty($user)) {
                return Response::json(['user_notfound' => 'User profile not found.']);
            }
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string',
                    'contact_number' => 'required',
                ],
                [
                    'contact_number.required' => 'The contact number field is required.',
                    'contact_number.digits_between' => 'The contact number is invalid.',
                ]
            );
            if ($validator->passes()) {
                $user->name = $request->input('name');
                $user->contact_number = $request->input('contact_number');
                if ($user->save()) {
                    if (Auth::guard('web')->user()) {
                            $jsonCompanyhis = 'Updated profile information';
                            $moduleid = 2;
                            $userId = Auth::guard('web')->user()->id;
                            $action = "Updated";
                            $history = userHistoryManage($jsonCompanyhis, $moduleid, $userId, $action);
                    }
                    return Response::json(['success' => 'Profile information is successfully updated.']);
                } else {
                    return Response::json(['error_update' => 'An error occurred while updating profile information.']);
                }
            }
            return Response::json(['errors' => $validator->errors()]);
        } catch (\Exception $e) {
            return Response::json(['catch_error' => $e->getMessage()]);
        }
    }

    public function companyIndustryUpdate(\App\Http\Requests\Frontend\CreateCompanyDetailStepThreeRequest $request)
    {
        try {
            $user = Auth::guard('web')->user();
            if ($user) {               
                    $companyData = Company::select('id', 'user_id')->where('user_id', $user->id)->firstOrFail();
                    $companyId = $companyData->id;
                    $companyScopeArray = [];
                    $companyScopeArrayHome = [];
                    if (count($request->activity) > 0) {
                        foreach ($request->activity as $value) {
                            $activityData = Activity::select('name')->where('id', $value)->first();
                            $companyScopeObject = [
                                'company_id' => $companyId,
                                'activity_id' => $value,
                                'name' => $activityData->name,
                                'created_at' => now(),
                                'updated_at' => now()
                            ];
                            array_push($companyScopeArray, $companyScopeObject);
                            unset($companyScopeObject["name"]);
                            array_push($companyScopeArrayHome, $companyScopeObject);                            
                        }
                    }
                    $companySelectedActivityNames = \Illuminate\Support\Arr::pluck($companyScopeArray, 'name');
                    $selectedActivityFlag = false;
                    
                    if (count($companySelectedActivityNames) == 1 && in_array($companySelectedActivityNames[0], ['Home Office', 'Flight and Accommodation'])) {
                        $selectedActivityFlag = true;
                    }
                    
                    if (count($companySelectedActivityNames) == 2) {
                        sort($companySelectedActivityNames);
                        if ($companySelectedActivityNames == ['Flight and Accommodation', 'Home Office']) {
                            $selectedActivityFlag = true;
                        }
                    }
                    if($selectedActivityFlag == true){
                        CompanyActivity::where('company_id', $companyId)->delete();
                        CompanyActivity::insert($companyScopeArrayHome);
                        $companyData = Company::where('id', $companyId)->with('companyactivities.activity:id,name', 'companyactivities.activitydata:id,name')->first();
                        $emissonames = \Illuminate\Support\Arr::pluck($companyData->companyactivities->toArray(), 'activitydata.name');
                        $companyData->sample_datasheet = sheetGenerate($emissonames ,$companyId);
                        $companyData->save();
                    }
                    $jsonData = json_encode(['companyactivities' => $companyScopeArray, 'company_industry_id' => $request->company_industry_id]);
                    Company::where('id',$companyId)->update(['temp_json' => $jsonData]);                    
            }
            return response()->json(['status' => 'true', 'message' => 'Industry is successfully updated.', 'selectedActivityFlag' => $selectedActivityFlag]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'false', 'message' => $e->getMessage()]);
        }
    }
    public function companyIndustryUpdateAfterStep(ManageProfileEmissionRequest $request)
    {
        try {
            $user = Auth::guard('web')->user();
            if ($user) {
                //update first step
                $companyData = Company::select('id', 'company_industry_id', 'user_id', 'temp_json')->where('user_id', $user->id)->first();
                $companyDataJson = json_decode($companyData->temp_json, true); 
                $company_industry_id = $companyDataJson['company_industry_id'];
                $companyId = $companyData->id;
                $companyScopeArray = [];
                $companyActivities = $companyDataJson['companyactivities'];
                Company::where('user_id', $user->id)->update(['company_industry_id' => $company_industry_id]);
                if(!empty($companyActivities)){
                    $companyActivityOld = collect($companyActivities)->pluck('activity_id')->toArray();
                    $companyActivity = CompanyActivity::where('company_id',$companyId)->get()->pluck('activity_id')->toArray();
                    foreach($companyActivity as $emission){
                        if(!in_array($emission ,$companyActivityOld) && ($emission != 10 && $emission != 15)){
                            $activity = Activity::where('id',$emission)->first();
                            userEmissionDelete($activity->name,$companyId);
                        }
                    }
                }
                CompanyActivity::where('company_id', $companyId)->delete();
                
                if (count($companyActivities) > 0) {
                    foreach ($companyActivities as $value) {
                        $companyScopeObject = [
                            'company_id' => $companyId,
                            'activity_id' => $value['activity_id'],
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                        array_push($companyScopeArray, $companyScopeObject);
                    }
                }
                CompanyActivity::insert($companyScopeArray);
                Company::where('user_id', $user->id)->update(['temp_json' => Null]);
                //end first step
                $modelsMap = [
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
                    Activity::ELECTRICITY_HEAT_COOLING => UserEmissionElectricity::class,
                    Activity::FLIGHT_AND_ACCOMMODATION => UserEmissionFlight::class,
                ];

                // Check for freighting_goods_vanshgv
                if ($request->has('freighting_goods_vansHgv')) {
                    $modelsMap[Activity::FREIGHTING_GOODS_VansHgv] = UserEmissionFreightingGoodsVansHgv::class;
                }
        
                // Check for freighting_goods_flights_rail
                if ($request->has('freighting_goods_flights_rail')) {
                    $modelsMap[Activity::FREIGHTING_GOODS_FlightsRail] = UserEmissionFreightingGoodsFlightsRail::class;
                }
                // Check for owned_vehicles_passenger,delivery
                if ($request->has('owned_vehicles_delivery')) {
                    $modelsMap[Activity::OWNED_VEHICLES_DELIVERY] = UserEmissionVehicle::class;
                }
                if ($request->has('owned_vehicles_passenger')) {
                    $modelsMap[Activity::OWNED_VEHICLES_PASSENGER] = UserEmissionVehicle::class;
                }

                foreach ($modelsMap as $parameter => $model) {
                    if (isset($request->{$parameter})) {
                        if($parameter == 'owned_vehicles_passenger'){
                            $vehicle_type = '1';
                        }elseif($parameter == 'owned_vehicles_delivery'){
                            $vehicle_type = '2';
                        }else{
                            $vehicle_type = "";
                        }
                        $old_data = $model::where('company_id', $request->company_id);
                        if($vehicle_type != ""){
                            $old_data = $old_data->with('vehicles')->whereHas('vehicles', function($q)use($vehicle_type){
                                $q->where('vehicle_type', $vehicle_type);
                            });
                        }
                        $old_data = $old_data->pluck('factor_id')->toArray();                
                        $new_ids = [];
                        $removed_ids = [];
                        if(count($old_data)>0){
                            $new_ids = array_diff($request->{$parameter},$old_data);
                            $removed_ids = array_diff($old_data,$request->{$parameter});
                        }else{
                            $new_ids = $request->{$parameter};
                        }
                        if(count($removed_ids) >0){
                            $model::whereIn('factor_id',$removed_ids)->where('company_id',$request->company_id)->delete();
                        }
                        foreach($new_ids as $new_id){
                            $model_data = new $model;
                            $model_data->user_id = $request->user_id;
                            $model_data->company_id = $request->company_id;
                            $model_data->factor_id = $new_id;                        
                            $model_data->save();
                        }
                    }
                }
                $companyData = Company::where('id', $request->company_id)->with('companyactivities.activity:id,name', 'companyactivities.activitydata:id,name')->first();
                $emissonames = \Illuminate\Support\Arr::pluck($companyData->companyactivities->toArray(), 'activitydata.name');
                $companyData->sample_datasheet = sheetGenerate($emissonames ,$companyData->id);
                $companyData->save();
            }
            return response()->json(['status' => 'true', 'message' => 'Activity is successfully updated.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'false', 'message' => $e->getMessage()]);
        }
    }

    public function setactivityTab(Request $request)
    {
        $user = Auth::guard('web')->user();
        $page = CmsPages::where('slug', 'need-help')->first();
        $companyData = Company::select('id', 'company_industry_id', 'user_id', 'temp_json')->where('user_id', $user->id)->first();
        $companyData = json_decode($companyData->temp_json, true);    
       
        // foreach($companyData['companyactivities'] as $key=>$value)
        // {
        //     if($value['name'] == 'Home Office' || $value['name'] == 'Flight and Accommodation')
        //     {
        //         unset($companyData['companyactivities'][$key]);
        //     }
        // }
        $companyData['companyactivities'] = array_values($companyData['companyactivities']);
        
        $countryData = Country::where('name', 'United Arab Emirates')->get()->toArray();
        // $countryData = Country::get()->toArray();
        $countryIds = array_column($countryData, 'id');
        $countryNames = array_column($countryData, 'name');
        $cityData = City::get()->toArray();
        $cityIds = array_column($cityData, 'id');
        $cityNames = array_column($cityData, 'name');
        return view('frontend.profile.profile-industry-activity-tab', compact('companyData', 'page', 'countryIds', 'countryNames', 'cityIds', 'cityNames'));
    }
}
