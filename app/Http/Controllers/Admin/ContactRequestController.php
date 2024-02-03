<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerSupport;
use App\Models\CustomerSupportFile;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ContactRequestController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $obj1 = CustomerSupport::with(['user'])->whereNull('deleted_at');

            $sortField = '';
            $sortOrder = '';
            if (empty($request->get('order')) && empty($request->get('order')[0]) && empty($request->get('order')[0]['column']) && empty($request->get('order')[0]['dir'])) {
                $obj1->orderBy('created_at', 'DESC');
            } else {
                $sortField = $request->get('columns')[$request->get('order')[0]['column']]['name'];
                $sortOrder = strtoupper($request->get('order')[0]['dir']);
            }
            return DataTables::of($obj1)->make(true);
        }
        return view('admin.contactus.list');
    }

    public function show($id)
    {
        $contactinfo = CustomerSupport::with(['user'])->where('id',$id)->whereNull('deleted_at')->first()->toArray();
        $contactAttachment = CustomerSupportFile::where('customer_support_id',$id)->whereNull('deleted_at')->get()->toArray();
        return view('admin.contactus.show', compact('contactinfo', 'contactAttachment'));
    }
}
