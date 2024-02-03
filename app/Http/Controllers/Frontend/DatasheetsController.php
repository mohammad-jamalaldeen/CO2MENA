<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Rules\CustomDateRangeValidation;
use Illuminate\Support\Facades\DB;
use Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Jobs\DatasheetCalculationJob;
use App\Models\UserRole;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\Style\{
    Alignment,
    Fill
};
use App\Models\{
    Refrigerant,
    Datasheet,
    Company,
    User,
    StaffCompany,
    Fuels,
    City,
    Vehicle,
    Electricity,
    WttFules,
    TransmissionAndDistribution,
    Watersupplytreatment,
    MaterialUse,
    WasteDisposal,
    BusinessTravels,
    CompanyPublishSheet,
    EmployeesCommuting,
    FreightingGoodsVansHgvs,
    FreightingGoodsFlightsRails,
    FoodCosumption,
    Country,
};


class DatasheetsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        // DatasheetCalculationJob::dispatch($datasheetId=17);
        $userModel = Auth::guard('web')->user();
        $id = $userModel->id;
        $companyInfo = [];
        $companyAdminRoleID = UserRole::where('role', 'Company Admin')->first();
        $staffID = UserRole::whereNot('role', 'Company Admin')->where('type', 'Frontend')->pluck('id')->toArray();
        if (Auth::guard('web')->user()->user_role_id == $companyAdminRoleID->id) {
            $companyInfo = Company::select('id', 'sample_datasheet')->where('user_id', $id)->first();
            $company_id = $companyInfo->id;
        } else if (in_array(Auth::guard('web')->user()->user_role_id, $staffID)) {
            $staffInfo = StaffCompany::where('user_id', $id)->first();
            $company_id = $staffInfo->company_id;
            $companyInfo = Company::select('sample_datasheet')->where('id', $company_id)->first();
        }
        $sampleDataSheetURL = "#!";
        if (!empty($companyInfo->sample_datasheet)) {
            $sampleDataSheetURL = $companyInfo->sample_datasheet;
        }
        $datasheets = Datasheet::select('last_action_by')->where('company_id', $company_id)->groupBy('last_action_by')->get();
        $filterLastAction = $datasheets;
        return view('frontend.datasheets.index', compact('datasheets', 'sampleDataSheetURL', 'filterLastAction'));
    }

    public function ajaxlist(Request $request)
    {
        $userModel = Auth::guard('web')->user();
        $id = $userModel->id;
        $companyAdminRoleID = UserRole::where('role', 'Company Admin')->first();
        $staffID = UserRole::whereNot('role', 'Company Admin')->where('type', 'Frontend')->pluck('id')->toArray();
        if (Auth::guard('web')->user()->user_role_id == $companyAdminRoleID->id) {
            $companyInfo = Company::select('id', 'sample_datasheet')->where('user_id', $id)->first();
            $company_id = $companyInfo->id;
        } else if (in_array(Auth::guard('web')->user()->user_role_id, $staffID)) {
            $staffInfo = StaffCompany::where('user_id', $id)->first();
            $company_id = $staffInfo->company_id;
        }
        $obj1 = Datasheet::where('company_id', $company_id)->whereNull('deleted_at');
        // if($request->draw != '1')
        // {
            if (isset($request->status_filter)) {
                $obj1->where('status', $request->status_filter);
            } else {
                $obj1;
            }
            if (isset($request->last_action_by_filter)) {
                $obj1->where('last_action_by', $request->last_action_by_filter);
            } else {
                $obj1;
            }
            if (isset($request->dateTimePicker_filter)) {
                $obj1->where(DB::raw("DATE_FORMAT(date_time, '%Y-%m-%d %H:%i')"), $request->dateTimePicker_filter);
            } else {
                $obj1;
            }
        // }
    
        if (isset($request->viewreportingDate_filter)) {
            $reporting_date = $request->viewreportingDate_filter;
            $dateRangeArray = explode(' to ', $reporting_date);
            if (count($dateRangeArray) == 1) {
                $startDate = $dateRangeArray[0];
                $reporting_start_date = date('Y-m-d', strtotime($startDate));
                $obj1->where(DB::raw('DATE(reporting_start_date)'), $reporting_start_date);
            } else if (count($dateRangeArray) == 2) {
                $startDate = $dateRangeArray[0];
                $endDate = $dateRangeArray[1];
                $reporting_start_date = date('Y-m-d', strtotime($startDate));
                $reporting_end_date = date('Y-m-d', strtotime($endDate));
                $obj1->where(DB::raw('DATE(reporting_start_date)'), $reporting_start_date)->where(DB::raw('DATE(reporting_end_date)'), $reporting_end_date);
            } else {
                $obj1;
            }
        } else {
            $obj1;
        }
        return DataTables::of($obj1)
            ->addIndexColumn()
            ->editColumn('status', function ($row) {
                $statusLabel = '';
                if ($row->status == 0) {
                    $statusLabel = '<span class="status upload">Uploaded</span>';
                } elseif ($row->status == 1) {
                    $statusLabel = '<span class="status inprogress">In Progress</span>';
                } elseif ($row->status == 2) {
                    $statusLabel = '<span class="status complet">Completed</span>';
                } elseif ($row->status == 3) {
                    $statusLabel = '<span class="status publish">Published</span>';
                } elseif ($row->status == 4) {
                    $statusLabel = '<span class="status faile">Failed</span>';
                } elseif ($row->status == 5) {
                    $statusLabel = '<span class="status draft">Drafted</span>';
                }
                return $statusLabel;
            })->editColumn('date_time', function ($row) {
                return date('M d, Y H:i', strtotime($row->date_time));
                // return convertToDubaiTimezone($row->date_time);
            })->editColumn('reporting_start_date', function ($row) {
                $start_date = date('d/m/Y', strtotime($row->reporting_start_date));
                $end_date = date('d/m/Y', strtotime($row->reporting_end_date));
                return $start_date . ' - ' . $end_date;
            })->editColumn('action', function ($row) {
                $companyUserRole =  UserRole::where('role', 'Company Admin')->where('type', 'Frontend')->first();
                $html = '';
                if (frontMultiplePermissionCheck('frontend-datasheets', ['edit', 'delete', 'show']) > 0) {
                    $html .= '<div class="dropdown sheet-dots"><div class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"  ><picture><img src="' . asset('assets/images/sheet-dots.svg') . '" alt="sheet-dots"></picture></div>';
                    $html .= '<ul class="dropdown-menu edit-sheet" data-id="' . $row->id . '">';
                    if (frontendPermissionCheck('frontend-datasheets.show')) {
                        $html .=  '<li><a href="#!" data-id="' . $row->id . '" data-bs-toggle="modal" data-bs-target="#view-datasheet-modal">View</a></li>';
                    }
                    if (frontendPermissionCheck('frontend-datasheets.edit')) {
                        if ($row->is_draft == 1) {
                            $html .= '<li><a href="#!" data-id="' . $row->id . '" data-bs-toggle="modal" data-bs-target="#edit-datasheet-modal">Edit</a></li>';
                        }
                    }
                    if (frontendPermissionCheck('frontend-datasheets.create')) {
                        if ($row->status == 2) {
                            $html .= '<li><a class="publish-datasheet" data-id =' . $row->id . '>Publish</a></li>';
                        }
                    }
                    $html .= '</ul></div>';
                } else {
                    $html .= '-';
                }
                return $html;
            })->rawColumns(['status', 'action'])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  
        $validator = Validator::make(
            $request->all(),
            [
                'calculated_file_name' => 'required|string',
                'date_time' => 'required',
                'reporting_date' => ['required', new CustomDateRangeValidation],
                // 'data_assessor' => 'required',
                // 'description' => 'required',
                'datasheet_file' => 'required|mimes:xlsx',
            ],
            [
                'calculated_file_name.required' => 'The report title field is required.',
                'date_time.required' => 'The date and time field is required.',
                'reporting_date.required' => 'The reporting date field is required.',
                // 'data_assessor.required' => 'The data assessor field is required.',
                // 'description.required' => 'The description field is required.',
                'datasheet_file.required' => 'Please choose file.',                
            ]
        );
        if ($validator->passes()) {
            $datasheetFileName = null;
            if ($request->hasFile('datasheet_file')) {
                $datasheetFile = $request->file('datasheet_file');
                $folderPath = storage_path('app/public/uploads/datasheets');
                if (!is_dir($folderPath)) {
                    File::makeDirectory($folderPath, 0777, true);
                }
               
                $reportingDateExplode = explode('to', str_replace('/', '-', str_replace(' ', '', $request->reporting_date)));
                $dataSheetName = $request->calculated_file_name.$reportingDateExplode[0].$reportingDateExplode[1].'.xlsx';
                // $datasheetFileName = companyLogoFileUpload('datasheet', $datasheetFile);
                $datasheetFileName = companyDataSheetFileUpload('datasheet', $datasheetFile, $dataSheetName);
            }

            $datasheet = new Datasheet();
            $datasheet->calculated_file_name = $request->input('calculated_file_name');
            $randomSourceId = Datasheet::generateSourceId();
            $datasheet->source_id = $randomSourceId;
            $datasheet->data_assessor = isset($request->data_assessor) ? $request->data_assessor:  '';
            $datasheet->description = isset($request->description) ? $request->description : '';
            $datasheet->date_time = date('Y-m-d H:i:s', strtotime($request->input('date_time')));
            $reporting_date = $request->input('reporting_date');
            $datasheet->last_action_by = Auth::guard('web')->user()->name;
            $datasheet->uploaded_by = Auth::guard('web')->user()->name;
            $datasheet->last_action_by_id = Auth::guard('web')->user()->id;
            $datasheet->uploaded_by_id = Auth::guard('web')->user()->id;
            $datasheet->user_id = Auth::guard('web')->user()->id;
            $dateRangeArray = explode(' to ', $reporting_date);
            $startDate = $dateRangeArray[0];
            $endDate = $dateRangeArray[1];
            $datasheet->reporting_start_date = date('Y-m-d', strtotime($startDate));
            $datasheet->reporting_end_date = date('Y-m-d', strtotime($endDate));
            $datasheet->uploded_sheet = $datasheetFileName;
            if ($request->input('save_as_draft') == '1') {
                $datasheet->is_draft = '1';
                $datasheet->status = DATASHEET::IS_DRAFT; //'5';
            } else {
                $datasheet->is_draft = '0';
                $datasheet->status = DATASHEET::IS_UPLOADED;
            }
            $companyAdminRoleID = UserRole::where('role', 'Company Admin')->first();
            $staffID = UserRole::whereNot('role', 'Company Admin')->where('type', 'Frontend')->pluck('id')->toArray();
            if (Auth::guard('web')->user()->user_role_id == $companyAdminRoleID->id) {
                $companyInfo = Company::select('id')->where('user_id', Auth::guard('web')->user()->id)->first();
                $company_id = $companyInfo->id;
            } else if (in_array(Auth::guard('web')->user()->user_role_id, $staffID)) {
                $staffInfo = StaffCompany::select('company_id')->where('user_id', Auth::guard('web')->user()->id)->first();
                $company_id = $staffInfo->company_id;
            }
            $datasheet->company_id = $company_id;
            if ($datasheet->save()) {
                $datasheetId = $datasheet->id;
                if ($datasheet->status == DATASHEET::IS_UPLOADED) {
                    $jobDS = DatasheetCalculationJob::dispatch($datasheetId);
                }
                if (Auth::guard('web')->user()) {
                    $jsonCompanyhis = 'Added new datasheet "' . $datasheet->calculated_file_name . '"';
                    $moduleid = 3;
                    $userId = Auth::guard('web')->user()->id;
                    $action = "Created";
                    $history = userHistoryManage($jsonCompanyhis, $moduleid, $userId, $action);
                }
                return response()->json(['success' => 'New activity sheet is successfully added.']);
            } else {
                removeFile('datasheet', $datasheetFileName);
                return response()->json(['add_error' => 'An error occurred while adding a new datasheet.']);
            }
        }
        return response()->json(['errors' => $validator->errors()]);
    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        if (!empty($id)) {
            $get_details = Datasheet::where('id', $id)->whereNull('deleted_at')->first();
            if ($get_details instanceof Datasheet && !empty($get_details->uploded_sheet && $get_details->uploded_sheet && $get_details->uploded_sheet != '-')) {
                $uploadedSheetUrl =  asset($get_details->uploded_sheet);
            } else {
                $uploadedSheetUrl = "-";
            }
            if ($get_details->emission_calculated && $get_details->emission_calculated != '-') {
                $emissionCalculatedSheetUrl =  asset($get_details->emission_calculated);
            } else {
                $emissionCalculatedSheetUrl = "-";
            }
            $get_details['uploadedSheetUrl'] = $uploadedSheetUrl;
            $get_details['emissionCalculatedSheetUrl'] = $emissionCalculatedSheetUrl;
            return response()->json(['status' => 'true', 'data' => $get_details]);
        } else {
            return response()->json(['status' => 'false', 'message' => 'Invalid data id.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!empty($id)) {
            $get_details = Datasheet::where('id', $id)->whereNull('deleted_at')->first();
            if ($get_details instanceof Datasheet && !empty($get_details->uploded_sheet && $get_details->uploded_sheet && $get_details->uploded_sheet != '-')) {
                $uploadedSheetUrl =  asset($get_details->uploded_sheet);
            } else {
                $uploadedSheetUrl = "-";
            }
            if ($get_details->emission_calculated && $get_details->emission_calculated != '-') {
                $emissionCalculatedSheetUrl =  asset($get_details->emission_calculated);
            } else {
                $emissionCalculatedSheetUrl = "-";
            }
            $get_details['uploadedSheetUrl'] = $uploadedSheetUrl;
            $get_details['emissionCalculatedSheetUrl'] = $emissionCalculatedSheetUrl;
            return response()->json(['status' => 'true', 'data' => $get_details]);
        } else {
            return response()->json(['status' => 'false', 'message' => 'Invalid data id.']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->datasheet_id;
        $validator = Validator::make(
            $request->all(),
            [
                'calculated_file_name' => 'required|string',
                'description' => 'required',
            ],
            [
                'calculated_file_name.required' => 'The activity sheet name field is required.',
                'description.required' => 'The description field is required.',
            ]
        );
        if ($validator->passes()) {
            $datasheet = Datasheet::findOrFail($id);
            if (empty($datasheet)) {
                return response()->json(['no_data_error' => 'No activity sheet record found that you are trying to update.']);
            }
            $datasheet->calculated_file_name = $request->input('calculated_file_name');
            $datasheet->description = $request->input('description');
            $datasheet->last_action_by = Auth::guard('web')->user()->name;
            $datasheet->last_action_by_id = Auth::guard('web')->user()->id;
            $datasheet->is_draft = '0';
            $datasheet->status = DATASHEET::IS_UPLOADED;
            if ($datasheet->save()) {
                DatasheetCalculationJob::dispatch($id);
                if (Auth::guard('web')->user()) {
                    $jsonCompanyhis = 'Updated activity sheet "' . $datasheet->calculated_file_name . '"';
                    $moduleid = 3;
                    $userId = Auth::guard('web')->user()->id;
                    $action = "Updated";
                    $history = userHistoryManage($jsonCompanyhis, $moduleid, $userId, $action);
                }
                return response()->json(['success' => 'Activity sheet detail is successfully updated.']);
            }
            return response()->json(['updatation_error' => 'An error occurred while updating activity sheet details.']);
        }
        return response()->json(['errors' => $validator->errors()]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function publishDatasheet($id)
    {
        $datasheet = Datasheet::findOrFail($id);
        if (!empty($datasheet)) {
      	
        if(Auth::guard('web')->user()->user_role_id == 6)
        {
        $companyInfo = Company::where('id',$datasheet->company_id)->first();
        
        } else
        {
          $staffCompany = StaffCompany::select('company_id')->where('user_id',Auth::guard('web')->user()->id)->first();
       		 $companyInfo = Company::where('id', $staffCompany->company_id)->first();
        }
        
          
            Datasheet::where('company_id', $companyInfo->id)->whereNot('id',$id)->where('status','3')->update(['status'=> DATASHEET::IS_COMPLETE]);
            $datasheet->status = DATASHEET::IS_PUBLISH;
            if ($datasheet->save()) {
                CompanyPublishSheet::insert([
                    'company_id' => $companyInfo->id,
                    'datasheet_id' => $id,
                    'publisher_id' => Auth::guard('web')->user()->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                $jsonCompanyhis = 'Published "' . $datasheet->calculated_file_name . '"';
                $moduleid = 3;
                $userId = Auth::guard('web')->user()->id;
                $action = "Updated";
                $history = userHistoryManage($jsonCompanyhis, $moduleid, $userId, $action);
                
                return redirect()->route('frontend-datasheets.index')->with('success', 'The datasheet has been successfully published.');
            }
        }
        return redirect()->route('frontend-datasheets.index')->with('error', 'An error occurred while publishing datasheet.');
    }
    public function uplodedSheet($id)
    {
        $datasheet = Datasheet::find($id);

        if (!$datasheet) {
            abort(404);
        }
        $uplodedSheetPath = $datasheet->uploded_sheet;

        if (!$uplodedSheetPath || !Storage::disk('datasheet')->exists($uplodedSheetPath)) {
            abort(404);
        }
        return response()->file(storage_path('app/public/uploads/datasheets/' . $uplodedSheetPath));
    }

    public function readDatasheetFile($id) 
    {    
        try {
            if (!empty($id)) {                
                $datasheet = Datasheet::where('datasheets.id', $id)->first();
                if(isset($datasheet)){
                    $datasheet->status = DATASHEET::IS_INPROGRESS; //'1';
                    $datasheet->save();
                    $fileUrl = $datasheet->uploded_sheet;
                    $excelFile = '';
                    $lastSlashPos = strrpos($fileUrl, '/');
                    if ($lastSlashPos !== false) {
                        $result = substr($fileUrl, $lastSlashPos + 1);
                        $excelFile = $result;
                    }
                    //set permission to folder
                    $folderPath = storage_path('app/public/uploads/datasheets'); 
                    $permissions = 0777;
                    if (is_dir($folderPath)) {
                        File::chmod($folderPath, $permissions);   
                    }
                    $excelFile = (\Illuminate\Support\Facades\Storage::disk('datasheet')->path('') . $excelFile);
                    $spreadsheet = IOFactory::load($excelFile);
                    $sheetNames = $spreadsheet->getSheetNames();
                    $allowedDataSheetArray = Config::get('constants.allowedDataSheetArray');
                    $resultData = []; 
                    $homeOfficeSum = 0.00;
                    $freightingGoodsFirstSum = 0.00;
                    $freightingGoodsSecondSum = 0.00;
                    $freightingGoodsAllSum = 0.00;
                    $flightAndAccommodationFlightSum = 0.00;
                    $flightAndAccommodationHotelSum = 0.00;
                    $deliveryVehicleSum = 0.00;
                    $pessengerVehicleSum = 0.00;
                    $electricityEvsSum = 0.00;
                    $electricitySum = 0.00;
                    $districtHeatSteamSum = 0.00;
                    $districtCoolingSum = 0.00;
                    $waterSupplyValue = 0.00;
                    $waterTreatmentValue = 0.00;
                    $traspotationBySeaSum = 0.00;
                    $traspotationByLandSum = 0.00;
                    $sumArray = [];
                    $typeSet = '';
                    if(isset($sheetNames)){
                        foreach ($sheetNames as $sheetName) {
                            if(in_array($sheetName,$allowedDataSheetArray)){
                                $worksheet = $spreadsheet->getSheetByName($sheetName);
                                $data = $worksheet->toArray();   
                                if(isset($data)){                     
                                    foreach ($data as $key => $item) {
                                        $emission_rules = Config::get('constants.scopeRules');  
                                        $rule = (isset($emission_rules[generateSlug($sheetName)]) ? $emission_rules[generateSlug($sheetName)] : []);                               
                                        if($sheetName == "Freighting goods"){  
                                            if($key != 0){
                                                $item = self::getFactorDataFirstTable($item, 0, 4, 5, "FreightingGoodsVansHgvs", $rule[0]);
                                                $item = self::getFactorDataSecondTable($item, 12 ,12, "FreightingGoodsFlightsRails", $rule[1]);
                                                // $freightingGoodsVansHgvsData = [];
                                                // if(!empty($item[5])){
                                                //     $freightingGoodsVansHgvsDataSet =  FreightingGoodsVansHgvs::select('factors as factor')
                                                //         ->where('id', $item[5])
                                                //         ->first();
                                                //     if ($freightingGoodsVansHgvsDataSet) {
                                                //         $freightingGoodsVansHgvsData = $freightingGoodsVansHgvsDataSet->toArray();
                                                //     } else {
                                                //         $freightingGoodsVansHgvsData = [];
                                                //     }
                                                // }                        
                                                // $firstItemFirst = "-";
                                                // if(!empty($freightingGoodsVansHgvsData['factor'])){
                                                //     $firstItemFirst = $freightingGoodsVansHgvsData['factor'];
                                                // }
                                                // $expressionRuleFirst = $rule[0];
                                                // list($beforeFirst, $afterFirst) = explode('*', $expressionRuleFirst);
                                                // $lastItemFirst = $item[$afterFirst];
                                                // if(empty($item['0'])){
                                                //     $item['4'] = '';
                                                // }else{
                                                //     $item['4'] = '-';
                                                // }
                                                // if (!empty($firstItemFirst) && !empty($lastItemFirst)) {
                                                //     if ($firstItemFirst != '-' && $lastItemFirst != '-') {
                                                //         $firstItemFirst = str_replace(",", "", $firstItemFirst);
                                                //         if (is_numeric($firstItemFirst) && is_numeric($lastItemFirst)) {                                    
                                                //             $item['4'] = $lastItemFirst * $firstItemFirst;
                                                //         }
                                                //     }
                                                // }   
                                                // $freightingGoodsFlightsRailsData = [];
                                                // if(!empty($item[12])){
                                                //     $freightingGoodsFlightsRailsDataSet =  FreightingGoodsFlightsRails::select('factors as factor')
                                                //         ->where('id', $item[12])
                                                //         ->first();
                                                //     if ($freightingGoodsFlightsRailsDataSet) {
                                                //         $freightingGoodsFlightsRailsData = $freightingGoodsFlightsRailsDataSet->toArray();
                                                //     } else {
                                                //         $freightingGoodsFlightsRailsData = [];
                                                //     }
                                                // }                        
                                                // $firstItemSec = "-";
                                                // if(!empty($freightingGoodsFlightsRailsData['factor'])){
                                                //     $firstItemSec = $freightingGoodsFlightsRailsData['factor'];
                                                // }                                                             
                                                // $expressionRuleSec = $rule[1];
                                                // list($beforeSec, $afterSec) = explode('*', $expressionRuleSec);
                                                // $lastItemSec = $item[$afterSec];
                                                // if ($firstItemSec != "") {
                                                //     $item['12'] = '-';
                                                // }else{
                                                //     $item['12'] = '';
                                                // }
                                                // if (!empty($firstItemSec) && !empty($lastItemSec)) {
                                                //     if ($firstItemSec != '-' && $lastItemSec != '-') {
                                                //         $firstItemSec = str_replace(",", "", $firstItemSec);
                                                //         if (is_numeric($firstItemSec) && is_numeric($lastItemSec)) {                                    
                                                //             $item['12'] = $lastItemSec * $firstItemSec;
                                                //         }
                                                //     }
                                                // }else{
                                                //     $item['12'] = '-';
                                                // }
                                                
                                            }else{
                                                $item['4'] = 'kg CO2e';
                                                $item['12'] = 'kg CO2e';
                                            }
                                            $data[$key] = $item;                                
                                            if(is_numeric($data[$key][4])){   
                                                $freightingGoodsFirstSum = $freightingGoodsFirstSum + $data[$key][4];
                                            }
                                            if(is_numeric($data[$key][12])){   
                                                $freightingGoodsSecondSum = $freightingGoodsSecondSum + $data[$key][12];
                                            }
                                            $freightingGoodsAllSum = $freightingGoodsFirstSum + $freightingGoodsSecondSum;
                                            $sumArray['freightingGoodsAllSum'] = $freightingGoodsAllSum;

                                        }else if($sheetName == "Owned vehicles"){                                            
                                            if($key != 0){
                                                $item = self::getFactorDataFirstTable($item, 0, 4, 5, "Vehicle", $rule[0]);
                                                $item = self::getFactorDataSecondTable($item, 11 ,12, "Vehicle", $rule[1]);
                                                // $vehicleData = [];
                                                // if(!empty($item[5])){
                                                //     $vehicleDataSet =  Vehicle::select('factors as factor')
                                                //         ->where('id', $item[5])
                                                //         ->first();                                                        
                                                //     if ($vehicleDataSet) {
                                                //         $vehicleData = $vehicleDataSet->toArray();
                                                //     } else {
                                                //         $vehicleData = [];
                                                //     }
                                                // }                        
                                                // $firstItemFirst = "-";
                                                // if(!empty($vehicleData['factor'])){
                                                //     $firstItemFirst = $vehicleData['factor'];
                                                // }
                                                
                                                // $expressionRuleFirst = $rule[0];
                                                // list($beforeFirst, $afterFirst) = explode('*', $expressionRuleFirst);
                                                // $lastItemFirst = $item[$afterFirst];
                                                // if(empty($item['0'])){
                                                //     $item['4'] = '';
                                                // }else{
                                                //     $item['4'] = '-';
                                                // }
                                                // if (!empty($firstItemFirst) && !empty($lastItemFirst)) {
                                                //     if ($firstItemFirst != '-' && $lastItemFirst != '-') {
                                                //         $firstItemFirst = str_replace(",", "", $firstItemFirst);
                                                //         if (is_numeric($firstItemFirst) && is_numeric($lastItemFirst)) {                                    
                                                //             $item['4'] = $lastItemFirst * $firstItemFirst;
                                                //         }
                                                //     }
                                                // }
                                                // $vehicleDataSec = [];
                                                // if(!empty($item[12])){
                                                //     $vehicleDataSecSet =  Vehicle::select('factors as factor')
                                                //         ->where('id', $item[12])
                                                //         ->first();
                                                //     if ($vehicleDataSecSet) {
                                                //         $vehicleDataSec = $vehicleDataSecSet->toArray();
                                                //     } else {
                                                //         $vehicleDataSec = [];
                                                //     }
                                                // }                        
                                                // $firstItemSec = "-";
                                                // if(!empty($vehicleDataSec['factor'])){
                                                //     $firstItemSec = $vehicleDataSec['factor'];
                                                // }                                                                
                                                // $expressionRuleSec = $rule[1];
                                                // list($beforeSec, $afterSec) = explode('*', $expressionRuleSec);
                                                // $lastItemSec = $item[$afterSec];
                                                // if ($firstItemSec != "") {
                                                //     $item['11'] = '-';
                                                // }else{
                                                //     $item['11'] = '';
                                                // }
                                                // if (!empty($firstItemSec) && !empty($lastItemSec)) {
                                                //     if ($firstItemSec != '-' && $lastItemSec != '-') {
                                                //         $firstItemSec = str_replace(",", "", $firstItemSec);
                                                //         if (is_numeric($firstItemSec) && is_numeric($lastItemSec)) {                                    
                                                //             $item['11'] = $lastItemSec * $firstItemSec;
                                                //         }
                                                //     }
                                                // }else{
                                                //     $item['11'] = '-';
                                                // }
                                                
                                            }else{
                                                $item['4'] = 'kg CO2e';
                                                $item['11'] = 'kg CO2e';
                                            }
                                            $data[$key] = $item;
                                            
                                            if(is_numeric($data[$key][4])){   
                                                if($data[$key][2] != "Battery Electric" || $data[$key][2] != "Plug-in Hybrid Electric"){
                                                    $pessengerVehicleSum = $pessengerVehicleSum + $data[$key][4];
                                                }
                                                if($data[$key][2] == "Battery Electric" || $data[$key][2] == "Plug-in Hybrid Electric"){
                                                    $electricityEvsSum = $electricityEvsSum + $data[$key][4];
                                                }
                                            }
                                            if(is_numeric($data[$key][11])){   
                                                $deliveryVehicleSum = $deliveryVehicleSum + $data[$key][11];
                                            }
                                            $sumArray['pessengerVehicleSum'] = $pessengerVehicleSum;
                                            $sumArray['electricityEvsSum'] = $electricityEvsSum;
                                            $sumArray['deliveryVehicleSum'] = $deliveryVehicleSum;

                                        }else if($sheetName == "Home Office"){
                                            $typeHomeOffice = Config::get('constants.typeWiseConsumptionHomeOffice');
                                            $factorsHomeOffice = Config::get('constants.countryWiseFactorsHomeOffice');
                                                
                                            $homeOfficeType = $item[1];
                                            $homeOfficeCountry = $item[2];
                                            $consumptionValue = '';
                                            $factorsValue ='';
                                            $kgCo2eValue ='';
                                            
                                            if(isset($homeOfficeType)){
                                                if($homeOfficeType == "Withcooling"){
                                                    $consumptionValue = (isset($typeHomeOffice['with_cooling'])) ? $typeHomeOffice['with_cooling'] : '-';
                                                }else if($homeOfficeType == "Withheating"){
                                                    $consumptionValue = (isset($typeHomeOffice['with_heating'])) ? $typeHomeOffice['with_heating'] : '-';
                                                }else if($homeOfficeType == "NoheatingNocooling"){
                                                    $consumptionValue = (isset($typeHomeOffice['no_heating_no_cooling'])) ? $typeHomeOffice['no_heating_no_cooling'] : '-';
                                                }else{
                                                    $consumptionValue = "-";    
                                                }
                                            }else{
                                                $kgCo2eValue ='-';
                                                $consumptionValue = "-";
                                            }
                
                                            if(isset($homeOfficeCountry)){
                                                $getCountryWiseFactors = Country::select('home_factor')->where('name', $homeOfficeCountry)->first();
                                                $factorsValue = (isset($getCountryWiseFactors['home_factor'])) ? $getCountryWiseFactors['home_factor'] : '-';
                                                // $factorsValue = (isset($factorsHomeOffice[$item[1]])) ? $factorsHomeOffice[$item[1]] : '-';
                                            }else{
                                                $kgCo2eValue ='-';
                                                $factorsValue = "-";
                                            }
                                            
                                            $item[0] = $item[0];
                                            $item[1] = $item[1];
                                            $item[2] = $item[2];
                                            $item[3] = $item[3];
                                            $item[8] = $item[6];
                                            $item[9] = $item[7];
                                            $item[6] = $item[4];
                                            $item[7] = $item[5];
                                            
                                            $itemThree = 0.00;
                                            $itemFour = 0.00;
                                            if($key == 1){
                                                $item[4] = "Consumption kWh/hour";
                                                $item[5] = "Factors";
                                            }else{
                                                $item[4] = ($consumptionValue != "-") ? number_format($consumptionValue, 2, '.', '') : $consumptionValue;
                                                $item[5] = ($factorsValue != "-") ? number_format($factorsValue, 2, '.', '') : $factorsValue;
                                                $itemThree = $consumptionValue;
                                                $itemFour = $factorsValue;
                                            }
                                            if($consumptionValue != "-" && $factorsValue != "-" && isset($item[5]) && isset($item[6]) && isset($item[7]) && isset($item[8]) && isset($itemThree) && isset($itemFour)){
                                                if(is_numeric($consumptionValue) && is_numeric($factorsValue) && is_numeric($item[5]) && is_numeric($item[6]) && is_numeric($item[7]) && is_numeric($item[8]) && is_numeric($item[4]) && is_numeric($item[5]) && is_numeric($itemThree) && is_numeric($itemFour)){
                                                    $kgCo2eValue = $item[6] * ($item[7] * 160) * $item[8] * $itemThree * $itemFour * $item[9];
                                                    $kgCo2eValue = ($kgCo2eValue != 0) ? number_format($kgCo2eValue, 2, '.', '') : '-';
                                                }else{
                                                    $kgCo2eValue = '-';
                                                }                                    
                                            }else{
                                                $kgCo2eValue = '-';
                                            } 
                                            if($key == 1){
                                                $item[10] = 'kg CO2e';
                                            }else{
                                                $item[10] = $kgCo2eValue;
                                            }
                                            $data[$key] = $item;
                                            
                                            if(is_numeric($data[$key][10])){   
                                                $homeOfficeSum = $homeOfficeSum + $data[$key][10];
                                            }
                                            $sumArray['homeOfficeSum'] = $homeOfficeSum;
                
                                        }else if($sheetName == "Flight and Accommodation"){                                
                                            if($key == 1){
                                                $item[6] = 'kg CO2e';
                                                // $item[10] = 'Factors';
                                                $item[10] = 'kg CO2e';
                                            }else{
                                                $item[6] = '-';                                    
                                                // $item[10] = '-';
                                                $item[10] = '-';                                   
                                            }   
                                            if($key > 1){
                                                $tripType = "";
                                                if(!empty($item[3]))
                                                {
                                                    $tripType = Config::get('constants.tripType');  
                                                    $tripType = (isset($tripType[$item[3]]) ? $tripType[$item[3]] : []); 
                                                }
                                                $distanceClassWiseFactors = "";
                                                
                                                if(!empty($item[5]) && !empty($item[2]))
                                                {   
                                                    if((int)$item[5] > 0 && (int)$item[5] <= 3700)
                                                    {
                                                        $shortHaultCons = Config::get('constants.distanceCategory.shortHaul.'.$item[2]);
                                                        if(!isset($shortHaultCons)){
                                                            $longHaulCons = Config::get('constants.distanceCategory.longHaul.'.$item[2]);
                                                            $distanceClassWiseFactors = (isset($longHaulCons)) ? $longHaulCons : '' ;
                                                        }else{
                                                            $distanceClassWiseFactors = $shortHaultCons;
                                                        }
                                                        // $distanceClassWiseFactors = (isset($shortHaultCons)) ? $shortHaultCons : '' ;
                                                    }else if((int)$item[5] > 3700){
                                                        $longHaulCons = Config::get('constants.distanceCategory.longHaul.'.$item[2]);
                                                        $distanceClassWiseFactors = (isset($longHaulCons)) ? $longHaulCons : '' ;
                                                    }
                                                }
                                                $calculatedKgCO2e = '-';
                                                if(!empty($item[4]) && !empty($item[5]) && !empty($tripType) && !empty($distanceClassWiseFactors)){
                                                    if(is_numeric($item[4]) && is_numeric($item[5])){
                                                        $calculatedKgCO2e = (int)$item[4] * ( (int)$item[5] * $tripType ) * $distanceClassWiseFactors;                                        
                                                    }
                                                }
                                                $item[6] = $calculatedKgCO2e;    
                                                // hotel calculation    
                                                $hotelKgCO2e = '-';
                                                $hotelFactorsValue = '-';
                                               
                                                if(!empty($item[7])){
                                                    if($item[7] == "Other"){
                                                        $hotelFactorsValue = Config::get('constants.otherCountryHotelFactors');
                                                    }else{
                                                        $getCountryWiseFactors = Country::select('hotel_factor')->where('name', $item[7])->whereNotNull('hotel_factor')->first();
                                                        $hotelFactorsValue = (isset($getCountryWiseFactors['hotel_factor'])) ? $getCountryWiseFactors['hotel_factor'] : '-';                                        
                                                    }
                                                }
                                                if(!empty($item[7]) && !empty($item[8]) && !empty($item[9]) && $hotelFactorsValue != "-"){
                                                    if(is_numeric($item[8]) && is_numeric($item[9]) && is_numeric($hotelFactorsValue)){
                                                        $hotelKgCO2e = $hotelFactorsValue * (int)$item[9] * (int)$item[8];
                                                    }
                                                }
                                                // $item[10] = $hotelFactorsValue;
                                                $item[10] = $hotelKgCO2e;
                                            }
                                            $data[$key] = $item;  
                                            if(is_numeric($data[$key][6])){   
                                                $flightAndAccommodationFlightSum = $flightAndAccommodationFlightSum + $data[$key][6];
                                            }
                                            if(is_numeric($data[$key][10])){   
                                                $flightAndAccommodationHotelSum = $flightAndAccommodationHotelSum + $data[$key][10];
                                            }
                                            $sumArray['flightAndAccommodationFlightSum'] = $flightAndAccommodationFlightSum;  
                                            $sumArray['flightAndAccommodationHotelSum'] = $flightAndAccommodationHotelSum;  
                                        }else{                                            
                                            $firstItem = "-";
                                            $firstItem = self::getDataSheetWise($sheetName,$item[6]); 
                                            $expressionRule = $rule[0];
                                            list($before, $after) = explode('*', $expressionRule);
                                            $lastItem = $item[$after];   
                                            $calCol = '-';
                                                 
                                            if (!empty($firstItem) && !empty($lastItem)) {
                                                if ($firstItem != '-' && $lastItem != '-') {
                                                    $firstItem = str_replace(",", "", $firstItem);
                                                    if (is_numeric($firstItem) && is_numeric($lastItem)) {                                    
                                                        $calCol = $lastItem * $firstItem;
                                                    }
                                                }
                                            }                           
                                            if ($key == 0) {
                                                $data[$key][] = 'kg CO2e';
                                            } else {
                                                $firstItem = str_replace(",", "", $firstItem);
                                                if (is_numeric($firstItem) && is_numeric($lastItem)) {
                                                    $valueIf = $calCol;
                                                }else{
                                                    if (!empty($firstItem) && !empty($lastItem)) {
                                                        if($firstItem != "-" && $lastItem != '-'){  
                                                            $valueIf = 'kg CO2e';
                                                        }
                                                    }  
                                                    //add for dash in blank array 
                                                    if (!is_numeric($lastItem) || !isset($firstItem) || ($firstItem == '-') || ($firstItem == '') || !isset($lastItem) || ($lastItem == '-') || ($lastItem == '') || !isset($calCol)) {
                                                        $valueIf = '-';
                                                    }                             
                                                }
                                                $data[$key][] = $valueIf;
                                            }
                                            
                                            if($sheetName == "Electricity, heat, cooling"){  
                                                $electricityType = Config::get('constants.electricityType');                                                
                                                if (isset($data[$key][0]) && !empty($data[$key][0]))
                                                {
                                                    if (in_array($data[$key][0], $electricityType))
                                                    {
                                                        $typeSet = $data[$key][0];
                                                    }
                                                }                             
                                                if(is_numeric($data[$key][7])){
                                                    // if($data[$key][0]=='Electricity'){
                                                    if($typeSet == $electricityType[0]){
                                                        $electricitySum += $data[$key][7];
                                                    }
                                                    // if($data[$key][0]=='District heat and steam'){
                                                    if($typeSet == $electricityType[1]){
                                                        $districtHeatSteamSum += $data[$key][7];
                                                    }
                                                    // if($data[$key][0]=='District cooling') {
                                                    if($typeSet == $electricityType[2]){
                                                        $districtCoolingSum += $data[$key][7];
                                                    }
                                                }
                                                $sumArray['electricitySum'] = $electricitySum;
                                                $sumArray['districtHeatSteamSum'] = $districtHeatSteamSum;
                                                $sumArray['districtCoolingSum'] = $districtCoolingSum;
                                            }else if($sheetName == "Water"){
                                                if(is_numeric($data[$key][7])){    
                                                    if($data[$key][0]=='Water Supply'){
                                                        $waterSupplyValue += $data[$key][7];
                                                    }
                                                    if($data[$key][0]=='Water Treatment'){
                                                        $waterTreatmentValue += $data[$key][7];
                                                    }
                                                }
                                                $sumArray['waterSupplyValue'] = $waterSupplyValue;
                                                $sumArray['waterTreatmentValue'] = $waterTreatmentValue;
                                            }else if($sheetName == "Business travel - land and sea"){
                                                if(is_numeric($data[$key][7])){    
                                                    if($data[$key][0] == 'Ferry'){
                                                        $traspotationBySeaSum = $traspotationBySeaSum + $data[$key][7];
                                                    } 
                                                }
                                                if(is_numeric($data[$key][7])){    
                                                    if($data[$key][0] != 'Ferry'){
                                                        $traspotationByLandSum = $traspotationByLandSum + $data[$key][7];
                                                    } 
                                                }
                                                $sumArray['traspotationBySeaSum'] = $traspotationBySeaSum;
                                                $sumArray['traspotationByLandSum'] = $traspotationByLandSum;
                                            }else{
                                                if(is_numeric($data[$key][7])){
                                                    self::setSumSheetWise($sheetName, $data[$key][7], $sumArray);
                                                }
                                            }
                                        }                      
                                    }
                                }else{
                                    // Log::info('Worksheet data is not set.'); 
                                }     
                            }
                            $resultData['Report'] = $sumArray;
                            $resultData[$sheetName] = $data;
                        }     
                        // dd($resultData['Flight and Accommodation']);
                        // dd($resultData['Owned vehicles']);//['Employees commuting']
                        $calculatedFileName = $this->generateCalculatedSheet($resultData);
                        if(!empty($calculatedFileName)){
                            $datasheet->emission_calculated = $calculatedFileName;
                            $datasheet->status = DATASHEET::IS_COMPLETE; //'2';
                        }else{
                            $datasheet->status = DATASHEET::IS_FAILED; //'4';
                        }            
                        $datasheet->save();
                        $statusName = $this->getStatusName($datasheet->status);
                        $user = User::select('id', 'name', 'email')->with('company')->where('id',$datasheet->uploaded_by_id)->first();
                        $data = [
                            'datasheet_name' =>$datasheet->calculated_file_name,
                            'source_id'=>$datasheet->source_id,
                            'status' => $statusName,
                            'name' => $user->name,
                            'company_logo' => $user->company->company_logo
                        ];
                    // sendEmail($user->email, $data, Config::get('constants.emailSubject.datasheetCalProcessComplete'), Config::get('constants.emailPageUrl.datasheetProcessComplete'),[], "", ""); 
                    }else{
                        // Log::info('Datasheet id is '.$datasheetId.', Datasheet array is not set.');
                    }                        
                }else{
                    // Log::info('Datasheet id is '.$datasheetId.', No datasheet found.');
                }  
            }
        }catch(\Exception $e){
            
        }
    }
    
    public function getFactorDataFirstTable($item, $firstIndex, $updateIndex ,$index, $model, $expressionRule) 
    {
        $factorData = [];
        if (!empty($item[$index])) {
            $model = app("App\\Models\\$model");
            $dataset = $model::select('factors as factor')
            ->where('id', $item[$index])
            ->first();
            
            if ($dataset && !empty($dataset->factor)) {
                $factorData = $dataset->toArray();
            }
        }        
        // $firstItem = !empty($factorData['factor']) ? $factorData['factor'] : '-';
        $firstItem = !empty($factorData['factor']) 
        ? ($factorData['factor'] != 0 ? $factorData['factor'] : '-')
        : '-';
        $lastItem = explode('*', $expressionRule)[1];
        $lastItem = $item[$lastItem];
        if(empty($item[$firstIndex])){
            $item[$updateIndex] = '';
        }else{
            $item[$updateIndex] = '-';
        }        
        if (!empty($firstItem) && !empty($lastItem)) {
            if ($firstItem != '-' && $lastItem != '-') {
                $firstItem = str_replace(",", "", $firstItem);
                if (is_numeric($firstItem) && is_numeric($lastItem)) {                                    
                    $item[$updateIndex] = $lastItem * $firstItem;
                }
            }
        }  
        return $item;      
    }

    public function getFactorDataSecondTable($item, $updateIndex ,$index, $model, $expressionRule) 
    {        
        if (!empty($item[$index])) {
            $model = app("App\\Models\\$model");
            $dataset = $model::select('factors as factor')
                ->where('id', $item[$index])
                ->first();    
            if ($dataset && !empty($dataset->factor)) {
                $factorData = $dataset->toArray();
            }
        }    
        // $firstItem = !empty($factorData['factor']) ? $factorData['factor'] : '-';
        $firstItem = !empty($factorData['factor']) 
        ? ($factorData['factor'] != 0 ? $factorData['factor'] : '-')
        : '-';
        $lastItem = explode('*', $expressionRule)[1];
        $lastItem = $item[$lastItem];
        if ($firstItem != "") {
            $item[$updateIndex] = '-';
        }else{
            $item[$updateIndex] = '';
        } 
        if (!empty($firstItem) && !empty($lastItem)) {
            if ($firstItem != '-' && $lastItem != '-') {
                $firstItem = str_replace(",", "", $firstItem);
                if (is_numeric($firstItem) && is_numeric($lastItem)) {                                    
                    $item[$updateIndex] = $lastItem * $firstItem;
                }
            }
        }else{
            $item[$updateIndex] = '-';
        }   
        return $item;
    }

    public function setSumSheetWise($sheetName, $columnId, &$sumArray)
    {
        $sheetNameList = ['Fuels', 'Refrigerants', 'WTT-fules', 'T&D', 'Material use', 'Employees commuting', 'Food', 'Waste disposal'];
        if (in_array($sheetName, $sheetNameList))
        {
            $sumVariables = [
                "Fuels" => "fuelsSum",
                "Refrigerants" => "refrigerantsSum",
                "WTT-fules" => "wttFulesSum",
                "T&D" => "tAndDSum",
                "Material use" => "materialUseSum",
                "Employees commuting" => "employeesCommutingSum",
                "Food" => "foodSum",
                "Waste disposal" => "wasteDisposelSum",
            ];
            
            if (isset($sumVariables[$sheetName]) && is_numeric($columnId)) {
                if (!isset($sumArray[$sumVariables[$sheetName]])) {
                    $sumArray[$sumVariables[$sheetName]] = 0.00;
                }
                $sumArray[$sumVariables[$sheetName]] += $columnId;
            }
        }
    }

    public function getDataSheetWise($sheetName, $columnId){      
        if($sheetName == "Fuels"){
            $modelName = "Fuels";
            $model = app("App\\Models\\$modelName");
            $select = "factor";
        }else if($sheetName == "Refrigerants"){
            $modelName = "Refrigerant";
            $model = app("App\\Models\\$modelName");
            $select = "factors as factor";
        }else if($sheetName == "Electricity, heat, cooling"){
            $modelName = "Electricity";
            $model = app("App\\Models\\$modelName");
            $select = "factors as factor";
        }else if($sheetName == "WTT-fules"){
            $modelName = "WttFules";
            $model = app("App\\Models\\$modelName");
            $select = "factors as factor";
            
        }else if($sheetName == "T&D"){
            $modelName = "TransmissionAndDistribution";
            $model = app("App\\Models\\$modelName");
            $select = "factors as factor";
        }else if($sheetName == "Water"){
            $modelName = "Watersupplytreatment";
            $model = app("App\\Models\\$modelName");
            $select = "factors as factor";
        }else if($sheetName == "Material use"){
            $modelName = "MaterialUse";
            $model = app("App\\Models\\$modelName");
            $select = "factors as factor";
        }else if($sheetName == "Waste disposal"){
            $modelName = "WasteDisposal";
            $model = app("App\\Models\\$modelName");
            $select = "factors as factor";
        }else if($sheetName == "Business travel - land and sea"){
            $modelName = "BusinessTravels";
            $model = app("App\\Models\\$modelName");
            $select = "factors as factor";
        }else if($sheetName == "Employees commuting"){
            $modelName = "EmployeesCommuting";
            $model = app("App\\Models\\$modelName");
            $select = "factors as factor";
        }else if($sheetName == "Food"){
            $modelName = "FoodCosumption";
            $model = app("App\\Models\\$modelName");
            $select = "factors as factor";
        }
        if(!empty($sheetName) && !empty($columnId) && !empty($modelName)){
            $factorData = [];
            if(!empty($columnId)){
                $factorDataSet =  $model::select($select)->where('id', $columnId)->first();
                if ($factorDataSet) {
                    $factorData = $factorDataSet->toArray();
                } else {
                    $factorData = [];
                }
            }
        }
        $firstItem = "-";
        if(!empty($factorData['factor'])){
            $firstItem = $factorData['factor'];
        }
        return $firstItem;        
    }
    
    public static function getStatusName($statusId) {
        if($statusId == '0'){
            return "Uploded";
        }else if($statusId == '1'){
            return "In Progress";
        }else if($statusId == '2'){
            return "Completed";
        }else if($statusId == '3'){
            return "Published";
        }else if($statusId == '4'){
            return "Failed";
        }else if($statusId == '5'){
            return "Drafted";
        }
    }

    public function generateCalculatedSheet($data) {
        if (!empty($data)) {
            $spreadsheet = new Spreadsheet();
            $spreadsheet->removeSheetByIndex(0);
            foreach ($data as $sheetName => $sheetData) {                
                $worksheet = $spreadsheet->createSheet();
                $worksheet->setTitle($sheetName);
                $worksheet->getProtection()->setPassword('password');
                $worksheet->getProtection()->setSheet(true);
                self::setDataArrayForSheet($sheetName, $sheetData, $worksheet);
            }    
            $filename = 'emission-calculated-'.uniqid() . '.xlsx';
            $spreadsheet->setActiveSheetIndex(0);
            $writer = new Xlsx($spreadsheet);
            $folderPath = storage_path('app/public/uploads/calculated_datasheet'); 
            if (!is_dir($folderPath)) {
                \File::makeDirectory($folderPath, 0777, true);
            }else{
                $permissions = 0777;
                File::chmod($folderPath, $permissions);   
            }
            $writer->save(\Illuminate\Support\Facades\Storage::disk('calculated_datasheet')->path('') . $filename);
            echo $filename;exit;
            return $filename;
        }else{
            // Log::info('Data is not set while generating datasheet.');
        }
    }

    public function setDataArrayForSheet($sheetName, $worksheet, $sheet)
    {
        $data = [];
        switch ($sheetName) {
            case 'Fuels':
                $sheet->fromArray(self::setDataForFuelsSheet($sheetName, $worksheet, $sheet), null, 'A2');
                break;
            case 'Refrigerants':
                $sheet->fromArray(self::setDataForRefrigerantsSheet($sheetName, $worksheet, $sheet), null, 'A2');
                break;
            case 'Food':
                $sheet->fromArray(self::setDataForFoodSheet($sheetName, $worksheet, $sheet), null, 'A2');
                break;
            case 'WTT-fules':
                $sheet->fromArray(self::setDataForWTTFulesSheet($sheetName, $worksheet, $sheet), null, 'A2');
                break;
            case 'T&D':
                $sheet->fromArray(self::setDataForTandDSheet($sheetName, $worksheet, $sheet), null, 'A2');
                break;
            case 'Material use':
                $sheet->fromArray(self::setDataForMaterialUseSheet($sheetName, $worksheet, $sheet), null, 'A2');
                break;
            case 'Waste disposal':
                $sheet->fromArray(self::setDataForWasteDisposelSheet($sheetName, $worksheet, $sheet), null, 'A2');
                break;
            case 'Business travel - land and sea':
                $sheet->fromArray(self::setDataForBusinessTravelSheet($sheetName, $worksheet, $sheet), null, 'A2');
                break;
            case 'Employees commuting':
                $sheet->fromArray(self::setDataForEmployeesCommutingSheet($sheetName, $worksheet, $sheet), null, 'A2');
                break;
            case 'Water':
                $sheet->fromArray(self::setDataForWaterSheet($sheetName, $worksheet, $sheet), null, 'A2');
                break;
            case 'Electricity, heat, cooling':
                $sheet->fromArray(self::setDataForElectricityHeatCoolingUseSheet($sheetName, $worksheet, $sheet), null, 'A2');
                break;
            case 'Freighting goods':
                $sheet->fromArray(self::setDataForFreightingGoodsSheet($sheetName, $worksheet, $sheet), null, 'A3');
                break;
            case 'Owned vehicles':
                $sheet->fromArray(self::setDataForOwnedVehiclesSheet($sheetName, $worksheet, $sheet), null, 'A3');
                break;
            case 'Home Office':
                $sheet->fromArray(self::setDataForHomeOfficeUseSheet($sheetName, $worksheet, $sheet), null, 'A2');
                break;
            case 'Flight and Accommodation':
                $sheet->fromArray(self::setDataForFlightAndAccommodationUseSheet($sheetName, $worksheet, $sheet), null, 'A2');
                break;
            case 'Report':
                $sheet->fromArray(self::setDataForReportSheet($sheetName, $worksheet, $sheet), null, 'A2');
                break;
        }
        return $sheet;
    }

    public function setDataForFuelsSheet($sheetName, $worksheet, $sheet)
    {
        $titleCollumn = ['Type', 'Fuel', 'Unit', 'Amount', 'kg CO2e'];
        $fuelArray = [$titleCollumn];
        self::setTitleDesign($sheet, 'Fuels', $titleCollumn);
        $sheet = self::titleCollumnDesign($sheet, $titleCollumn);
        $fuelData = $worksheet;
        $i = 1;
        $collmnIndex = 2;
        if (count($fuelData) > 0) {
            foreach ($fuelData as $value) {
                self::subCollumnDesignset($sheet, $titleCollumn, $collmnIndex);
                if ($i > 2) {
                    $fuelObject = [
                        $value[0],
                        $value[1],
                        $value[2],
                        $value[3],
                        isset($value[7]) ? $value[7] : '',
                    ];
                    $fuelArray[] = $fuelObject;
                    $collmnIndex++;
                }
                $i++;
            }
        }
        return $fuelArray;
    }

    public function setDataForRefrigerantsSheet($sheetName, $worksheet, $sheet)
    {        
        // $titleCollumn = ['Type', 'Emission', 'Unit', 'Amount (kg)', 'kg CO2e'];
        $titleCollumn = ['Emission', 'Unit', 'Amount (kg)', 'kg CO2e'];
        $refrigerantArray = [$titleCollumn];
        self::setTitleDesign($sheet, 'Refrigerant and others', $titleCollumn);
        $sheet = self::titleCollumnDesign($sheet, $titleCollumn);

        $refrigerantData = $worksheet;
        $i = 1;
        $collmnIndex = 2;
        foreach ($refrigerantData as $value) {
            self::subCollumnDesignset($sheet, $titleCollumn, $collmnIndex);
            if ($i > 2) {
                $refrigerantObject = [
                    // $value[0],
                    $value[0],
                    $value[1],
                    $value[2],
                    // $value[3],
                    isset($value[7]) ? $value[7] : '',
                ];
                array_push($refrigerantArray, $refrigerantObject);
                $collmnIndex++;
            }
            $i++;
        }
        return $refrigerantArray;
    }

    public function setDataForFoodSheet($sheetName, $worksheet, $sheet)
    {
        $foodCosumptionData = $worksheet;
        $titleCollumn = ['Vehicle', 'Unit', 'Amount', 'kg CO2e'];
        $foodCosumptionArray = [$titleCollumn];
        self::setTitleDesign($sheet, 'Food consumption', $titleCollumn);
        $sheet = self::titleCollumnDesign($sheet, $titleCollumn);
        $collmnIndex = 2;
        $i = 1;
        foreach ($foodCosumptionData as $value) {
            self::subCollumnDesignset($sheet, $titleCollumn, $collmnIndex);
            if ($i > 2) {
                $foodCosumptionObject = [
                    $value[0],
                    $value[1],
                    $value[2],
                    isset($value[7]) ? $value[7] : '',
                ];
                $foodCosumptionArray[] = $foodCosumptionObject;
                $collmnIndex++;
            }
            $i++;
        }
        return $foodCosumptionArray;
    }

    public function setDataForWTTFulesSheet($sheetName, $worksheet, $sheet)
    {
        $wttFulesData = $worksheet;
        $titleCollumn = ['Type', 'Fuel', 'Unit', 'Amount', 'kg CO2e'];
        self::setTitleDesign($sheet, 'Well to tank (WTT) - fuels', $titleCollumn);
        $wttFulesArray = [$titleCollumn];
        $sheet = self::titleCollumnDesign($sheet, $titleCollumn);
        $i = 1;
        $collmnIndex = 2;
        foreach ($wttFulesData as $value) {
            self::subCollumnDesignset($sheet, $titleCollumn, $collmnIndex);
            if ($i > 2) {
                $wttFulesObject = [
                    $value[0],
                    $value[1],
                    $value[2],
                    $value[3],
                    isset($value[7]) ? $value[7] : '',
                ];
                array_push($wttFulesArray, $wttFulesObject);
                $collmnIndex++;
            }
            $i++;
        }
        return $wttFulesArray;
    }

    public function setDataForTandDSheet($sheetName, $worksheet, $sheet)
    {
        $transmissionAndDistributionData = $worksheet;
        $titleCollumn = ['Activity', 'Unit', 'Amount', 'kg CO2e'];
        self::setTitleDesign($sheet, 'Transmission and distribution', $titleCollumn);
        $transmissionAndDistributionArray = [$titleCollumn];
        $sheet = self::titleCollumnDesign($sheet, $titleCollumn);
        $i = 1;
        $collmnIndex = 2;
        foreach ($transmissionAndDistributionData as $key => $value) {
            self::subCollumnDesignset($sheet, $titleCollumn, $collmnIndex);
            if ($i > 2) {
                $transmissionAndDistributionObject = [
                    $value[0],
                    $value[1],
                    $value[2],
                    isset($value[7]) ? $value[7] : '',
                ];
                array_push($transmissionAndDistributionArray, $transmissionAndDistributionObject);
                $collmnIndex++;
            }
            $i++;
        }
        return $transmissionAndDistributionArray;
    }

    public function setDataForMaterialUseSheet($sheetName, $worksheet, $sheet)
    {
        $materialUseData = $worksheet;
        $titleCollumn = ['Activity', 'Waste type', 'Amount (tonnes)', 'kg CO2e'];
        self::setTitleDesign($sheet, 'Material use', $titleCollumn);
        $materialUseArray = [$titleCollumn];
        $sheet = self::titleCollumnDesign($sheet, $titleCollumn);
        $collmnIndex = 2;
        $i = 1;
        foreach ($materialUseData as $value) {
            self::subCollumnDesignset($sheet, $titleCollumn, $collmnIndex);
            if ($i > 2) {
                $materialUseObject = [
                    $value[0],
                    $value[1],
                    $value[2],
                    isset($value[7]) ? $value[7] : '',
                ];
                array_push($materialUseArray, $materialUseObject);
                $collmnIndex++;
            }
            $i++;
        }
        return $materialUseArray;
    }

    public function setDataForWasteDisposelSheet($sheetName, $worksheet, $sheet)
    {
        // $titleCollumn = ['Waste type', 'Type', 'Amount (tonnes)', 'kg CO2e'];
        $titleCollumn = ['Waste type', 'Amount (tonnes)', 'kg CO2e'];
        $wasteDisposalArray = [$titleCollumn];
        self::setTitleDesign($sheet, 'Waste disposal', $titleCollumn);
        $sheet = self::titleCollumnDesign($sheet, $titleCollumn);
        $wasteDisposalData = $worksheet;
        $collmnIndex = 2;
        $i = 1;
        foreach ($wasteDisposalData as $value) {
            self::subCollumnDesignset($sheet, $titleCollumn, $collmnIndex);
            if ($i > 2) {
                $wasteDisposalObject = [
                    // $value[0],
                    $value[0],
                    $value[1],
                    // $value[2],
                    isset($value[7]) ? $value[7] : '',
                ];
                array_push($wasteDisposalArray, $wasteDisposalObject);
                $collmnIndex++;
            }
            $i++;
        }
        return $wasteDisposalArray;
    }

    public function setDataForBusinessTravelSheet($sheetName, $worksheet, $sheet)
    {
        $titleCollumn = ["Vehicle", "Type", "Fuel", "Unit", "Total distance", "kg CO2e"];
        $businessTravelArray = [$titleCollumn];
        self::setTitleDesign($sheet, 'Business travel: land and sea', $titleCollumn);
        $sheet = self::titleCollumnDesign($sheet, $titleCollumn);
        $businessTravelData = $worksheet;
        $collmnIndex = 2;
        $i = 1;
        foreach ($businessTravelData as $value) {
            self::subCollumnDesignset($sheet, $titleCollumn, $collmnIndex);
            if ($i > 2) {
                $businessTravelObject = [
                    $value[0],
                    $value[1],
                    $value[2],
                    $value[3],
                    $value[4],
                    isset($value[7]) ? $value[7] : '',
                ];
                array_push($businessTravelArray, $businessTravelObject);
                $collmnIndex++;
            }
            $i++;
        }
        return $businessTravelArray;
    }

    public function setDataForEmployeesCommutingSheet($sheetName, $worksheet, $sheet)
    {
        $titleCollumn = ["Vehicle", "Type", "Fuel", "Unit", "Total distance", "kg CO2e"];
        $employeesCommutingArray = [$titleCollumn];
        self::setTitleDesign($sheet, 'Employees commuting', $titleCollumn);
        $sheet = self::titleCollumnDesign($sheet, $titleCollumn);
        $employeesCommutingData = $worksheet;
        $collmnIndex = 2;
        $i = 1;
        foreach ($employeesCommutingData as $value) {
            self::subCollumnDesignset($sheet, $titleCollumn, $collmnIndex);
            if ($i > 2) {
                $employeesCommutingObject = [
                    $value[0],
                    $value[1],
                    $value[2],
                    $value[3],
                    $value[4],
                    isset($value[7]) ? $value[7] : '',
                ];
                array_push($employeesCommutingArray, $employeesCommutingObject);
                $collmnIndex++;
            }
            $i++;
        }
        return $employeesCommutingArray;
    }

    public function setDataForWaterSheet($sheetName, $worksheet, $sheet)
    {
        $watersupplytreatmentData = $worksheet;
        $titleColumn = ['Type', 'Unit', 'Amount', 'kg CO2e'];
        $waterSupplyArray = [];
        $waterTretmentArray = [];
        $watersupplytreatmentArray = [];
        $currentRowIndex = 3;
        $collmnIndex = 3;
        self::setTitleDesign($sheet, 'Water', $titleColumn, 'A1', '1');
        foreach ($watersupplytreatmentData as $value) {
            if (isset($value[0]) && !empty($value[0]) && $value[0] == 'Water Supply') {
                $waterSupplyArray[] = $value;
            } else if (isset($value[0]) && !empty($value[0]) && $value[0] == 'Water Treatment') {
                $waterTretmentArray[] = $value;
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

            $watersupplytreatmentArray[] = ['', '', '', ''];
            $sheet = self::waterTitleCollumnDesign($sheet, $titleColumn, $currentRowIndex);
            $watersupplytreatmentArray[] = $titleColumn;
            foreach ($waterSupplyArray as $key => $value) {
                $watersupplytreatmentObject = [
                    $value[0],
                    $value[1],
                    $value[2],
                    isset($value[7]) ? $value[7] : '',
                ];
                $watersupplytreatmentArray[] = $watersupplytreatmentObject;
                $sheet = self::subCollumnDesignset($sheet, $titleColumn, $collmnIndex);
                $collmnIndex++;
            }
            $watersupplytreatmentArray[] = ['', '', '', ''];
        }

        if (count($waterTretmentArray) > 0) {
            $userEmissionTotal = count($watersupplytreatmentArray) + 2;
            $watersupplytreatmentArray[] = ['', '', '', ''];
            $sheet->setCellValue('A' . $userEmissionTotal, 'Water treatment');

            $totalNumberofCollumn = count($titleColumn) - 1;
            $sheet->mergeCells('A' . $userEmissionTotal . ':' . Config::get('constants.collumn')[$totalNumberofCollumn] . $userEmissionTotal);
            $sheet->getStyle('A' . $userEmissionTotal)->getFont()->setSize(12)->setBold(true);
            $sheet->getStyle('A' . $userEmissionTotal)->getFont()->getColor()->setARGB('ff1f4e78');

            $sheet = self::waterTitleCollumnDesign($sheet, $titleColumn, $userEmissionTotal + 1);
            $watersupplytreatmentArray[] = $titleColumn;
            foreach ($waterTretmentArray as $key => $value) {
                $watersupplytreatmentObject = [
                    $value[0],
                    $value[1],
                    $value[2],
                    isset($value[7]) ? $value[7] : '',
                ];
                $watersupplytreatmentArray[] = $watersupplytreatmentObject;
                $sheet = self::subCollumnDesignset($sheet, $titleColumn, $userEmissionTotal + 1);
                $userEmissionTotal++;
            }
        }
        return $watersupplytreatmentArray;
    }

    public function setDataForElectricityHeatCoolingUseSheet($sheetName, $worksheet, $sheet)
    {
        $UserEmissionelectricityData =  $worksheet;
        $typeOneArray = [];
        $typeTwoArray = [];
        $typeThreeArray = [];
        $UserEmissionelectricityArray = [];
        $titleOneAndThreeObject = [
            'Activity',
            'Country',
            'Unit',
            'Amount',
            'kg CO2e'
        ];
        $titleTwoObject = [
            'Activity',
            'Type',
            'Unit',
            'Amount',
            'kg CO2e'
        ];
        self::setTitleDesign($sheet, 'Electricity and heating', $titleOneAndThreeObject, 'A1', '1');
        $electricityType = Config::get('constants.electricityType');
        $typeSet = '';
        foreach ($UserEmissionelectricityData as $key => $value) 
        {
            if (isset($value[0]) && !empty($value[0]))
            {
                if (in_array($value[0], $electricityType))
                {
                    $typeSet = $value[0];
                }
            }
            if($typeSet == $electricityType[0]){
                if (isset($value[0]) && !empty($value[0]) && !empty($value[1]))
                {
                    $typeOneArray[] = $value;
                }
            }else if($typeSet == $electricityType[1]){
                if (isset($value[0]) && !empty($value[0]) && !empty($value[1]))
                {
                    $typeTwoArray[] = $value;
                }
            }else if($typeSet == $electricityType[2]){
                if (isset($value[0]) && !empty($value[0]) && !empty($value[1]))
                {
                    $typeThreeArray[] = $value;
                }
            }            
            // if (isset($value[0]) && !empty($value[0]) && !empty($value[1]) && $value[0] == 'Electricity') {
            //     $typeOneArray[] = $value;
            // } else if (isset($value[0]) && !empty($value[0]) && !empty($value[1]) && $value[0] == 'District heat and steam') {
            //     $typeTwoArray[] = $value;
            // } else if (isset($value[0]) && !empty($value[0]) && !empty($value[1]) && $value[0] == 'District cooling') {
            //     $typeThreeArray[] = $value;
            // }
        }
        $currentRowIndex = 3;
        $collmnIndex = 3;
        if (count($typeOneArray) > 0) {
            $sheet->setCellValue('A2', 'Electricity Grid');
            $totalNumberofCollumn = count($titleOneAndThreeObject) - 1;
            $sheet->mergeCells('A2:' . Config::get('constants.collumn')[$totalNumberofCollumn] . '2');
            $sheet->getStyle('A2')->getFont()->setSize(12)->setBold(true);
            $sheet->getStyle('A2')->getFont()->getColor()->setARGB('ff1f4e78');

            $UserEmissionelectricityArray[] = ['', '', '', '', '', ''];
            $sheet = self::electricityTitleCollumnDesign($sheet, $titleOneAndThreeObject, $currentRowIndex);
            $UserEmissionelectricityArray[] = $titleOneAndThreeObject;

            foreach ($typeOneArray as $key => $value) {
                if($key > 0){
                    $dataObject = [
                        $value[0],
                        $value[1],
                        $value[2],
                        isset($value[3]) ? $value[3] : '',
                        isset($value[7]) ? $value[7] : '',
                    ];
                    $UserEmissionelectricityArray[] = $dataObject;
                    $sheet = self::electricitySubCollumnDesignset($sheet, $titleOneAndThreeObject, $collmnIndex);
                    $collmnIndex++;
                }
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

            $sheet = self::electricityTitleCollumnDesign($sheet, $titleTwoObject, $userEmissionTotal + 1);
            $UserEmissionelectricityArray[] = $titleTwoObject;

            foreach ($typeTwoArray as $key => $value) {
                if($key > 0){
                    $dataObject = [
                        $value[0],
                        $value[1],
                        $value[2],
                        isset($value[3]) ? $value[3] : '',
                        isset($value[7]) ? $value[7] : '',
                    ];
                    $UserEmissionelectricityArray[] = $dataObject;
                    $sheet = self::electricitySubCollumnDesignset($sheet, $titleTwoObject, $userEmissionTotal + 1);
                    $userEmissionTotal++;
                }
            }
            $UserEmissionelectricityArray[] = ['', '', '', '', ''];
        }

        if (count($typeThreeArray) > 0) {
            $userEmissionTotal = count($UserEmissionelectricityArray) + 2;
            $UserEmissionelectricityArray[] = ['', '', '', '', ''];
            $sheet->setCellValue('A' . $userEmissionTotal, 'District cooling');

            $totalNumberofCollumn = count($titleOneAndThreeObject) - 1;
            $sheet->mergeCells('A' . $userEmissionTotal . ':' . Config::get('constants.collumn')[$totalNumberofCollumn] . $userEmissionTotal);
            $sheet->getStyle('A' . $userEmissionTotal)->getFont()->setSize(12)->setBold(true);
            $sheet->getStyle('A' . $userEmissionTotal)->getFont()->getColor()->setARGB('ff1f4e78');
            $sheet = self::electricityTitleCollumnDesign($sheet, $titleOneAndThreeObject, $userEmissionTotal + 1);
            $UserEmissionelectricityArray[] = $titleOneAndThreeObject;

            foreach ($typeThreeArray as $key => $value) {
                if($key > 0){
                    $dataObject = [
                        $value[0],
                        $value[1],
                        $value[2],
                        isset($value[3]) ? $value[3] : '',
                        isset($value[7]) ? $value[7] : '',
                    ];
                    $UserEmissionelectricityArray[] = $dataObject;
                    $sheet = self::electricitySubCollumnDesignset($sheet, $titleOneAndThreeObject, $userEmissionTotal + 1);
                    $userEmissionTotal++;
                }
            }
        }

        return $UserEmissionelectricityArray;
    }

    public function setDataForOwnedVehiclesSheet($sheetName, $worksheet, $sheet)
    {
        $titleCollumn = ['Vehicle', 'Type', 'Fuel', 'Distance (km)', 'kg CO2e', '', 'Vehicle', 'Type', 'Fuel', 'Distance (km)', 'kg CO2e'];

        $vehicleArray = [$titleCollumn];
        self::setTitleDesign($sheet, 'Own or controlled vehicles', $titleCollumn, 'A1', '1');
        self::freightingGoodsSubTitleCollumnDesign($sheet, 'Passenger vehicles', 'A2', 'F2');
        self::freightingGoodsSubTitleCollumnDesign($sheet, 'Delivery vehicles', 'G2', 'K2');
        $sheet = freightingGoodsTitleCollumnDesign($sheet, $titleCollumn);
        $vehicleData = $worksheet;
        $passangerVehicleArray = [];
        $deliveryVehicleArray = [];
        $i = 1;

        foreach ($vehicleData as $value) {
            if ($i > 3) {
                if (isset($value[0]) && !empty($value[0])) {
                    array_push($passangerVehicleArray, $value);
                    if (!empty($value[7])) {
                        array_push($deliveryVehicleArray, $value);
                    }
                } else if (isset($value[7]) && !empty($value[7])) {
                    array_push($deliveryVehicleArray, $value);
                }
            }
            $i++;
        }

        $maxValue = max(count($passangerVehicleArray), count($deliveryVehicleArray));
        $collmnIndex = 3;

        for ($i = 0; $i < $maxValue; $i++) {
            $passengerVehicle = $passangerVehicleArray[$i] ?? null;
            $deliveryVehicle = $deliveryVehicleArray[$i] ?? null;
            self::ownVehicleSubCollumnDesignset($sheet, $titleCollumn, $collmnIndex, $passengerVehicle, $deliveryVehicle);

            $vehicleObject = [
                isset($passengerVehicle[0]) ? $passengerVehicle[0] : '',
                isset($passengerVehicle[1]) ? $passengerVehicle[1] : '',
                isset($passengerVehicle[2]) ? $passengerVehicle[2] : '',
                isset($passengerVehicle[3]) ? $passengerVehicle[3] : '',
                isset($passengerVehicle[4]) ? $passengerVehicle[4] : '',
                '',
                isset($deliveryVehicle[7]) ? $deliveryVehicle[7] : '',
                isset($deliveryVehicle[8]) ? $deliveryVehicle[8] : '',
                isset($deliveryVehicle[9]) ? $deliveryVehicle[9] : '',
                isset($deliveryVehicle[10]) ? $deliveryVehicle[10] : '',
                isset($deliveryVehicle[11]) ? $deliveryVehicle[11] : '',
            ];

            array_push($vehicleArray, $vehicleObject);
            $collmnIndex++;
        }
        return $vehicleArray;
    }

    public function setDataForFreightingGoodsSheet($sheetName, $worksheet, $sheet)
    {
        $titleCollumn = ['Vehicle', 'Type', 'Fuel', 'Distance (km)', 'kg CO2e', '', 'Vehicle', 'Type', 'Unit',  'Tonne.km', 'kg CO2e'];
        $sheet = self::freightingGoodsTitleCollumnDesign($sheet, $titleCollumn);
        $freightingGoodsVansHgvsArray = [$titleCollumn];
        //title design set
        self::setTitleDesign($sheet, 'Freighting goods', $titleCollumn, 'A1', '1');
        self::freightingGoodsSubTitleCollumnDesign($sheet, 'Freighting goods -> vans and HGVs:', 'A2', 'F2');
        self::freightingGoodsSubTitleCollumnDesign($sheet, 'Freighting goods -> flights, rail, sea tanker and cargo ship:', 'G2', 'K2');
        $i = 1;
        foreach ($worksheet as $value) {
            if ($i > 3) {
                if (isset($value[0]) && !empty($value[0])) {
                    $freightingGoodsVansHgvsData[] = $value;
                    if (!empty($value[7])) {
                        $freightingGoodsFlightData[] = $value;
                    }
                } else if (isset($value[7]) && !empty($value[7])) {
                    $freightingGoodsFlightData[] = $value;
                }
            }
            $i++;
        }
        $maxValue = max(count($freightingGoodsVansHgvsData), count($freightingGoodsFlightData));
        $collmnIndex = 3;
        for ($i = 0; $i < $maxValue; $i++) {
            self::freightingGoodsSubCollumnDesignset($sheet, $titleCollumn, $collmnIndex, count($freightingGoodsVansHgvsData),  count($freightingGoodsFlightData),  $i);
            $freightingGoodsVansHgvsObject = [
                isset($freightingGoodsVansHgvsData[$i][0]) ? $freightingGoodsVansHgvsData[$i][0] : '',
                isset($freightingGoodsVansHgvsData[$i][1]) ? $freightingGoodsVansHgvsData[$i][1] : '',
                isset($freightingGoodsVansHgvsData[$i][2]) ? $freightingGoodsVansHgvsData[$i][2] : '',
                isset($freightingGoodsVansHgvsData[$i][3]) ? $freightingGoodsVansHgvsData[$i][3] : '',
                isset($freightingGoodsVansHgvsData[$i][4]) ? $freightingGoodsVansHgvsData[$i][4] : '',
                '',
                isset($freightingGoodsFlightData[$i][7]) ? $freightingGoodsFlightData[$i][7] : '',
                isset($freightingGoodsFlightData[$i][8]) ? $freightingGoodsFlightData[$i][8] : '',
                isset($freightingGoodsFlightData[$i][9]) ? $freightingGoodsFlightData[$i][9] : '',
                isset($freightingGoodsFlightData[$i][10]) ? $freightingGoodsFlightData[$i][10] : '',
                isset($freightingGoodsFlightData[$i][12]) ? $freightingGoodsFlightData[$i][12] : '',
            ];
            array_push($freightingGoodsVansHgvsArray, $freightingGoodsVansHgvsObject);
            $collmnIndex++;
        }
        return $freightingGoodsVansHgvsArray;
    }

    public function freightingGoodsTitleCollumnDesign($sheet, $titleCollumn)
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

    public function freightingGoodsSubTitleCollumnDesign($sheet, $title, $cellOne, $cellTwo)
    {
        $sheet->setCellValue($cellOne, $title);
        $sheet->mergeCells($cellOne . ':' . $cellTwo);
        $sheet->getStyle($cellOne)->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle($cellOne)->getFont()->getColor()->setARGB('ff1f4e78');
        return $sheet;
    }

    public function freightingGoodsSubCollumnDesignset($sheet, $titleCollumn, $collmnIndex, $freightingGoodsVansHgvsData, $freightingGoodsFlightData, $currentIndex)
    {
        for ($i = 0; $i < count($titleCollumn); $i++) {
            if (($i <= 2 &&  $freightingGoodsVansHgvsData - 1 >= $currentIndex || $i == 4 &&  $freightingGoodsVansHgvsData - 1 >= $currentIndex &&  !strstr($titleCollumn[$i], 'Distance (km)'))  || ($i > 5 &&  $freightingGoodsFlightData - 1 >= $currentIndex  &&  !strstr($titleCollumn[$i], 'Tonne.km'))) {
                self::collumnDesignSet($i, $collmnIndex, $sheet);
            }

            if ($freightingGoodsVansHgvsData - 1 >= $currentIndex && strstr($titleCollumn[$i], 'Distance (km)') || $freightingGoodsFlightData - 1 >= $currentIndex && strstr($titleCollumn[$i], 'Tonne.km')) {
                self::boderColumnDesignSet($i, $collmnIndex, $sheet);
            }

            if ($freightingGoodsVansHgvsData - 1 >= $currentIndex && strstr($titleCollumn[$i], 'kg CO2e') || $freightingGoodsFlightData - 1 >= $currentIndex && strstr($titleCollumn[$i], 'kg CO2e')) {
                self::collumnNumberFormatSet($i, $collmnIndex, $sheet);
            }
        }
        return $sheet;
    }

    public function ownVehicleSubCollumnDesignset($sheet, $titleCollumn, $collmnIndex, $passengerVehicle, $deliveryVehicle)
    {
        for ($i = 0; $i < count($titleCollumn); $i++) {
            if (!strstr($titleCollumn[$i], 'Distance (km)') || !strstr($titleCollumn[$i], '')) {
                if (
                    ($i <= 4 && isset($passengerVehicle)) ||
                    ($i > 5 && isset($deliveryVehicle))
                ) {
                    self::collumnDesignSet($i, $collmnIndex, $sheet);
                }
            } else {
                if ($i == 3 && isset($passengerVehicle)) {
                    self::boderColumnDesignSet($i, $collmnIndex, $sheet);
                }
                if ($i == 9 && isset($deliveryVehicle)) {
                    self::boderColumnDesignSet($i, $collmnIndex, $sheet);
                }
            }
            if(strstr($titleCollumn[$i], 'kg CO2e')){
                if ($i == 4 && isset($passengerVehicle)) {
                    self::collumnNumberFormatSet($i, $collmnIndex, $sheet);
                }
                if ($i == 10 && isset($deliveryVehicle)) {
                    self::collumnNumberFormatSet($i, $collmnIndex, $sheet);
                } 
            }
        }
        return $sheet;
    }

    public function waterTitleCollumnDesign($sheet, $titleCollumn, $collmnIndex)
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

    public function electricityTitleCollumnDesign($sheet, $titleCollumn, $collmnIndex)
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

    public function electricitySubCollumnDesignset($sheet, $titleCollumn, $collmnIndex)
    {
        for ($i = 0; $i < count($titleCollumn); $i++) {
            self::boderColumnDesignSet($i, $collmnIndex, $sheet);
            if (!strstr($titleCollumn[$i], 'Amount') || !strstr($titleCollumn[$i], '')) {
                self::collumnDesignSet($i, $collmnIndex, $sheet);
            }
        }

        return $sheet;
    }

    public function setTitleDesign($sheet, $title, $titleCollumn)
    {
        $sheet->setCellValue('A1', $title);
        $totalNumberofCollumn = count($titleCollumn) - 1;
        $sheet->mergeCells('A1:' . Config::get('constants.collumn')[$totalNumberofCollumn] . '1');
        $sheet->getStyle('A1')->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle('A1')->getFont()->getColor()->setARGB(Config::get('constants.titleFontColor'));
        return $sheet;
    }

    public function titleCollumnDesign($sheet, $titleCollumn)
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

    public function subCollumnDesignset($sheet, $titleCollumn, $collmnIndex)
    {
        for ($i = 0; $i < count($titleCollumn); $i++) {
            self::boderColumnDesignSet($i, $collmnIndex, $sheet);
            if (!strstr($titleCollumn[$i], 'Amount') && !strstr($titleCollumn[$i], 'Total distance')) {
                self::collumnDesignSet($i, $collmnIndex, $sheet);
            }
            if(strstr($titleCollumn[$i], 'kg CO2e')){
                self::collumnNumberFormatSet($i, $collmnIndex, $sheet);
            }
        }
        return $sheet;
    }

    public function collumnNumberFormatSet($index, $collmnIndex, $sheet)
    {
        $cellCoordinate = Config::get('constants.collumn')[$index] . $collmnIndex + 1;
        $sheet->getStyle($cellCoordinate)->getNumberFormat()->setFormatCode('#,##0.00');
    }

    public function boderColumnDesignSet($index, $collmnIndex, $sheet)
    {
        $cellCoordinate = Config::get('constants.collumn')[$index] . $collmnIndex + 1;
        $sheet->getStyle($cellCoordinate)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        return $sheet;
    }

    public function collumnDesignSet($index, $collmnIndex, $sheet)
    {
        $cellCoordinate = Config::get('constants.collumn')[$index] . $collmnIndex + 1;
        $sheet->getStyle($cellCoordinate)->getFont()->setSize(Config::get('constants.valueFontSize'));
        $sheet->getStyle($cellCoordinate)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB(Config::get('constants.valueCollumnColor'));
        $sheet->getStyle($cellCoordinate)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    }

    function setDataForHomeOfficeUseSheet($sheetName, $worksheet, $sheet)
    {
        $titleCollumn = ['Type', 'Type of home office', 'Country', 'Unit', 'Consumption kWh/hour', 'Factors', 'Number of employees', 'Working time(For full-time: 100%)', '% working from home (e.g. 50% from home)', 'Number of months', 'kg CO2e'];
        $homeOfficeArray = [$titleCollumn];
        self::setTitleDesign($sheet, 'Home Office', $titleCollumn, 'A1', '1');
        $sheet = self::titleCollumnDesign($sheet, $titleCollumn);
        $b = 3;
        $c = 2;
        $i = 1;
        if (count($worksheet) > 0) {
            foreach ($worksheet as $value) {
                if ($i > 2) {
                    $homeOfficeObject = [
                        isset($value[0]) ? $value[0] : '',
                        isset($value[1]) ? $value[1] : '',
                        isset($value[2]) ? $value[2] : '',
                        isset($value[3]) ? $value[3] : '',
                        isset($value[4]) ? $value[4] : '',
                        isset($value[5]) ? $value[5] : '',
                        isset($value[6]) ? $value[6] : '',
                        isset($value[7]) ? $value[7] : '',
                        isset($value[8]) ? $value[8] : '',
                        isset($value[9]) ? $value[9] : '',
                        isset($value[10]) ? $value[10] : '',
                    ];
                    self::homeOfficeSubColumnDesignset($sheet, $titleCollumn, $c);
                    $b++;
                    $c++;
                    $homeOfficeArray[] = $homeOfficeObject;
                }
                $i++;
            }
        }
        return $homeOfficeArray;
    }

    public function homeOfficeSubColumnDesignset($sheet, $titleColumn, $collmnIndex)
    {
        for ($i = 0; $i < count($titleColumn); $i++) {
            self::boderColumnDesignSet($i, $collmnIndex, $sheet);
            if (strstr($titleColumn[$i], 'Unit') || strstr($titleColumn[$i], 'kg CO2e') || strstr($titleColumn[$i], 'Factors') || strstr($titleColumn[$i], 'Consumption kWh/hour')) {
                self::collumnDesignSet($i, $collmnIndex, $sheet);
            }
            if (strstr($titleColumn[$i], 'kg CO2e') || strstr($titleColumn[$i], 'Factors') || strstr($titleColumn[$i], 'Consumption kWh/hour')) {
                self::collumnNumberFormatSet($i, $collmnIndex, $sheet);
            }
        }
        return $sheet;
    }

    public function flightAndAccommodationSubColumnDesignset($sheet, $titleColumn, $collmnIndex)
    {
        for ($i = 0; $i < count($titleColumn); $i++) {            
            if (strstr($titleColumn[$i], 'kg CO2e') || strstr($titleColumn[$i], 'Factors')) {
                self::collumnDesignSet($i, $collmnIndex, $sheet);
                self::collumnNumberFormatSet($i, $collmnIndex, $sheet);
            }
            if($titleColumn[$i] != '' &&  ($i <= 6 && $collmnIndex <= 97) ||
            ($i > 7 && $collmnIndex <= 97))
            {
                self::boderColumnDesignSet($i, $collmnIndex, $sheet);
            } 
        }
        return $sheet;
    }

    public function setDataForFlightAndAccommodationUseSheet($sheetName, $worksheet, $sheet)
    {
        $titleCollumn = ['Origin (city or IATA code)', 'Destination (city or IATA code)', 'Class', 'Single way/ return', 'Number of passengers', 'Distance (km)', 'kg CO2e', '', 'Country', 'Number of occupied rooms', 'Number of nights per room', 'Factors', 'kg CO2e'];
        $flightHotelArray = [$titleCollumn];
        // self::setTitleDesign($sheet, 'Flight and Accommodation', $titleCollumn, 'A1', '1');
        self::freightingGoodsSubTitleCollumnDesign($sheet, 'Flights', 'A1', 'G1');
        self::freightingGoodsSubTitleCollumnDesign($sheet, 'Hotel', 'I1', 'M1');
        $sheet = self::titleCollumnDesign($sheet, $titleCollumn);
        $b = 3;
        $c = 2;
        $i = 1;
        if (count($worksheet) > 0) {
            foreach ($worksheet as $value) {
                if ($i > 1) {
                    $homeOfficeObject = [
                        isset($value[0]) ? $value[0] : '',
                        isset($value[1]) ? $value[1] : '',
                        isset($value[2]) ? $value[2] : '',
                        isset($value[3]) ? $value[3] : '',
                        isset($value[4]) ? $value[4] : '',
                        isset($value[5]) ? $value[5] : '',
                        isset($value[6]) ? $value[6] : '',    
                        '',
                        isset($value[7]) ? $value[7] : '',    
                        isset($value[8]) ? $value[8] : '',    
                        isset($value[9]) ? $value[9] : '',    
                        isset($value[10]) ? $value[10] : '',    
                        isset($value[11]) ? $value[11] : '',    
                    ];
                    self::flightAndAccommodationSubColumnDesignset($sheet, $titleCollumn, $c);
                    $b++;
                    $c++;
                    $homeOfficeArray[] = $homeOfficeObject;
                }
                $i++;
            }
        }
        return $homeOfficeArray;
    }

    public function setDataForReportSheet($sheetName, $worksheet, $sheet)
    {
        $companyData = Company::where('user_id', 2)->with('companyactivities.activity:id,name', 'companyactivities.activitydata:id,name')->first();
        $companySelectedActivity =   \Illuminate\Support\Arr::pluck($companyData->companyactivities->toArray(), 'activitydata.name');
        $titleCollumn = ['', '', '','',''];
        $fuelArray = [$titleCollumn];
        self::setTitleDesignReport($sheet, 'GHG emissions report', $titleCollumn);
        self::reportSubTitleCollumnDesign($sheet, 'Category', 'A2', 'B2');
        self::reportSubTitleCollumnDesign($sheet, 'Emission source category', 'C2', 'D2');
        self::reportSubTitleColumnWidth($sheet, 'C', '15');
        self::reportSubTitleColumnWidth($sheet, 'D', '15');
        self::reportSubTitleCollumnDesign($sheet, 't CO2e', 'E2', 'E2');
        self::reportMergeColumn($sheet, 'A3', 'A24', 'GHG Protocol Standards: Corporate Scope - 1 and 2, Value Chain - Scope 3');
        self::reportMergeSecondColumn($sheet, 'B3', 'B6', 'Scope 1', '4', '25');
        self::reportMergeSecondColumn($sheet, 'B7', 'B10', 'Scope 2', '3', '25');
        self::reportMergeSecondColumn($sheet, 'B11', 'B24', 'Scope 3', '14', '25');
        self::reportMergeThirdColumn($sheet, 'C3', 'C4', 'Direct emissions arising from owned or controlled stationary sources that use fossil fuels and/or emit fugitive emissions', '3', '20');
        self::reportSubTitleColumnWidth($sheet, 'C', '45');
        self::reportMergeThirdColumn($sheet, 'C5', 'C6', 'Direct emissions from owned or controlled mobile sources', '5', '20');
        self::reportMergeThirdColumn($sheet, 'C7', 'C10', 'Location-based emissions from the generation of purchased electricity, heat, steam or cooling', '7', '20');
        self::reportMergeThirdColumn($sheet, 'C11', 'C12', 'Fuel- and energy-related activities', '11', '20');
        self::reportMergeThirdColumn($sheet, 'C13', 'C14', 'Waste generated in operations', '13', '20');
        self::reportMergeThirdColumn($sheet, 'C15', 'C16', 'Purchased goods', '15', '20');
        self::reportMergeThirdColumn($sheet, 'C17', 'C20', 'Business travel', '17', '20');
        self::reportMergeThirdColumn($sheet, 'C21', 'C21', 'Upstream transportation and distribution', '21', '20');

        self::reportMergeThirdColumn($sheet, 'C22', 'D22', 'Employees commuting', '22', '20', in_array('Employees commuting', $companySelectedActivity));
        self::reportMergeThirdColumn($sheet, 'C23', 'D23', 'Food', '23', '20', in_array('Food', $companySelectedActivity));
        self::reportMergeThirdColumn($sheet, 'C24', 'D24', 'Home office', '24', '20', in_array('Home Office', $companySelectedActivity));   

        self::reportForthColumn($sheet, 'D3', 'Fuels','3', 'HORIZONTAL_LEFT', false, in_array('Fuels', $companySelectedActivity));
        self::reportForthColumn($sheet, 'D4', 'Refrigerants','4', 'HORIZONTAL_LEFT', false, in_array('Refrigerants', $companySelectedActivity));
        self::reportForthColumn($sheet, 'D5', 'Passenger vehicles','5', 'HORIZONTAL_LEFT', false, in_array('Owned vehicles', $companySelectedActivity));
        self::reportForthColumn($sheet, 'D6', 'Delivery vehicles','6', 'HORIZONTAL_LEFT', false, in_array('Owned vehicles', $companySelectedActivity));
        self::reportForthColumn($sheet, 'D7', 'Electricity','7', 'HORIZONTAL_LEFT', false,in_array('Electricity, heat, cooling', $companySelectedActivity));
        self::reportForthColumn($sheet, 'D8', 'Heat and steam','8', 'HORIZONTAL_LEFT', false, in_array('Electricity, heat, cooling', $companySelectedActivity));
        self::reportForthColumn($sheet, 'D9', 'Electricity for Evs','9', 'HORIZONTAL_LEFT', false, in_array('Owned vehicles', $companySelectedActivity));
        self::reportForthColumn($sheet, 'D10', 'District cooling','10', 'HORIZONTAL_LEFT', false, in_array('Electricity, heat, cooling', $companySelectedActivity));
        self::reportForthColumn($sheet, 'D11', 'All other fuel- and energy related activities','11', 'HORIZONTAL_LEFT', false, in_array('WTT-fules', $companySelectedActivity));
        self::reportForthColumn($sheet, 'D12', 'Transmission and distribution losses','12', 'HORIZONTAL_LEFT', false, in_array('T&D', $companySelectedActivity));
        self::reportForthColumn($sheet, 'D13', 'Waste water','13', 'HORIZONTAL_LEFT', false, in_array('Water', $companySelectedActivity));
        self::reportForthColumn($sheet, 'D14', 'Waste','14', 'HORIZONTAL_LEFT', false, in_array('Waste disposal', $companySelectedActivity));
        self::reportForthColumn($sheet, 'D15', 'Water supplied','15', 'HORIZONTAL_LEFT', false, in_array('Water', $companySelectedActivity));
        self::reportForthColumn($sheet, 'D16', 'Material use','16', 'HORIZONTAL_LEFT', false,in_array('Material use', $companySelectedActivity));
        self::reportForthColumn($sheet, 'D17', 'All transportation by air','17', 'HORIZONTAL_LEFT', false, in_array('Flight and Accommodation', $companySelectedActivity));
        self::reportForthColumn($sheet, 'D18', 'Emissions arising from hotel accommodation associated with business travel','18', 'HORIZONTAL_LEFT', false, in_array('Flight and Accommodation', $companySelectedActivity));
        self::reportForthColumn($sheet, 'D19', 'All transportation by sea','19', 'HORIZONTAL_LEFT', false, in_array('Business travel - land and sea', $companySelectedActivity));
        self::reportForthColumn($sheet, 'D20', 'All transportation by land, public transport, rented/leased vehicle and taxi','20', 'HORIZONTAL_LEFT', false, in_array('Business travel - land and sea', $companySelectedActivity));
        self::reportForthColumn($sheet, 'D21', 'Freighting goods','21', 'HORIZONTAL_LEFT', false, in_array('Freighting goods', $companySelectedActivity));
        self::reportSubTitleColumnWidth($sheet, 'D', '40');
        self::commonReportStyle($sheet);
        $totals = [
            'fuelsSum', 'refrigerantsSum', 'wttFulesSum', 'tAndDSum',
            'materialUseSum', 'employeesCommutingSum', 'foodSum',
            'homeOfficeSum', 'freightingGoodsAllSum', 'wasteDisposelSum',
            'flightAndAccommodationFlightSum', 'flightAndAccommodationHotelSum',
            'deliveryVehicleSum', 'pessengerVehicleSum', 'electricityEvsSum',
            'electricitySum', 'districtHeatSteamSum', 'districtCoolingSum',
            'waterSupplyValue', 'waterTreatmentValue', 'traspotationBySeaSum',
            'traspotationByLandSum'
        ];
        
        foreach ($totals as $key) {
            ${$key . 'Tot'} = 0.00;
            if (array_key_exists($key, $worksheet)) {
                ${$key . 'Tot'} = $worksheet[$key] / 1000;
            }
        }
        
        $totalEmission = $fuelsSumTot + $refrigerantsSumTot + $wttFulesSumTot + $tAndDSumTot + $materialUseSumTot + $employeesCommutingSumTot + $foodSumTot + $homeOfficeSumTot + $freightingGoodsAllSumTot + $wasteDisposelSumTot + $flightAndAccommodationFlightSumTot + $flightAndAccommodationHotelSumTot + $deliveryVehicleSumTot + $pessengerVehicleSumTot + $electricityEvsSumTot + $electricitySumTot + $districtHeatSteamSumTot + $districtCoolingSumTot + $waterSupplyValueTot + $waterTreatmentValueTot + $traspotationBySeaSumTot + $traspotationByLandSumTot;
        self::reportForthColumn($sheet, 'E3', $fuelsSumTot, '21', 'HORIZONTAL_RIGHT', true);
        self::reportForthColumn($sheet, 'E4', $refrigerantsSumTot, '21', 'HORIZONTAL_RIGHT', true);
        self::reportForthColumn($sheet, 'E5', $pessengerVehicleSumTot, '21', 'HORIZONTAL_RIGHT', true);
        self::reportForthColumn($sheet, 'E6', $deliveryVehicleSumTot, '21', 'HORIZONTAL_RIGHT', true);
        self::reportForthColumn($sheet, 'E7', $electricitySumTot, '21', 'HORIZONTAL_RIGHT', true);
        self::reportForthColumn($sheet, 'E8', $districtHeatSteamSumTot, '21', 'HORIZONTAL_RIGHT', true);
        self::reportForthColumn($sheet, 'E9', $electricityEvsSumTot, '21', 'HORIZONTAL_RIGHT', true);
        self::reportForthColumn($sheet, 'E10', $districtCoolingSumTot, '21', 'HORIZONTAL_RIGHT', true);
        self::reportForthColumn($sheet, 'E11', $wttFulesSumTot, '21', 'HORIZONTAL_RIGHT', true);
        self::reportForthColumn($sheet, 'E12', $tAndDSumTot, '21', 'HORIZONTAL_RIGHT', true);
        self::reportForthColumn($sheet, 'E13', $waterTreatmentValueTot, '21', 'HORIZONTAL_RIGHT', true);
        self::reportForthColumn($sheet, 'E14', $wasteDisposelSumTot ,'21', 'HORIZONTAL_RIGHT', true);
        self::reportForthColumn($sheet, 'E15', $waterSupplyValueTot, '21', 'HORIZONTAL_RIGHT', true);
        self::reportForthColumn($sheet, 'E16', $materialUseSumTot, '21', 'HORIZONTAL_RIGHT', true);
        self::reportForthColumn($sheet, 'E17', $flightAndAccommodationFlightSumTot, '21', 'HORIZONTAL_RIGHT', true);
        self::reportForthColumn($sheet, 'E18', $flightAndAccommodationHotelSumTot , '21', 'HORIZONTAL_RIGHT', true);
        self::reportForthColumn($sheet, 'E19', $traspotationBySeaSumTot, '21', 'HORIZONTAL_RIGHT', true);
        self::reportForthColumn($sheet, 'E20', $traspotationByLandSumTot, '21', 'HORIZONTAL_RIGHT', true);
        self::reportForthColumn($sheet, 'E21', $freightingGoodsAllSumTot, '21', 'HORIZONTAL_RIGHT', true);
        self::reportForthColumn($sheet, 'E22', $employeesCommutingSumTot, '21', 'HORIZONTAL_RIGHT', true);
        self::reportForthColumn($sheet, 'E23', $foodSumTot, '21', 'HORIZONTAL_RIGHT', true);
        self::reportForthColumn($sheet, 'E24', $homeOfficeSumTot, '21', 'HORIZONTAL_RIGHT', true);
        self::reportFooterTitleCollumnDesign($sheet, 'Total Emissions', 'A25', 'D25', 'HORIZONTAL_CENTER', false);
        self::reportFooterTitleCollumnDesign($sheet, $totalEmission, 'E25', 'E25', 'HORIZONTAL_RIGHT', true);
        
        return $fuelArray;
    }


    public function setTitleDesignReport($sheet, $title, $titleCollumn)
    {
        $sheet->setCellValue('A1', $title);
        $totalNumberofCollumn = count($titleCollumn) - 1;
        $sheet->mergeCells('A1:' . Config::get('constants.collumn')[$totalNumberofCollumn] . '1');
        $sheet->getStyle('A1')->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle('A1')->getFont()->getColor()->setARGB(Config::get('constants.mainReportTitleColor'));
        $style = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];
        $sheet->getStyle('A1')->applyFromArray($style);
        $sheet->getRowDimension(1)->setRowHeight(Config::get('constants.titleCollumnRowHeight'));
        return $sheet;
    }

    public function reportSubTitleCollumnDesign($sheet, $title, $cellOne, $cellTwo)
    {
        $sheet->setCellValue($cellOne, $title);
        if(isset($cellOne) && isset($cellTwo)){
            $sheet->mergeCells($cellOne . ':' . $cellTwo);
        }
        $sheet->getStyle($cellOne)->getFont()->getColor()->setARGB(Config::get('constants.mainReportTitleColor')); 
        $sheet->getRowDimension(2)->setRowHeight(Config::get('constants.titleCollumnRowHeight'));
        $style = $sheet->getStyle($cellOne);

        $style->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);
        $style->getFont()->setSize(Config::get('constants.titleFontSize'))->setBold(true);

        $sheet->getStyle($cellOne)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB(Config::get('constants.columnBgColor')); // Custom color in ARGB format: #FF8496B0
        $sheet->getStyle($cellOne)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $cellStyle = $sheet->getStyle($cellOne);
        $cellStyle->getBorders()->getAllBorders()->getColor()->setARGB('7f7f7f');
        return $sheet;
    }

    public function reportSubTitleColumnWidth($sheet, $columnOne, $value)
    {
        $sheet->getColumnDimension($columnOne)->setWidth($value);
        return $sheet;
    }

    public function reportMergeColumn($sheet, $columnOne, $columnTwo, $content)
    {
        $sheet->mergeCells($columnOne.':'.$columnTwo);
        $sheet->setCellValue($columnOne, $content);
        $style = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'textRotation' => 90,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'FFFFFF'], 
                ],
            ],
        ];
        $sheet->getStyle($columnOne.':'.$columnTwo)->applyFromArray($style);
        $style = $sheet->getStyle($columnOne.':'.$columnTwo);
        $style->getFont()->setSize(Config::get('constants.valueFontSize'))->setBold(true);
        
        for($i=1; $i<=23; $i++){
            $sheet->getRowDimension($i)->setRowHeight(22);
        } 
        // $sheet->getColumnDimension('A')->setAutoSize(true);    
        $sheet->getColumnDimension('A')->setWidth(5);        
        $sheet->getStyle($columnOne)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB(Config::get('constants.firstHorizontalTitleBgColor'));
        $sheet->getStyle($columnOne)->getFont()->getColor()->setARGB('ffffff'); 
        return $sheet;
    }

    public function reportMergeSecondColumn($sheet, $columnOne, $columnTwo, $content, $loopCount, $heightValue)
    {
        $sheet->mergeCells($columnOne.':'.$columnTwo);
        $sheet->setCellValue($columnOne, $content);
        $style = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'textRotation' => 90,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'FFFFFF'], 
                ],
            ],
        ];
        $sheet->getStyle($columnOne.':'.$columnTwo)->applyFromArray($style);
        $style = $sheet->getStyle($columnOne.':'.$columnTwo);
        $style->getFont()->setSize(Config::get('constants.valueFontSize'))->setBold(true);
        
        for($i=1; $i<=$loopCount; $i++){
            $sheet->getRowDimension($i)->setRowHeight($heightValue);
        }     
        $sheet->getColumnDimension('B')->setWidth(5);    
        $sheet->getStyle($columnOne)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB(Config::get('constants.firstHorizontalTitleBgColor'));
        $sheet->getStyle($columnOne)->getFont()->getColor()->setARGB('ffffff'); 
        return $sheet;
    }

    public function reportMergeThirdColumn($sheet, $columnOne, $columnTwo, $content, $loopCount, $heightValue, $selectedActivityFlag = true)
    {        
        $sheet->mergeCells($columnOne.':'.$columnTwo);
        $sheet->setCellValue($columnOne, $content);
        $style = [
            'alignment' => [
                // 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
            // 'borders' => [
            //     'outline' => [
            //         'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            //         'color' => ['rgb' => '7f7f7f'], 
            //     ],
            // ],
        ];
        $sheet->getRowDimension($loopCount)->setRowHeight(30);
        $sheet->getStyle($columnOne.':'.$columnTwo)->applyFromArray($style);
        $style = $sheet->getStyle($columnOne.':'.$columnTwo);
        $sheet->getStyle($columnOne)->getAlignment()->setWrapText(true);   
        if($selectedActivityFlag == false)
        {
            $sheet->getRowDimension($loopCount)->setVisible(false);
        }
        $style->getFont()->setSize(Config::get('constants.valueFontSize'))->setBold(false);
        $sheet->getStyle($columnOne)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB(Config::get('constants.reportDataBgColor'));
        $sheet->getStyle($columnOne)->getFont()->getColor()->setARGB(Config::get('constants.mainReportTitleColor')); 
        // self::commonReportStyle($sheet);
        return $sheet;
    }

    public function reportForthColumn($sheet, $columnOne, $content, $columnIndex, $align, $isNumFormat, $selectedActivityFlag = true)
    {
        $sheet->setCellValue($columnOne, $content);
        if(isset($align) && $align == "HORIZONTAL_LEFT"){
            $style = [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                ],
            ];
        }else if(isset($align) && $align == "HORIZONTAL_RIGHT"){
            $style = [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                ],
            ];
        }else if(isset($align) && $align == "HORIZONTAL_CENTER"){
            $style = [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ];
        }else{
            $style = [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                ],
            ];
        }
        // $style = [
        //     'alignment' => [
        //         'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,                
        //     ],
        //     'borders' => [
        //         'outline' => [
        //             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        //             'color' => ['rgb' => '7f7f7f'], 
        //         ],
        //     ],
        // ];
        $sheet->getStyle($columnOne)->applyFromArray($style);
        $style = $sheet->getStyle($columnOne);
        if(isset($isNumFormat) && $isNumFormat == true){
            $sheet->getStyle($columnOne)->getNumberFormat()->setFormatCode('#,##0.00');
        }
        $sheet->getStyle($columnOne)->getAlignment()->setWrapText(true);    
        $sheet->getRowDimension($columnIndex)->setRowHeight(30);
        
        if($selectedActivityFlag == false)
        {
            $sheet->getRowDimension($columnIndex)->setVisible(false);
        }
        $style->getFont()->setSize(Config::get('constants.valueFontSize'))->setBold(false);
        $sheet->getStyle($columnOne)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB(Config::get('constants.reportDataBgColor'));
        $sheet->getStyle($columnOne)->getFont()->getColor()->setARGB(Config::get('constants.mainReportTitleColor')); 
        return $sheet;
    }


    public function reportFooterTitleCollumnDesign($sheet, $title, $cellOne, $cellTwo, $align, $isNumFormat)
    {
        $sheet->setCellValue($cellOne, $title);
        if(isset($cellOne) && isset($cellTwo)){
            $sheet->mergeCells($cellOne . ':' . $cellTwo);
        }
        $sheet->getStyle($cellOne)->getFont()->getColor()->setARGB(Config::get('constants.mainReportTitleColor')); 
        $sheet->getRowDimension(25)->setRowHeight(Config::get('constants.titleCollumnRowHeight'));
        $style = $sheet->getStyle($cellOne);
        if(isset($align) && $align == "HORIZONTAL_CENTER"){
            $style->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER);
        }else if(isset($align) && $align == "HORIZONTAL_LEFT"){
            $style->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_LEFT)
            ->setVertical(Alignment::VERTICAL_CENTER);
        }else if(isset($align) && $align == "HORIZONTAL_RIGHT"){
            $style->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_RIGHT)
            ->setVertical(Alignment::VERTICAL_CENTER);
        }else{
            $style->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);
        }
        $style->getFont()->setSize(Config::get('constants.titleFontSize'))->setBold(true);

        $sheet->getStyle($cellOne)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB(Config::get('constants.columnBgColor')); // Custom color in ARGB format: #FF8496B0
        $sheet->getStyle($cellOne)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        if(isset($isNumFormat) && $isNumFormat == true){
            $sheet->getStyle($cellOne)->getNumberFormat()->setFormatCode('#,##0.00');
        }
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $cellStyle = $sheet->getStyle($cellOne);
        $cellStyle->getBorders()->getAllBorders()->getColor()->setARGB('7f7f7f');

        return $sheet;
    }

    public static function commonReportStyle($sheet){
        // $sheet->getStyle('C3:E24')->applyFromArray([        
        //     'getFont' => [
        //         'setSize' => [Config::get('constants.valueFontSize')],
        //         'setBold' => [false]
        //     ],
        //     'getFont' => [
        //         'getColor' => [
        //             'setARGB' => [Config::get('constants.mainReportTitleColor')]
        //         ]
        //     ],
        //     'getFill' => [
        //         'setFillType' => [Fill::FILL_SOLID],
        //         'getStartColor' => [
        //             'setARGB' => [Config::get('constants.reportDataBgColor')]
        //         ]
        //     ]
        // ]);

        // return $sheet;

        $sheet->getStyle('C3:E24')->applyFromArray([
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '7f7f7f'], 
                ],
                'inside' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '7f7f7f'],
                ],
            ],            
        ]);
        
        return $sheet;
        
    }

    public function datasheetStatusUpdate()
    {
        $dataSheetData =  Datasheet::select('id', 'status')->get();
        return ['data' => $dataSheetData];
    }
}
