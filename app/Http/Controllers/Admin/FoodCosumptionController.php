<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SampleSheetCreate;
use App\Models\Activity;
use App\Models\CompanyActivity;
use Illuminate\Http\Request;
use App\Models\FoodCosumption;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class FoodCosumptionController extends Controller
{
    /*
     ** list of Food Cosumption
    */
    public function index(Request $request)
    {
        $unit = $request->unit;
        if($request->ajax()){
            $foodcosumption = FoodCosumption::whereNull('deleted_at');
            if (!empty($unit) && $unit !== '') {
                $foodcosumption = $foodcosumption->where('unit', $unit);
            }
            if(!empty($request->type) && $request->type != ""){
                $foodcosumption->where('type',$request->type);
            }
            $foodcosumption = $foodcosumption->orderBy('id', 'desc')->get();
            return DataTables::of($foodcosumption)->make(true);
        }
        return view('admin.foodcosumption.list');
    }
    /*
     ** create Food Cosumption
    */
    public function create(Request $request)
    {
        return view('admin.foodcosumption.create');
    }
    /*
     ** store Food Cosumption
    */
    public function store(Request $request)
    {
        $request->validate(
            [
                'vehicle' => 'required|string',
                'unit' => 'required|string',
                'type' => 'required',
                'factors' => 'required|numeric',
            ],
            ['factors'=>'The emission factor field must be a number.']
        );
        $welltotankfuels = new FoodCosumption();
        $welltotankfuels->vehicle = $request->input('vehicle');
        $welltotankfuels->unit = $request->input('unit');
        $welltotankfuels->type = $request->input('type');
        $welltotankfuels->factors = $request->input('factors'); 
        $welltotankfuels->save();
        if(Auth::guard('admin')->user()){
            $jsonCompanyhis = 'Created activity "Food"';
            $moduleid = 23;
            $userId = Auth::guard('admin')->user()->id;
            $action = "Created";
            $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
        }
        return redirect()->route('foodcosumption.index')->with([
            'success' => 'Food cosumption is successfully added!'
        ]);
    }
    public function show($id)
    {
        $foodcosumption = FoodCosumption::where('id',$id)->whereNull('deleted_at')->first();
        return view('admin.foodcosumption.show', compact('foodcosumption'));
    }
    public function edit($id)
    {
        $foodcosumption = FoodCosumption::where('id',$id)->whereNull('deleted_at')->first();
        return view('admin.foodcosumption.edit', compact('foodcosumption'));
    }
    /**
     * Food Cosumption Update
    */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'vehicle' => 'required|string',
                'unit' => 'required|string',
                'type' => 'required',
                'factors' => 'required|numeric',
            ],
            ['factors'=>'The emission factor field must be a number.']
        );
        $welltotankfuels = FoodCosumption::findOrFail($id);
        $welltotankfuels->vehicle = $request->input('vehicle');
        $welltotankfuels->unit = $request->input('unit');
        $welltotankfuels->type = $request->input('type');
        $welltotankfuels->factors = $request->input('factors'); 
        $welltotankfuels->save();
        if ($welltotankfuels->save()) {
            $activity =  Activity::where('name','Food')->first();
            $companyIds = CompanyActivity::where('activity_id',$activity->id)->whereNull('deleted_at')->get()->pluck('company_id')->toArray();
            SampleSheetCreate::dispatch($activity,$companyIds);
            if(Auth::guard('admin')->user()){
                $jsonCompanyhis = 'Updated activity "Food"';
                $moduleid = 23;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Updated";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
            }
            return redirect()->route('foodcosumption.index')->with('success', 'Food cosumption is successfully updated.');
        }
        return redirect()->route('foodcosumption.index')->with('error', 'An error occurred while updating food cosumption.');
    }
    /**
     * Delete Food Cosumption
    */

    public function destroy($id)
    {
        $welltotankfuels = FoodCosumption::findOrFail($id);
        if ($welltotankfuels->delete()) {
            $activity =  Activity::where('name','Food')->first();
            $companyIds = CompanyActivity::where('activity_id',$activity->id)->get()->pluck('company_id')->toArray();
            SampleSheetCreate::dispatch($activity,$companyIds);
            if(Auth::guard('admin')->user()){
                $jsonCompanyhis = 'Deleted activity "Food"';
                $moduleid = 23;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Deleted";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
            }
            return redirect()->route('foodcosumption.index')->with('success', 'Food cosumption is successfully deleted.');
       }
       return redirect()->route('foodcosumption.index')->with('error', 'An error occurred while deleting food cosumption.');
    }
}