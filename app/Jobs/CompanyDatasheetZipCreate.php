<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use App\Mail\Admin\BackupCreateMail;
use Exception;
use ZipArchive;

class CompanyDatasheetZipCreate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected  $companydatasheet;
    protected  $name;
    protected  $companyInfo;
    protected  $backupInfo;
    /**
     * Create a new job instance.
     */
    public function __construct($companydatasheet, $name, $companyInfo, $backupInfo)
    {
        $this->companydatasheet = $companydatasheet;
        $this->name = $name;
        $this->companyInfo = $companyInfo;
        $this->backupInfo  = $backupInfo;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $datasheetArr = $this->companydatasheet;
        $fileName = $this->name;
        $backupdetails = $this->backupInfo;
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
            $userDetails = \App\Models\User::with('company')->where('id',$this->companyInfo['user_id'])->first();
            $data = [
                'name' => $userDetails->name,
                'content' => "The backup has been successfully created for the activity sheets uploaded by the ".$this->companyInfo['company_name'],
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

    /**
     * Handle a job failure.
     */
    public function failed(Exception $exception): void
    {
        $this->backupInfo->status = "3";
        $this->backupInfo->save();
    }

    
}