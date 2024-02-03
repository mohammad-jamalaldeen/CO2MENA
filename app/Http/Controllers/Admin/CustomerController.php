<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use App\Http\Requests\Admin\CustomerRequest;
use App\Http\Requests\Admin\CustomerUpdateRequest;
use App\Http\Requests\Admin\ManageEmissionRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Activity;
use App\Models\City;
use App\Models\CompanyIndustry;
use App\Models\CompanyActivity;
use App\Models\Company;
use App\Models\CompanyAddress;
use App\Models\CompanyBackup;
use App\Models\CompanyDocument;
use App\Models\CompanyKycMail;
use App\Models\User;
use App\Models\Country;
use App\Models\Datasheet;
use App\Models\industryScope;
use App\Models\StaffCompany;
use App\Models\UserEmissionBusinessTravel;
use App\Models\UserEmissionElectricity;
use App\Models\UserEmissionEmployeesCommuting;
use App\Models\UserEmissionFlight;
use App\Models\UserEmissionFoodCosumption;
use App\Models\UserEmissionFreightingGoodsFlightsRail;
use App\Models\UserEmissionFreightingGoodsVansHgv;
use App\Models\UserEmissionFuel;
use App\Models\UserEmissionMaterialUse;
use App\Models\UserEmissionRefrigerant;
use App\Models\UserEmissionTransmissionAndDistribution;
use App\Models\UserEmissionVehicle;
use App\Models\UserEmissionWasteDisposal;
use App\Models\UserEmissionWatersupplytreatment;
use App\Models\UserEmissionWttFule;
use App\Models\UserRole;
use App\Models\UserSubscription;
use Exception;

class CustomerController extends Controller
{
    /*****
     * View Index page 
     * */
    public function index(Request $request)
    {
        $userModel = Auth::guard('admin')->user();
        if ($request->ajax()) {

            $sort_col = "";

            $obj1 = Company::with(['user', 'industry'])->whereHas('user', function ($query) use ($request) {
                $query->whereNull('users.deleted_at');
            })->whereNull('companies.deleted_at');
            
            $sortField = '';
            $sortOrder = '';
            if (empty($request->get('order')) && empty($request->get('order')[0]) && empty($request->get('order')[0]['column']) && empty($request->get('order')[0]['dir'])) {
                $obj1->orderBy('companies.created_at', 'DESC');
            } else {
                $sortField = $request->get('columns')[$request->get('order')[0]['column']]['name'];
                $sortOrder = strtoupper($request->get('order')[0]['dir']);
            }

            if (($request->status_filter == 0 || $request->status_filter == 1) && isset($request->status_filter)) {
                $obj1->whereHas('user', function ($query) use ($request) {
                    $query->where('status', $request->status_filter);
                });
            }

            if (!empty($request->industry_filter)) {
                $obj1->where('companies.company_industry_id', $request->industry_filter);
            }

            return DataTables::of($obj1)->make(true);
        }
        $industryarr = CompanyIndustry::orderBy('name', 'asc')->get()->toArray();
        return view('admin.customer.list', compact('userModel', 'industryarr'));
    }

