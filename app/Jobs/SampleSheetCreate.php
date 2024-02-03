<?php

namespace App\Jobs;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class SampleSheetCreate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected  $activity;
    protected  $companyIds;
    /**
     * Create a new job instance.
     */
    public function __construct($activity, $companyIds)
    {
        $this->activity = $activity;
        $this->companyIds = $companyIds;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $activityarr = $this->activity;
        $companyIdsArr = $this->companyIds;
        if(!empty($companyIdsArr) && count($companyIdsArr) > 0){
            foreach($companyIdsArr as $companyID){
                $companyData = Company::where('id', $companyID)->with('companyactivities.activitydata:id,name')->first();
                $emissonames = \Illuminate\Support\Arr::pluck($companyData->companyactivities->toArray(), 'activitydata.name');
                if(!empty($companyData->sample_datasheet)){
                    Storage::disk('sample_datasheet')->delete($companyData->sample_datasheet);
                }
                $companyData->sample_datasheet = sheetGenerate($emissonames, $companyID);
                $companyData->save(); 
            }
        }
    }
}
