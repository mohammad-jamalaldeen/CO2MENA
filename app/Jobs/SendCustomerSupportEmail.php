<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\Fronted\CustomerSupportMail;
use \Illuminate\Support\Facades\Config;
use App\Models\{User, CustomerSupportFile, UserRole};

class SendCustomerSupportEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $requestData;
    protected $customerSupportId;

    public function __construct($requestData, $customerSupportId)
    {
        $this->requestData = $requestData;
        $this->customerSupportId = $customerSupportId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $companyUserRole = UserRole::where('role','Super Admin')->first();
        $userRoleArray = UserRole::where('role', '!=','Super Admin')->where('type', 'Backend')->pluck('id')->toArray();
        $userEmailData = User::select('id', 'email', 'name')->where('user_role_id', $companyUserRole->id)->first();
        $subUserEmailData = User::whereIn('user_role_id', $userRoleArray )->pluck('email')->toArray();        
        $this->requestData['admin_name'] = $userEmailData->name;
        $this->requestData['company_logo'] = asset('assets/images/logo.png');
        $customerSupportFile = CustomerSupportFile::where('customer_support_id', $this->customerSupportId)->pluck('file_name');
        sendEmail($userEmailData->email,$this->requestData,  Config::get('constants.emailSubject.customerSupport') . $this->requestData['subject'], Config::get('constants.emailPageUrl.customerSupport'), $customerSupportFile, 'store', '',$subUserEmailData);
    }
}
