<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Jobs\SendCustomerSupportEmail;
use App\Models\{CustomerSupport, CustomerSupportFile};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CustomerSupportController extends Controller
{
    public function index(Request $request)
    {
        $userDetail = optional(Auth::guard('web')->user());
        return view('frontend.customer-support.create', compact('userDetail'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'phone_number'=>['required'],
            'subject'=>'required',
            'message'=>'required',
            'name' => 'required',
            'email' => 'required|email',
        ]);
        try {
            $customerSupportId = CustomerSupport::insertGetId($this->customerSupportObject($request));
            // Insert customer support files
            if (isset($request->filename)) {
                CustomerSupportFile::insert($this->customerSupportFileObject($request->filename, $customerSupportId));
                if(Auth::guard('web')->user()){
                    $jsonCompanyhis = 'Added customer support';
                    $moduleid = 5;
                    $userId = Auth::guard('web')->user()->id;
                    $action = "create";
                    $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
                }
            }

            SendCustomerSupportEmail::dispatch($this->customerSupportObject($request), $customerSupportId);
            return redirect()->route('customer-support.index')->with('success', 'Customer support details send successfully.');
        } catch (\Exception $e) {
            return redirect()->route('customer-support.index')->with('error', $e->getMessage());
        }
    }

    //Customer support object create
    public function customerSupportObject($request)
    {
        return [
            'user_id' => Auth::guard('web')->user()->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'message' => isset($request->message) ? $request->message :  '',
            'subject' => isset($request->subject) ? $request->subject :  '',
            'created_at'  => now(),
            'updated_at' => now()
        ];
    }

    //Customer support file  array create
    public function customerSupportFileObject(array $fileArray, int $customerSupportId)
    {
        $customerSupportFileArray = array();
        foreach ($fileArray as $value) {

            $customerSupportFileObject = [
                'customer_support_id' => $customerSupportId,
                'file_name' => companyLogoFileUpload('customer_support', $value),
                'created_at' => now(),
                'updated_at' => now()
            ];

            array_push($customerSupportFileArray, $customerSupportFileObject);
        }

        return $customerSupportFileArray;
    }
}
