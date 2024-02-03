<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\BakupCreateRequest;
use App\Jobs\CompanyDatasheetZipCreate;
use App\Mail\Admin\BackupCreateMail;
use App\Models\CompanyBackup;
use App\Models\Datasheet;
use Exception;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class BackupReportsController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            $obj1 = CompanyBackup::with(['company'])->whereNull('deleted_at');
            
            $sortField = '';
            $sortOrder = '';
            
            if (empty($request->get('order')) && empty($request->get('order')[0]) && empty($request->get('order')[0]['column']) && empty($request->get('order')[0]['dir'])) {
                $obj1->orderBy('created_at', 'DESC');
            } else {
                $sortField = $request->get('columns')[$request->get('order')[0]['column']]['name'];
                $sortOrder = strtoupper($request->get('order')[0]['dir']);
            }

            if (!empty($request->company_filter)) {
                $obj1->whereHas('company', function ($query) use ($request) {
                    $query->where('id', $request->company_filter);
                });
            } else {
                $obj1;
            }
            
            return DataTables::of($obj1)->make(true);
        }
        $companies = Company::whereNotNull('company_name')->whereNull('deleted_at')->get()->toArray();
        return view('admin.backup-report.list', compact('companies'));
    }

    public function create()
    {
        $companies = Company::whereNull('deleted_at')->whereNotNull('company_name')->orderBy('company_name','asc')->get()->toArray();
        return view('admin.backup-report.create', compact('companies'));
    }

    public function store(BakupCreateRequest $request)
    {
        
        try {
            if(!empty($request->my_hidden_startdate ) && !empty($request->my_hidden_enddate)){
                $companydatasheet = Datasheet::where('company_id',$request->company)->whereBetween('created_at',[$request->my_hidden_startdate . ' 00:00:00', $request->my_hidden_enddate . ' 23:59:59'])->get()->toArray();
            }else{
                $companydatasheet = Datasheet::where('company_id',$request->company)->get()->toArray();
            }
            if(!empty($companydatasheet) && count($companydatasheet) > 0){
                $companyInfo = Company::where('id',$request->company)->first()->toArray();
                $name = str_replace(' ', '', $companyInfo['company_name']).'-'.time().'.zip';
                $backupInfo = new CompanyBackup();
                $backupInfo->company_id = $request->company;
                $backupInfo->start_date = $request->my_hidden_startdate;
                $backupInfo->end_date = $request->my_hidden_enddate;
                $backupInfo->status = '0';
                $backupInfo->save();
                if(Auth::guard('admin')->user()){
                    $jsonCompanyhis = Auth::guard('admin')->user()->name.' has been created company backup';
                    $moduleid = 31;
                    $userId = Auth::guard('admin')->user()->id;
                    $action = "Created";
                    $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
                }
                $folderPath = storage_path('app/public/uploads/backup'); 
                if (!is_dir($folderPath)) {
                    File::makeDirectory($folderPath, 0777, true);
                }
                
                CompanyDatasheetZipCreate::dispatch($companydatasheet, $name, $companyInfo, $backupInfo);
                return redirect()->route('backup-report.index')->with("success","Backup report is successfully created.");
            }else{
                return redirect()->route('backup-report.index')->with("error","It appears that no activity sheet was found, which is why no backup was created.");
            }
            
        } catch (Exception $e) {
            return redirect()->route('backup-report.index')->with("error",$e->getMessage());
        }
    }

    public function show(Request $request, $id)
    {
        $backupReport = CompanyBackup::with('company')->where('id', $id)->first()->toArray();
        $jsonBackup = json_decode($backupReport['report_json'],true);
        
        if($request->ajax()){
            $datasheets = Datasheet::where('company_id', $backupReport['company_id'])
            ->where(function ($query) use ($jsonBackup) {
                $query->whereIn('uploded_sheet', array_column($jsonBackup, 'name'))
                    ->orWhereIn('emission_calculated', array_column($jsonBackup, 'name'));
            });

            $columns = $request->input('columns');
            foreach($columns as $column){
                $searchValue = $column['search']['value'];
                if(!empty($searchValue) && $column['name'] == 'uploded_sheet'){
                    $datasheets->where('uploded_sheet', 'LIKE', '%'.$request->search['value'].'%');
                }
                if(!empty($searchValue) && $column['name'] == 'emission_calculated'){
                    $datasheets->where('emission_calculated', 'LIKE', '%'.$request->search['value'].'%');
                }
            }
            $sortField = '';
            $sortOrder = '';
            if (empty($request->get('order')) && empty($request->get('order')[0]) && empty($request->get('order')[0]['column']) && empty($request->get('order')[0]['dir'])) {
                $datasheets->orderBy('uploded_sheet', 'asc');
            } else {
                $sortField = $request->get('columns')[$request->get('order')[0]['column']]['name'];
                $sortOrder = strtoupper($request->get('order')[0]['dir']);
            }

            return DataTables::of($datasheets)->addIndexColumn()->editColumn('uploded_sheet', function ($row) {
                if($row->uploded_sheet != '-'){
                    $uploadsheet = explode('datasheets/',$row->uploded_sheet);
                    $filename = $uploadsheet[1];
                    return '<span>'.$filename.'</span>';
                }
                return '-';
            })->editColumn('emission_calculated', function ($row) {
                if($row->emission_calculated != '-'){
                    $uploadsheet = explode('calculated_datasheet/',$row->emission_calculated);
                    $filename = $uploadsheet[1];
                    return '<span>'.$filename.'</span>';
                }
                return '-';
            })->editColumn('action', function ($row) {
                $html = '';
                $html .= '<div class="dropdown sheet-dots"><div class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"  ><picture><img src="' . asset('assets/images/sheet-dots.svg') . '" alt="sheet-dots"></picture></div>';
                $html .= '<ul class="dropdown-menu edit-sheet">';
                if($row->uploded_sheet != '-'){
                    $html .=  '<li><a href="'.$row->uploded_sheet.'" download>Upload Sheet</a></li>';
                }
                if($row->emission_calculated != '-'){
                    $html .=  '<li><a href="'.$row->emission_calculated.'" download>Emssion Calculated Sheet</a></li>';
                }
                $html .= '</ul></div>';
                return $html;
            })
            ->rawColumns(['action', 'uploded_sheet', 'emission_calculated'])->make(true);
        }
        return view('admin.backup-report.show', compact('backupReport', 'jsonBackup'));
    }

    public function testfile($companydatasheet, $name, $companyInfo, $backupInfo)
    {
        $datasheetArr = $companydatasheet;
        $fileName = $name;
        $backupdetails = $backupInfo;
        $backupdetails->status = "1";
        $backupdetails->save();

        $allDatasheet = [];
        foreach($datasheetArr as $key => $datasheet){
            if(!empty($datasheet['uploded_sheet']) && $datasheet['uploded_sheet'] != '-'){
                $datasheetExplode = explode('datasheets/',$datasheet['uploded_sheet']);
                array_push($allDatasheet,[
                    'path' => storage_path('app/public/uploads/datasheets/'),
                    'name'=>$datasheetExplode[1]
                ]);
            }
            if(!empty($datasheet['emission_calculated']) && $datasheet['emission_calculated'] != '-'){
                $emissionsheetExplode = explode('calculated_datasheet/',$datasheet['emission_calculated']);
                array_push($allDatasheet,[
                    'path' => storage_path('app/public/uploads/calculated_datasheet/'),
                    'name'=>$emissionsheetExplode[1]
                ]);
            }
        }

        $zip = new ZipArchive();
        $filepath = storage_path('/app/public/uploads/backup/'.$fileName);
        if ($zip->open($filepath, ZipArchive::CREATE | ZipArchive::OVERWRITE)== TRUE){
            foreach ($allDatasheet as $folder){
                $files = File::files($folder['path']);
                foreach ($files as $key => $value){
                    $relativeName = basename($value);
                    if($relativeName == $folder['name']){
                        $zip->addFile($value, $relativeName);
                    }
                }
            }
            $zip->close();
            $userDetails = \App\Models\User::with('company')->where('id',$companyInfo['user_id'])->first();
            $data = [
                'name' => $userDetails->name,
                'content' => "I am writing to inform you that a backup has been successfully created for the activity sheets uploaded by ".$companyInfo['company_name'].". This backup ensures the safety and security of the company's important data.",
                'company_logo' => isset($userDetails->company->company_logo) ? $userDetails->company->company_logo : asset('assets/images/logo.png') 
            ];
            $filepathurl = Storage::disk('backup')->url($fileName);
            Mail::to($userDetails->email)->send(new BackupCreateMail($data, $filepathurl));
            $backupdetails->status = "2";
            $backupdetails->file = $fileName;
            $backupdetails->report_json = json_encode($allDatasheet);
            $backupdetails->save();
        } else {
            $backupdetails->status = "3";
            $backupdetails->save();
        }
    }
}
