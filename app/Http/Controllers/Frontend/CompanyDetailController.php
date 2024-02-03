<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\industryScope;
use App\Models\UserEmissionMaterialUse;
use App\Models\UserEmissionRefrigerant;
use App\Models\UserEmissionWatersupplytreatment;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ManageEmissionRequest;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Support\Facades\{
    DB,
    Auth,
    Config
};
use App\Http\Requests\Frontend\{
    CreateCompanyDetailStepOneRequest,
    CreateCompanyDetailStepThreeRequest,
    CreateCompanyDetailStepTwoRequest
};
use App\Models\{
    Company,
    CompanyAddress,
    CompanyDocument,
    CompanyIndustry,
    CompanyActivity,
    Activity,
    Country,
    CmsPages,
    UserEmissionBusinessTravel,
    UserEmissionEmployeesCommuting,
    UserEmissionFoodCosumption,
    UserEmissionFuel,
    UserEmissionTransmissionAndDistribution,
    UserEmissionWasteDisposal,
    UserEmissionWttFule,
    UserEmissionVehicle,
    UserEmissionElectricity,
    UserEmissionFreightingGoodsVansHgv,
    UserEmissionFreightingGoodsFlightsRail,
    UserEmissionFlight,
    City
};


class CompanyDetailController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = optional(Auth::guard('web')->user());
            // $countryData = Country::where('name', 'United Arab Emirates')->get()->toArray();
            $countryData = Country::WhereIn('name', Country::countries)->get()->toArray();
            $companyData = Company::select('id', 'user_id', 'company_name', 'trade_licence_number', 'no_of_employees', 'company_logo', 'is_draft', 'company_email', 'company_phone')
                ->with('companyaddresses', 'companyaddresses.countries:id,name')
                ->where('user_id', $user->id)
                ->first();
            $companyData['file_name'] = Company::getFileName($companyData->company_logo);
            return view('frontend.company-detail.step-one', compact('companyData', 'countryData'));
        } catch (\Exception $e) {
            return view('frontend.company-detail.step-one')->with('error', $e->getMessage());
        }
    }

    public function stepOneCreate(CreateCompanyDetailStepOneRequest $request)
    {
        try {
            $data = $this->companyObject($request);
            Company::updateOrInsert(['id' => $data['id']], $data);
            // Retrieve the company data
            $compantData = ($data['id']) ? Company::find($data['id']) : Company::latest()->first();
            // Delete existing addresses for the company
            CompanyAddress::where('company_id', $compantData->id)->delete();
            // Insert new company addresses
            CompanyAddress::insert($this->companyAddressObject($request, $compantData->id));
            return ($request->savedraft == 'savedraft') ? redirect()->route('company-detail-step-one.index')->with('success', 'Draft saved successfully') : redirect()->route('company-detail-step-two.index');
        } catch (\Exception $e) {
            return view('frontend.company-detail.step-one')->with('error', $e->getMessage());
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
            $user = Auth::guard('web')->user();
            $companyData = null;

            if (isset($request->id)) {
                $companyData = Company::find($request->id);
            }

            $data = [
                'user_id' => optional($user)->id,
                'company_name' => $request->company_name,
                'trade_licence_number' => $request->trade_licence_number,
                'no_of_employees' => $request->no_of_employees,
                // "company_industry_id" => 1,
                'company_email' => $request->company_email,
                'company_phone' => $request->company_phone,
                'is_draft' => '1',
                'draft_step' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'id' => $request->id ?? null,
            ];

            if ($request->hasFile('company_logo')) {
                if ($companyData) {
                    removeFile('company_user',  $request->file('company_logo'));
                }

                $data['company_logo'] = companyLogoFileUpload('company_user', $request->company_logo);
            }

            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function companyAddressObject($request, $companyId)
    {
        try {
            return [
                'company_id' => $companyId,
                'address' => $request->address,
                'city' => $request->city,
                'country_id' => $request->country_id,
                'created_at' => now(),
                'updated_at' => now()
            ];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function stepTwoIndex(Request $request)
    {
        try {
            if ($request->query('error')) {
                session(['error' => $request->query('error')]);
            }

            $user = optional(Auth::guard('web')->user());
            $companyData = Company::select('id', 'user_id')->where('user_id', $user->id)->first();
            if ($companyData == NULL) {
                return redirect()->route('company-detail-step-one.index');
            }

            $companyDocumentData = CompanyDocument::where('company_id', $companyData->id)->get()->toArray();
            return view('frontend.company-detail.step-two', compact('companyDocumentData'));
        } catch (\Exception $e) {
            return view('frontend.company-detail.step-two')->with('error', $e->getMessage());
        }
    }
    public function stepTwoCreate(Request $request)
    {
        try {
            if ($request->hasFile('trade_license') || $request->hasFile('establishment')) {
                $user = Auth::guard('web')->user();
                $companyData = Company::where('user_id', $user->id)->firstOrFail();
                $tradeLicenseImages = ($request->hasFile('trade_license')) ? $request->file('trade_license') : [];
                $establishmentImages = ($request->hasFile('establishment')) ?  $request->file('establishment') : [];
                $companyDocumentArray = $this->createCompanyDocumentArray($companyData->id, $tradeLicenseImages, $establishmentImages);
                CompanyDocument::insert($companyDocumentArray);
                Company::where('id', $companyData->id)->update(['draft_step' => 2]);
            }

            return ($request->savedraft == 'savedraft') ? redirect()->route('company-detail-step-two.index')->with('success', 'Draft saved successfully') : redirect()->route('company-detail-step-three.index');
        } catch (PostTooLargeException $e) {
            return view('frontend.company-detail.step-two')->with('error', 'File too large!');
        } catch (\Exception $e) {
            return redirect()->route('company-detail-step-two.index')->with('error', $e->getMessage());
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
    public function stepThreeIndex(Request $request)
    {
        try {
            $user = Auth::guard('web')->user();

            // Fetch company data with required columns only
            $companyData = Company::select('id', 'user_id', 'company_industry_id', 'draft_step')
                ->with('companyactivities:id,company_id,activity_id')
                ->where('user_id', $user->id)
                ->get()
                ->toArray();

            if ($companyData == NULL) {
                return redirect()->route('company-detail-step-one.index');
            }

            $activityData = Activity::select('id', 'name')->get()->toArray();

            // Fetch company industry data with required columns only
            $companyIndustryData = CompanyIndustry::select('id', 'name')
                ->get()
                ->toArray();

            return view('frontend.company-detail.step-three', compact('companyIndustryData', 'companyData', 'activityData'));
        } catch (\Exception $e) {
            return view('frontend.company-detail.step-three')->with('error', $e->getMessage());
        }
    }


    public function stepThreeCreate(CreateCompanyDetailStepThreeRequest $request)
    {
        try {
            $user = Auth::guard('web')->user();

            if ($user) {
                DB::transaction(function () use ($request, $user) {
                    $companyId = $request->id;
                    $companyScopeArray = [];
                    if (count($request->activity) > 0) {
                        foreach ($request->activity as $value) {
                            $companyScopeObject = [
                                'company_id' => $companyId,
                                'activity_id' => $value,
                                'created_at' => now(),
                                'updated_at' => now()
                            ];

                            array_push($companyScopeArray, $companyScopeObject);
                        }
                    }

                    if(!empty($request->activity)){
                        $companyActivity = CompanyActivity::where('company_id',$companyId)->get()->pluck('activity_id')->toArray();
                        foreach($companyActivity as $emission){
                            if(!in_array($emission ,$request->activity) && ($emission != 10 && $emission != 15)){
                                $activity = Activity::where('id',$emission)->first();
                                userEmissionDelete($activity->name,$companyId);
                            }
                        }
                    }

                    Company::where('user_id', $user->id)
                        ->update(['draft_step' => 3, 'company_industry_id' => $request->company_industry_id]);
                    CompanyActivity::where('company_id', $companyId)->delete();
                    CompanyActivity::insert($companyScopeArray);
                });

                $companyData = Company::where('user_id', $user->id)->with('companyactivities.activity:id,name', 'companyactivities.activitydata')->first();
                $companySelectedActivityNames = \Illuminate\Support\Arr::pluck($companyData->companyactivities->toArray(), 'activitydata.name');

                if (count($companySelectedActivityNames) == 1 && in_array($companySelectedActivityNames[0], ['Home Office', 'Flight and Accommodation'])) {
                    return ($request->savedraft == 'savedraft') ? redirect()->route('company-detail-step-three.index')->with('success', 'Draft saved successfully') : redirect()->route('company-detail-step-five.index');
                }

                if (count($companySelectedActivityNames) == 2) {
                    sort($companySelectedActivityNames);
                    if ($companySelectedActivityNames == ['Flight and Accommodation', 'Home Office']) {
                        return ($request->savedraft == 'savedraft') ? redirect()->route('company-detail-step-three.index')->with('success', 'Draft saved successfully') : redirect()->route('company-detail-step-five.index');
                    }
                }
            }

            return ($request->savedraft == 'savedraft') ? redirect()->route('company-detail-step-three.index')->with('success', 'Draft saved successfully') : redirect()->route('company-detail-step-four.index');
        } catch (\Exception $e) {
            return redirect()->route('company-detail-step-three.index')->with('error', $e->getMessage());
        }
    }

    public function stepFiveIndex(Request $request)
    {
        try {
            $page = CmsPages::where('slug', 'terms-and-conditions')->first();
            $user = optional(Auth::guard('web')->user());
            $companyData = Company::where('user_id', $user->id)->with('companyactivities.activity:id,name', 'companyactivities.activitydata:id,name')->first();
            $companySelectedActivity =   \Illuminate\Support\Arr::pluck($companyData->companyactivities->toArray(), 'activitydata.id');
            $industryScopeData = industryScope::with('activity')->where('industry_id', $companyData->company_industry_id)->get()->toArray();
            $companySelectedActivityNames = \Illuminate\Support\Arr::pluck($companyData->companyactivities->toArray(), 'activitydata.name');
            $selectedActivityTabs = $this->activityNameCheck($companySelectedActivityNames);
            $selectedActivityTab = false;

            if (count($companySelectedActivityNames) == 1 && in_array($companySelectedActivityNames[0], ['Home Office', 'Flight and Accommodation'])) {
                $selectedActivityTab = true;
            }

            if (count($companySelectedActivityNames) == 2) {
                sort($companySelectedActivityNames);
                if ($companySelectedActivityNames == ['Flight and Accommodation', 'Home Office']) {
                    $selectedActivityTab = true;
                }
            }

            $scopeOne = $this->processScopeData($industryScopeData, $companySelectedActivity, 1);
            $scopeTwo = $this->processScopeData($industryScopeData, $companySelectedActivity, 2);
            $scopeThree = $this->processScopeData($industryScopeData, $companySelectedActivity, 3);
            if ($companyData == null) {
                return redirect()->route('company-detail-step-one.index');
            }

            return view('frontend.company-detail.step-five', compact('companyData', 'page', 'scopeOne', 'scopeTwo', 'scopeThree', 'selectedActivityTab'));
        } catch (\Exception $e) {
            return view('frontend.company-detail.step-five')->with('error', $e->getMessage());
        }
    }

    public function stepFiveCreate()
    {
       
        try {
            $user = optional(Auth::guard('web')->user());
            $companyData = Company::where('user_id', $user->id)->with('companyactivities.activity:id,name', 'companyactivities.activitydata:id,name')->first();
            Company::where('user_id', $user->id)->update([ 'is_draft' => '0', 'draft_step' => 5, 'sample_datasheet' => sheetGenerate(\Illuminate\Support\Arr::pluck($companyData->companyactivities->toArray(), 'activitydata.name'), $companyData->id)]);
            sendEmail($user->email, $companyData,  Config::get('constants.emailSubject.customerOnBoarding'), Config::get('constants.emailPageUrl.customerOnBoarding'));
            return redirect()->route('dashboard.index')->with('success', 'Your onboarding process is successfully completed!');
        } catch (\Exception $e) {
            return redirect()->route('company-detail-step-five.index')->with('error', $e->getMessage());
        }
    }
    public function checkCompanyDetailSaveAsDraft()
    {
        $user = optional(Auth::guard('web')->user());
        $companyData = Company::where('user_id', $user->id)->first();

        return $companyData ? $companyData->is_draft == '1' : true;
    }
    public function stepFourIndex(Request $request)
    {
        try {
            $page = CmsPages::where('slug', 'need-help')->first();
            $user = optional(Auth::guard('web')->user());
            $companyData = Company::where('user_id', $user->id)->with('companyactivities.activity:id,name')->first();
            $countryData = Country::get()->toArray();
            $countryIds = array_column($countryData, 'id');
            $countryNames = array_column($countryData, 'name');
            $cityData = City::get()->toArray();
            $cityIds = array_column($cityData, 'id');
            $cityNames = array_column($cityData, 'name');
            foreach ($companyData->companyactivities as $key => $value) {
                if (isset($value['activity']['name']) === false) {
                    unset($companyData->companyactivities[$key]);
                }
            }

            $companyData->companyactivities = array_values($companyData->companyactivities->toArray());
            $companySelectedActivity =   \Illuminate\Support\Arr::pluck($companyData->companyactivities, 'activity.id');
            $companySelectedActivityName =   \Illuminate\Support\Arr::pluck($companyData->companyactivities, 'activity.name');


            $industryScopeData = industryScope::with('activity')->where('industry_id', $companyData->company_industry_id)->get()->toArray();
            $scopeOne = $this->processScopeData($industryScopeData, $companySelectedActivity, 1);
            $scopeTwo = $this->processScopeData($industryScopeData, $companySelectedActivity, 2);
            $scopeThree = $this->processScopeData($industryScopeData, $companySelectedActivity, 3);

            return view('frontend.company-detail.step-four', compact('companyData', 'page', 'countryIds', 'countryNames', 'cityIds', 'cityNames', 'industryScopeData', 'scopeOne', 'scopeTwo', 'scopeThree'));
        } catch (\Exception $e) {
            return view('frontend.company-detail.step-four')->with('error', $e->getMessage());
        }
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

    public function stepFourCreate(ManageEmissionRequest $request)
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

                    $model::insert($this->selectedEmissionFactorArray($new_ids,  $request->user_id, $request->company_id));
                }
            }
            Company::where('id', $request->company_id)->update(['draft_step' => 4]);

            return ($request->savedraft == 'savedraft') ? redirect()->route('company-detail-step-four.index')->with('success', 'Draft saved successfully') : redirect()->route('company-detail-step-five.index');
        } catch (\Exception $e) {
            return redirect()->route('company-detail-step-four.index')->with('error', $e->getMessage());
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
        ];
    }

    public function activityNameCheck($companySelectedActivityNames)
    {
        $selectedActivityTab = false;

        if (count($companySelectedActivityNames) == 1 && in_array($companySelectedActivityNames[0], ['Home Office', 'Flight and Accommodation'])) {
            $selectedActivityTab = true;
        }

        if (count($companySelectedActivityNames) == 2) {
            sort($companySelectedActivityNames);
            if ($companySelectedActivityNames == ['Flight and Accommodation', 'Home Office']) {
                $selectedActivityTab = true;
            }
        }

    return $selectedActivityTab;
    }
    public function emissionData(Request $request)
    {
        return getSelectedActivityData($request->slug, $request->company_id);
    }
}
