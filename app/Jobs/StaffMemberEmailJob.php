<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\StaffMemberCreateMail;
use \Illuminate\Support\Facades\Config;
use App\Models\{User, UserRole};

class StaffMemberEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $emailData;
    protected $userEmail;
    /**
     * Create a new job instance.
     */
    public function __construct($emailData, $userEmail)
    {
        $this->emailData = $emailData;
        $this->userEmail = $userEmail;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $companyUserRole = UserRole::where('role','Super Admin')->first();
        $userEmailData = User::select('id', 'email', 'name')-> with('company')->where('user_role_id', $companyUserRole->id)->first();
        $this->emailData['company_logo'] = $userEmailData->company->company_logo;
        sendEmail(
            $this->userEmail, 
            $this->emailData,  
            Config::get('constants.emailSubject.StaffMemberCreateMail'), 
            Config::get('constants.emailPageUrl.staffMemeberCreate'),
            $filePaths = array(),
            $fileType='', 
            $cc= $userEmailData->email,
        );        
    }
}
