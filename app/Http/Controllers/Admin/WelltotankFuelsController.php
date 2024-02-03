<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SampleSheetCreate;
use App\Models\Activity;
use App\Models\CompanyActivity;
use Illuminate\Http\Request;
use App\Models\WttFules;
use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class WelltotankFuelsController extends Controller
{
    /*
     ** list of Well to Tank Fuels
    */
    public function index(Request $request)
    {
        $type = $request->type;
        $unit = $request->unit;
        if($request->ajax()){
            $wttfules = WttFules::whereNull('deleted_at');
            if(!empty($type) && $type !== '')
            {
                $wttfules = $wttfules->where('type', $type);
            }
            if(!empty($unit) && $unit !== '')
            {
                $wttfules = $wttfules->where('unit', $unit);
            }
            $wttfules = $wttfules->orderBy('id', 'desc')->get();
            return DataTables::of($wttfules)->make(true);
        }
        return view('admin.welltotankfuels.list');
    }
    /*
     ** create Well to Tank Fuels
    */
    public function create(Request $request)
    {
        return view('admin.welltotankfuels.create');
    }
    /*
     ** store Well to Tank Fuels
    */
    public function store(Request $request)
    {
        
        $request->validate(
            [
                'type' => 'required|string',
                'fuel' => 'required|string',
                'unit' => 'required|string',
                'factors' => 'required|numeric',
            ],
            ['factors'=>'The emission factor field must be a number.']
        );
        try{
            $welltotankfuels = new WttFules();
            $welltotankfuels->type = $request->input('type');
            $welltotankfuels->fuel = $request->input('fuel');
            $welltotankfuels->unit = $request->input('unit');
            $welltotankfuels->factors = $request->input('factors'); 
            $welltotankfuels->save();
            if(Auth::guard('admin')->user()){
                $jsonCompanyhis = 'Created activity "well to tank fuels"';
                $moduleid = 15;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Created";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
            }
            return redirect()->route('welltotankfuels.index')->with([
                'success' => 'Well to tank fuel is successfully added!'
            ]);
        }catch(Exception $e){
            return redirect()->route('welltotankfuels.index')->with('error',$e->getMessage());
        }
        
    }
    
    public function show($id)
    {
        $wttfules = WttFules::where('id',$id)->whereNull('deleted_at')->first();
        return view('admin.welltotankfuels.show', compact('wttfules'));
    }
    public function edit($id)
    {
        $wttfules = WttFules::where('id',$id)->whereNull('deleted_at')->first();
        return view('admin.welltotankfuels.edit', compact('wttfules'));
    }
    /**
     * Well to Tank Fuels Update
    */

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'type' => 'required|string',
                'fuel' => 'required|string',
                'unit' => 'required|string',
                'factors' => 'required|numeric',
            ],
            ['factors'=>'The emission factor field must be a number.']
        );
        try {
            $welltotankfuels = WttFules::findOrFail($id);
            $welltotankfuels->type = $request->input('type');
            $welltotankfuels->fuel = $request->input('fuel');
            $welltotankfuels->unit = $request->input('unit');
            $welltotankfuels->factors = $request->input('factors'); 
            if ($welltotankfuels->save()) {
                $activity =  Activity::where('name','WTT-fules')->first();
                $companyIds = CompanyActivity::where('activity_id',$activity->id)->whereNull('deleted_at')->get()->pluck('company_id')->toArray();
                SampleSheetCreate::dispatch($activity,$companyIds);
                if(Auth::guard('admin')->user()){
                    $jsonCompanyhis = 'Updated activity "well to tank fuels"';
                    $moduleid = 15;
                    $userId = Auth::guard('admin')->user()->id;
                    $action = "Updated";
                    $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
                }
                return redirect()->route('welltotankfuels.index')->with('success', 'Well to tank fuels is successfully updated.');
            }
        } catch (Exception $e) {
            return redirect()->route('welltotankfuels.index')->with('error', $e->getMessage());
        }
        
        
    }
    /**
     * Delete Well to Tank Fuels
    */

    public function destroy($id)
    {
        try {
            $welltotankfuels = WttFules::findOrFail($id);
            if ($welltotankfuels->delete()) {
                $activity =  Activity::where('name','WTT-fules')->first();
                $companyIds = CompanyActivity::where('activity_id',$activity->id)->whereNull('deleted_at')->get()->pluck('company_id')->toArray();
                SampleSheetCreate::dispatch($activity,$companyIds);
                if(Auth::guard('admin')->user()){
                    $jsonCompanyhis = 'Deleted activity "well to tank fuels"';
                    $moduleid = 15;
                    $userId = Auth::guard('admin')->user()->id;
                    $action = "Deleted";
                    $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
                }
                return redirect()->route('welltotankfuels.index')->with('success', 'Well to tank fuels is successfully deleted.');
            }
        } catch (\Exception $e) {
            return redirect()->route('welltotankfuels.index')->with('error', $e->getMessage());   
        }
    }
}