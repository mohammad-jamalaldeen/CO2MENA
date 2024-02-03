<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SampleSheetCreate;
use App\Models\Activity;
use App\Models\BusinessTravels;
use App\Models\CompanyActivity;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Exception;

class BussinessTravelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $bussinessTravelData = BusinessTravels::whereNull('deleted_at');

            if (isset($request->getvehicle)) {
                $bussinessTravelData->where('vehicles', $request->getvehicle);
            }

            if (isset($request->gettype)) {
                $bussinessTravelData->where('type', $request->gettype);
            }

            if (isset($request->getfuel)) {
                $bussinessTravelData->where('fuel', $request->getfuel);
            }

            if (isset($request->getunit)) {
                $bussinessTravelData->where('unit', $request->getunit);
            }
           
            $sortField = '';
            $sortOrder = '';
            if (empty($request->    get('order')) && empty($request->get('order')[0]) && empty($request->get('order')[0]['column']) && empty($request->get('order')[0]['dir'])) {
                $bussinessTravelData->orderBy('created_at', 'DESC');
            } else {
                $sortField = $request->get('columns')[$request->get('order')[0]['column']]['name'];
                $sortOrder = strtoupper($request->get('order')[0]['dir']);
            }
            return DataTables::of($bussinessTravelData)->make(true);
        }

        return view('admin.bussinesstravel.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.bussinesstravel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                // 'row_id' => 'required|int',
                'vehicles' => 'required|string',
                'type' => 'required|string',
                'fuel' => 'required|string',
                'unit' => 'required|string',
                'factors' => 'required|numeric',
                // 'formula' => 'required|string',
            ],
            ['factors'=>'The emission factor field must be a number.']
        );
        try {
            $bussinessstore = new BusinessTravels();
            // $bussinessstore->row_id = $request->input('row_id');
            $bussinessstore->vehicles = $request->input('vehicles');
            $bussinessstore->type = $request->input('type');
            $bussinessstore->fuel = $request->input('fuel');
            $bussinessstore->unit = $request->input('unit');
            $bussinessstore->factors = $request->input('factors');
            $bussinessstore->total_distance = $request->input('total_distance');
            // $bussinessstore->formula = $request->input('formula');
            $bussinessstore->save();
            if(Auth::guard('admin')->user()){
                $jsonCompanyhis = 'Created activity "business travels"';
                $moduleid = 26;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Created";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
            }
            return redirect()->route('bussinesstravel.index')->with([
                'success' => 'Business travel is successfully added!'
            ]);
        } catch (Exception $e) {
            return redirect()->route('bussinesstravel.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $bussinessshow = BusinessTravels::where('id', $id)->whereNull('deleted_at')->first();
        return view('admin.bussinesstravel.show', compact('bussinessshow'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $bussinessedit = BusinessTravels::where('id', $id)->whereNull('deleted_at')->first();
        return view('admin.bussinesstravel.edit', compact('bussinessedit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                // 'row_id' => 'required|int',
                'vehicles' => 'required|string',
                'type' => 'required|string',
                'fuel' => 'required|string',
                'unit' => 'required|string',
                'factors' => 'required|numeric',
                // 'formula' => 'required|string',
            ]
        );
        try {
            $bussinessupdate = BusinessTravels::findOrFail($id);
            // $bussinessupdate->row_id = $request->input('row_id');
            $bussinessupdate->vehicles = $request->input('vehicles');
            $bussinessupdate->type = $request->input('type');
            $bussinessupdate->fuel = $request->input('fuel');
            $bussinessupdate->unit = $request->input('unit');
            $bussinessupdate->factors = $request->input('factors');
            // $bussinessupdate->formula = $request->input('formula');
            $activity =  Activity::where('name','Business travel - land and sea')->first();
            $companyIds = CompanyActivity::where('activity_id',$activity->id)->whereNull('deleted_at')->get()->pluck('company_id')->toArray();
            SampleSheetCreate::dispatch($activity,$companyIds);
            if(Auth::guard('admin')->user()){
                $jsonCompanyhis = 'Updated activity "business travels"';
                $moduleid = 26;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Updated";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
            }
            if ($bussinessupdate->save()) {
                return redirect()->route('bussinesstravel.index')->with('success', 'Business travel is successfully updated.');
            }
        } catch (Exception $e) {
            return redirect()->route('bussinesstravel.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $bussinessdelete = BusinessTravels::findOrFail($id);
            $activity =  Activity::where('name','Business travel - land and sea')->first();
            $companyIds = CompanyActivity::where('activity_id',$activity->id)->whereNull('deleted_at')->get()->pluck('company_id')->toArray();
            SampleSheetCreate::dispatch($activity,$companyIds);
            if(Auth::guard('admin')->user()){
                $jsonCompanyhis = 'Deleted activity "business travels"';
                $moduleid = 26;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Deleted";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
            }
            if ($bussinessdelete->delete()) {
                return redirect()->route('bussinesstravel.index')->with('success', 'Business travel is successfully deleted.');
            }
        } catch (\Exception $e) {
            return redirect()->route('bussinesstravel.index')->with('error', $e->getMessage());
        }
    }
}