    /*****
     * customer create page
     * */
    public function create()
    {
        $companyIndustry = CompanyIndustry::whereNull('deleted_at')->orderBy('name', 'asc')->get();
        $scopes = Activity::whereNull('deleted_at')->orderBy('name', 'asc')->get();
        // $countryData = Country::where('name', 'United Arab Emirates')->whereNull('deleted_at')->get()->toArray();
        $countryData = Country::WhereIn('name', Country::countries)->get()->toArray();
        // $countryData = Country::whereNull('deleted_at')->get()->toArray();
        $userRoles = UserRole::where('type','Frontend')->get()->toArray();
        return view('admin.customer.create', compact('companyIndustry', 'scopes', 'countryData', 'userRoles'));
    }
    /*****
     * customer Store
     * */
    public function store(CustomerRequest $request)
    {
        try {
            $userInfo = new User();
            $password = generatePassword();
            $userInfo->name = $request->company_organization;
            $userInfo->username = strtolower(substr(str_replace(' ', '', $request->company_organization),0,8)).rand(100,1000000);
            $userInfo->email = $request->email;
            $userInfo->password = Hash::make($password);
            $userInfo->status = '1';
            $userInfo->user_role_id = $request->user_role;
            $userInfo->save();
            if ($userInfo) {
                $companyInfo = new Company();
                $companyInfo->user_id = $userInfo->id;
                $companyInfo->company_name = $request->company_name;
                $companyInfo->trade_licence_number = $request->trade_licence_number;
                $companyInfo->no_of_employees = $request->no_of_employees;
                $companyInfo->company_industry_id = $request->industry;
                $companyInfo->company_email = $request->company_email;
                $companyInfo->company_phone = $request->company_phone_number;
                $companyInfo->company_account_id = generateAccountId();
                // $companyInfo->phone_prefix = $request->phone_prefix;
                if(!empty($request->emissionscope) && count($request->emissionscope) > 0){
                    if(count($request->emissionscope) == 2 && count(array_diff($request->emissionscope,['10','15']))== 0){
                        $companyInfo->is_draft = "0";    
                    }elseif(count($request->emissionscope) == 1 && in_array($request->emissionscope[0],['10','15']) ){
                        $companyInfo->is_draft = "0";
                    }else{
                        $companyInfo->is_draft = "1";
                    }
                }else{
                    $companyInfo->is_draft = "1";
                }
                
                $companyInfo->draft_step = "1";
                $imageName = null;
                if ($request->file('company_logo') && $request->hasFile('company_logo')) {
                    $fileName = $request->file('company_logo');
                    $imageName = renameFile($fileName->getClientOriginalName());
                    Storage::disk('company_user')->put("/{$imageName}", file_get_contents($fileName->getRealPath()));
                }

                $companyInfo->company_logo = $imageName;
                $companyInfo->save();
                $tradeLicenseImages = ($request->hasFile('tradeLicense')) ? $request->file('tradeLicense') : [];
                $establishmentImages = ($request->hasFile('established')) ?  $request->file('established') : [];
                $companyDocumentArray = $this->createCompanyDocumentArray($companyInfo->id, $tradeLicenseImages, $establishmentImages);
                CompanyDocument::insert($companyDocumentArray);
                if (!empty($request->address) || !empty($request->city) || !empty($request->country_id)) {
                    CompanyAddress::insert([
                        'company_id' => $companyInfo->id,
                        'address' => $request->address,
                        'city' => $request->city,
                        'country_id' => $request->country_id,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }

                if (!empty($request->emissionscope)) {
                    $scopCompanyArr = [];
                    foreach ($request->emissionscope as $scope) {
                        $scopCompanyobj  = [
                            'activity_id' =>  $scope,
                            'company_id' =>  $companyInfo->id,
                        ];
                        array_push($scopCompanyArr, $scopCompanyobj);
                    }
                    CompanyActivity::insert($scopCompanyArr);
                }

                if (!empty($request->subscription_start_date) && !empty($request->subscription_end_date)) {
                    $userSubscription = new UserSubscription();
                    $userSubscription->user_id  = $userInfo->id;
                    $userSubscription->company_id  = $companyInfo->id;
                    $userSubscription->updated_by  = Auth::guard('admin')->user()->id;
                    $userSubscription->start_date  = $request->subscription_start_date;
                    $userSubscription->end_date  = $request->subscription_end_date;
                    $userSubscription->save();
                }
                if (Auth::guard('admin')->user()) {
                    if(isset($request->company_name)){
                        $message = 'Add new Company "' . $companyInfo->company_name . '"';
                    }else{
                        $message = 'Add new Customer "' . $request->company_organization . '"';
                    }
                    userHistoryManage($message, '8', Auth::guard('admin')->user()->id, 'Created');
                }

                /**************************Mail Funcusernametionality*************************************/
                $adminInfo = User::where('user_role_id', '1')->first();
                $industry = CompanyIndustry::where('id', $companyInfo->company_industry_id)->first();
                $datauser = [
                    'name' => $userInfo->name,
                    'Company_name' => $companyInfo->company_name,
                    'Company_Email' => $companyInfo->company_email,
                    'company_logo' =>  $companyInfo->company_logo,
                    'company_industry' => !empty($industry->name) ? $industry->name : "",
                    'user_email' => $userInfo->email,
                    'user_name' => $userInfo->username,
                    'password' => $password,
                    'account_id' => $companyInfo->company_account_id,
                    'content' => "Your account is created. Please check below account details."
                ];
                //Mail::to($userInfo->email)->cc($adminInfo->email)->send(new CompanyAdminMail($datauser));
                sendEmail($userInfo->email, $datauser, Config::get('constants.emailSubject.CompanyAdminMail'), Config::get('constants.emailPageUrl.CustomerCreateMail'), [], "", $adminInfo->email);
                return redirect()->route('customer.index')->with('success', 'Company is successfully created.');
            } else {
                return redirect()->route('customer.index')->with('error', 'An error occurred while creating company.');
            }
        } catch (Exception $e) {
            return redirect()->route('customer.index')->with('error', $e->getMessage());
        }
        abort(404);
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
    /*****
     * customer details page show
     * */
    public function show(Request $request, $id)
    {
        try {
            if (!empty($id)) {
                $companyInfo = Company::with(['user', 'user.role',  'industry', 'companyactivities.activity', 'companyaddressesone', 'companyaddressesone.countries:id,name','companyactivities.activitydata'])->where('user_id', $id)->whereNull('deleted_at')->first();
                $scopeArray = [];
                if (!empty($companyInfo->companyactivities) && count($companyInfo->companyactivities) > 0) {
                    foreach ($companyInfo->companyactivities as $companyScope) {
                        $scopeArray[] = $companyScope->activitydata->name;
                    }
                }
                $companySelectedActivity = \Illuminate\Support\Arr::pluck($companyInfo->companyactivities->toArray(), 'activitydata.id');
                $industryScopeData = industryScope::with('activity')->where('industry_id', $companyInfo->company_industry_id)->get()->toArray();
                $scopeOne = $this->processScopeData($industryScopeData, $companySelectedActivity, 1);
                $scopeTwo = $this->processScopeData($industryScopeData, $companySelectedActivity, 2);
                $scopeThree = $this->processScopeData($industryScopeData, $companySelectedActivity, 3);
                
                if ($request->ajax()) {
                    $companyData = Company::select('id','user_id')->where('user_id', $request->id)->first();
                    $userSubscription = UserSubscription::with('user')->where('company_id', $companyData->id)->whereNull('deleted_at')->get();
                    return DataTables::of($userSubscription)->make(true);
                }
                $companyDocument = CompanyDocument::where('company_id', $id)->whereNull('deleted_at')->get()->toArray();

                $datsheetCount = Datasheet::where('company_id', $companyInfo->id)->count();
                return view('admin.customer.show', compact('scopeOne', 'scopeTwo', 'scopeThree',  'companyInfo', 'scopeArray', 'companyDocument', 'datsheetCount'));
            }
        } catch (Exception $e) {
            return redirect()->route('customer.index')->with('error', $e->getMessage());
        }

        abort(404);
    }

    function processScopeData($industryScopeData, $companySelectedActivity, $scopeId)
    {
        $scope = [];
        foreach ($industryScopeData as $value) {
            if ($value['scope_id'] === $scopeId && in_array($value['activity_id'], $companySelectedActivity)) {
                $scope[] = $value['activity']['name'];
            }
        }

        return $scope;
    }

    /*****
     * Customer details  edit
     */
    public function edit($id)
    {
        // Fetch scope data with required columns only
        $scopeData = Activity::whereNull('deleted_at')->orderBy('name', 'asc')->get();
        // $countryData = Country::where('name', 'United Arab Emirates')->whereNull('deleted_at')->get()->toArray();
        $countryData = Country::WhereIn('name', Country::countries)->get()->toArray();
        // $countryData = Country::whereNull('deleted_at')->get()->toArray();
        $companyInfo = Company::with('companyactivities:id,company_id,activity_id', 'user', 'usersubscription', 'companyaddresses', 'companyaddresses.countries:id,name')
            ->where('user_id', $id)
            ->whereNull('deleted_at')
            ->get()
            ->toArray();
        
        $scopeArray = [];
        if(!empty($companyInfo) && !empty($companyInfo[0]['companyactivities'])){
            if (count($companyInfo[0]['companyactivities']) > 0) {
                foreach ($companyInfo[0]['companyactivities'] as $value) {
                    $scopeArray[] = $value['activity_id'];
                }
            }
        }
        
        $companyIndustry = CompanyIndustry::whereNull('deleted_at')->select('id', 'name')
            ->get()
            ->toArray();
        $companuDocuments = CompanyDocument::whereNull('deleted_at')->where('company_id', $id)->get()->toArray();
        $userRoles = UserRole::where('type','Frontend')->get()->toArray();
        return view('admin.customer.edit', compact('companyInfo', 'scopeData', 'companyIndustry', 'scopeArray', 'countryData', 'companuDocuments', 'userRoles'));
    }

    /****
     * 
     * customer details update
     * 
     *****/
    public function update(CustomerUpdateRequest $request, $id)
    {
        try {
            $user = User::where('email', $request->email)->first();
            $user->user_role_id = $request->user_role;
            $user->save();
            $companyInfo = Company::where('id', $id)->first();
            if (!empty($companyInfo)) {
                $companyInfo->company_name = $request->company_name;
                $companyInfo->trade_licence_number = $request->trade_licence_number;
                $companyInfo->no_of_employees = $request->no_of_employees;
                $companyInfo->company_phone = $request->company_phone_number;
                $companyInfo->company_email = $request->company_email;
                $companyInfo->company_industry_id = $request->industry;
                // $companyInfo->phone_prefix = $request->phone_prefix;
                if ($request->file('company_logo') && $request->hasFile('company_logo')) {
                    $fileName = $request->file('company_logo');
                    $imageName = renameFile($fileName->getClientOriginalName());
                    Storage::disk('company_user')->put("/{$imageName}", file_get_contents($fileName->getRealPath()));
                } else {
                    $imageName = $request->hidden_company_logo;
                }
                $companyInfo->company_logo = $imageName;

                if(!empty($request->emissionscope)){
                    if($companyInfo->is_draft != 0){
                        if(count($request->emissionscope) == 2 && count(array_diff($request->emissionscope,['10','15']))== 0){
                            $companyInfo->is_draft = "0";
                        }elseif(count($request->emissionscope) == 1 && in_array($request->emissionscope[0],['10','15']) ){
                            $companyInfo->is_draft = "0";
                        }
                    }
                }
                $companyInfo->save();

                
                
                $tradeLicenseImages = ($request->hasFile('tradeLicense')) ? $request->file('tradeLicense') : [];
                $establishmentImages = ($request->hasFile('established')) ?  $request->file('established') : [];
                $companyDocumentArray = $this->createCompanyDocumentArray($companyInfo->id, $tradeLicenseImages, $establishmentImages);

                if (!empty($tradeLicenseImages) && count($tradeLicenseImages) > 0) {
                    CompanyDocument::where(['company_id' => $id, 'document_type' => 'Trade License'])->delete();
                }

                if (!empty($establishmentImages) && count($establishmentImages) > 0) {
                    CompanyDocument::where(['company_id' => $id, 'document_type' => 'Establishment'])->delete();
                }

                CompanyDocument::insert($companyDocumentArray);

                if (!empty($request->address) || !empty($request->city) || !empty($request->country_id)) {
                    CompanyAddress::where('company_id', $id)->delete();
                    CompanyAddress::insert([
                        'company_id' => $id,
                        'address' => $request->address,
                        'city' => $request->city,
                        'country_id' => $request->country_id,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }

                if(!empty($request->emissionscope)){
                    $companyActivity = CompanyActivity::where('company_id',$id)->get()->pluck('activity_id')->toArray();
                    foreach($companyActivity as $emission){
                        if(!in_array($emission ,$request->emissionscope) && ($emission != 10 && $emission != 15)){
                            $activity = Activity::where('id',$emission)->first();
                            userEmissionDelete($activity->name,$id);
                        }
                    }
                }
                CompanyActivity::where('company_id', $id)->delete();
                if (!empty($request->emissionscope)) {
                    $scopCompanyArr = [];
                    foreach ($request->emissionscope as $scope) {
                        $scopCompanyobj  = [
                            'activity_id' =>  $scope,
                            'company_id' =>  $companyInfo->id,
                        ];
                        array_push($scopCompanyArr, $scopCompanyobj);
                    }
                    CompanyActivity::insert($scopCompanyArr);
                }
                $userSubscription = UserSubscription::where(['user_id' => $user->id, 'company_id' => $companyInfo->id])->whereNull('deleted_at')->orderBy('created_at', 'desc')->latest()->first();
                if ((!empty($request->subscription_start_date) && !empty($userSubscription) && $request->subscription_start_date != date('Y-m-d', strtotime($userSubscription->start_date))) || (!empty($userSubscription) && !empty($request->subscription_end_date) && $request->subscription_end_date != date('Y-m-d', strtotime($userSubscription->end_date)))) {
                    $userSubscription = new UserSubscription();
                    $userSubscription->user_id  = $user->id;
                    $userSubscription->company_id  = $companyInfo->id;
                    $userSubscription->updated_by  = Auth::guard('admin')->user()->id;
                    $userSubscription->start_date  = $request->subscription_start_date;
                    $userSubscription->end_date  = $request->subscription_end_date;
                    $userSubscription->save();
                    if (Auth::guard('admin')->user()) {
                        $jsonCompanyhis = 'Updated company subscription "' . $companyInfo->company_name . '"';
                        $moduleid = 8;
                        $userId = Auth::guard('admin')->user()->id;
                        $action = "Updated";
                        $history = userHistoryManage($jsonCompanyhis, $moduleid, $userId, $action);
                    }
                } else {
                    if (empty($userSubscription)) {
                        $userSubscription = new UserSubscription();
                        $userSubscription->user_id  = $user->id;
                        $userSubscription->company_id  = $companyInfo->id;
                        $userSubscription->updated_by  = Auth::guard('admin')->user()->id;
                        $userSubscription->start_date  = $request->subscription_start_date;
                        $userSubscription->end_date  = $request->subscription_end_date;
                        $userSubscription->save();
                        if (Auth::guard('admin')->user()) {
                            $jsonCompanyhis = 'Created company subscription "' . $companyInfo->company_name . '"';
                            $moduleid = 8;
                            $userId = Auth::guard('admin')->user()->id;
                            $action = "Created";
                            $history = userHistoryManage($jsonCompanyhis, $moduleid, $userId, $action);
                        }
                    }
                }

                if (Auth::guard('admin')->user()) {
                    $jsonCompanyhis = 'Updated company "' . $companyInfo->company_name . '"';
                    $moduleid = 8;
                    $userId = Auth::guard('admin')->user()->id;
                    $action = "Updated";
                    $history = userHistoryManage($jsonCompanyhis, $moduleid, $userId, $action);
                }
                return redirect()->route('customer.index')->with('success', 'Company is successfully updated.');
            } else {
                return redirect()->route('customer.index')->with('error', 'An error occurred while updating company.');
            }
        } catch (Exception $e) {
            return redirect()->route('customer.index')->with('error', $e->getMessage());
        }
        abort(404);
    }

    /*****
     * 
     * customer Delete
     * 
     ****/
    public function destroy($id)
    {
        try {
            $company = Company::findOrFail($id);
            $userDetails = User::find($company->user_id);
            CompanyActivity::where('company_id', $id)->delete();
            CompanyAddress::where('company_id', $id)->delete();
            CompanyDocument::where('company_id', $id)->delete();
            Datasheet::where('company_id', $id)->delete();
            UserSubscription::where('company_id', $id)->delete();

            if ($company->delete()) {
                $userDetails->delete();
                StaffCompany::where('company_id', $id)->get()->each(function ($staff) {
                    User::where('id', $staff->user_id)->delete();
                    $staff->delete();
                });
                CompanyBackup::where('company_id', $id)->get()->each(function ($backup) {
                    if (!empty($backup->file)) {
                        Storage::disk('backup')->delete($backup->file);
                    }
                    $backup->delete();
                });
                if (Auth::guard('admin')->user()) {
                    $jsonCompanyHistory = 'Deleted company "' . $company->company_name . '"';
                    $moduleid = 8;
                    $userId = Auth::guard('admin')->user()->id;
                    $action = "Deleted";
                    $history = userHistoryManage($jsonCompanyHistory, $moduleid, $userId, $action);
                }
                return redirect()->route('customer.index')->with('success', 'Company is successfully deleted.');
            }
        } catch (Exception $e) {
            return redirect()->route('customer.index')->with('error', $e->getMessage());
        }
    }

    public function pendingDocument(Request $request)
    {
        try {
            $companykycMail = new CompanyKycMail();
            $companykycMail->user_id = $request->user_id;
            $companykycMail->company_id = $request->company_id;
            $companykycMail->message = $request->document;
            $companykycMail->save();

            $userInfo = User::where('id', $companykycMail->user_id)->with('company')->whereNull('deleted_at')->first();
            if (!empty($userInfo)) {
                $data = [
                    'name' => $userInfo->name,
                    'content' => $companykycMail->message,
                    'company_logo' => $userInfo->company->company_logo
                ];
                $companyInfo = Company::find($request->company_id);
                
                if (Auth::guard('admin')->user()) {
                    $jsonCompanyhis = 'mail sent for pending document for "' . $companyInfo->company_name . '"';
                    $moduleid = 8;
                    $userId = Auth::guard('admin')->user()->id;
                    $action = "Mail";
                    $history = userHistoryManage($jsonCompanyhis, $moduleid, $userId, $action);
                }
             
                sendEmail($userInfo->email, $data, Config::get('constants.emailSubject.CompanyPendingDocumentMail'), Config::get('constants.emailPageUrl.companydocument'), [], "");
                return redirect()->route('customer.index')->with('success', 'Pending document email is successfully sent.');
            } else {
                return redirect()->route('customer.index')->with('error', 'Something went wrong.');
            }
        } catch (Exception $e) {
            return redirect()->route('customer.index')->with('error', $e->getMessage());
        }
    }

    public function statusChange(Request $request)
    {
        try {
            $userinfo = User::find($request->user_id);
            $userinfo->status = $request->status;
            $userinfo->save();
            return response()->json(['status' => true, "message" => "Status has been successfully changed."]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, "message" => "Status has been not changed. "]);
        }
    }

    public function manageEmission($userid)
    {
        $companyData = Company::where('companies.user_id', $userid)->with('companyactivities.activity:id,name')->whereNull('deleted_at')->first();
        $cityData = City::whereNull('deleted_at')->get()->toArray();
        $cityIds = array_column($cityData, 'id');
        $cityNames = array_column($cityData, 'name');
        foreach ($companyData->companyactivities as $key => $value) {
            if (isset($value['activity']['name']) === false) {
                unset($companyData->companyactivities[$key]);
            }
        }
        $companyData->companyactivities = array_values($companyData->companyactivities->toArray());
        return view('admin.customer.emission', compact('companyData', 'cityData', 'cityIds', 'cityNames'));
    }
    public function manageEmissionStore(ManageEmissionRequest $request)
    {
        try {
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
                    if ($parameter == 'owned_vehicles_passenger') {
                        $vehicle_type = '1';
                    } elseif ($parameter == 'owned_vehicles_delivery') {
                        $vehicle_type = '2';
                    } else {
                        $vehicle_type = "";
                    }
                    $old_data = $model::where('company_id', $request->company_id);
                    if ($vehicle_type != "") {
                        $old_data = $old_data->with('vehicles')->whereHas('vehicles', function ($q) use ($vehicle_type) {
                            $q->where('vehicle_type', $vehicle_type);
                        });
                    }
                    $old_data = $old_data->pluck('factor_id')->toArray();
                    $new_ids = [];
                    $removed_ids = [];
                    if (count($old_data) > 0) {
                        $new_ids = array_diff($request->{$parameter}, $old_data);
                        $removed_ids = array_diff($old_data, $request->{$parameter});
                    } else {
                        $new_ids = $request->{$parameter};
                    }
                    if (count($removed_ids) > 0) {
                        $model::whereIn('factor_id', $removed_ids)->where('company_id', $request->company_id)->delete();
                    }

                    $model::insert($this->selectedEmissionFactorArray($new_ids, $request->user_id, $request->company_id));
                }
            }
            $companyData = Company::where('id', $request->company_id)->with('companyactivities.activitydata:id,name')->first();
            $emissonames = \Illuminate\Support\Arr::pluck($companyData->companyactivities->toArray(), 'activitydata.name');
            if(!empty($emissonames)){
                $companyData->sample_datasheet = sheetGenerate($emissonames ,$companyData->id);
                $companyData->is_draft = 1;
                $companyData->save();
            }
            return redirect()->route('customer.index')->with('success', 'Activities have been successfully stored.');
        } catch (Exception $e) {
            return redirect()->route('customer.index')->with('error', $e->getMessage());
        }
    }

    public function selectedEmissionFactorArray($emissionArray, $user_id, $company_id)
    {
        $userEmissionArray = [];
        foreach ($emissionArray as $value) {
            array_push($userEmissionArray, $this->selectedEmissionFactorObject($user_id, $company_id, $value));
        }

        return $userEmissionArray;
    }

    public function selectedEmissionFactorObject($user_id, $company_id, $factor_id)
    {
        return [
            'user_id' => $user_id,
            'company_id' => $company_id,
            'factor_id' => $factor_id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
    }

    public function customeremissionData(Request $request)
    {
        return getSelectedActivityData($request->slug, $request->company_id);
    }
}
