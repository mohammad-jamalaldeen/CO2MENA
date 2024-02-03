<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ElectricityRequest;
use App\Jobs\SampleSheetCreate;
use App\Models\Activity;
use App\Models\Company;
use App\Models\CompanyActivity;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\Electricity;
use Illuminate\Support\Facades\Auth;
use App\Models\Country;
use Exception;

class ElectricityController extends Controller
{
    /*****
     * View Index page 
     * */
    public function index(Request $request)
    {
        $userModel = Auth::guard('admin')->user();
        $countries = Country::where('name', 'United Arab Emirates')->get();
        $electricity_type = $request->electricity_type;
        $unit = $request->unit;
        $country = $request->country;

        if ($request->ajax()) {
            $obj1 = Electricity::with(['country'])->whereNull('deleted_at');
            if(!empty($electricity_type) && $electricity_type !== '')
            {
                $obj1 = $obj1->where('electricities.electricity_type', $electricity_type);
            }
            if(!empty($country)){
                $obj1 = $obj1->whereHas('country', function($q)use($country){
                    $q->where('id',$country);
                });
            }
            if(!empty($request->unit) && in_array($request->unit, Electricity::UNIT)) {
                $obj1->where('unit',$request->unit);
            }
            $obj1 = $obj1->orderBy('id', 'desc')->get();
            return DataTables::of($obj1)->make(true);
        }
        return view('admin.electricity-heat-cooling.list', compact('userModel','countries'));
    }

    /*****
     * electricity-heat-cooling create page
     * */
    public function create()
    {
        $country = Country::where('name', 'United Arab Emirates')->whereNull('deleted_at')->get();
        return view('admin.electricity-heat-cooling.create', compact('country'));
    }
    /*****
     * electricity-heat-cooling Store
     * */
    public function store(ElectricityRequest $request)
    {
        try {
            $electricity_heat_cooling = new Electricity();
            $electricity_heat_cooling->activity = $request->activity;
            $electricity_heat_cooling->type = $request->type;
            $electricity_heat_cooling->country = $request->country ?? 244;
            $electricity_heat_cooling->unit = $request->unit;
            $electricity_heat_cooling->factors = $request->factors;
            $electricity_heat_cooling->electricity_type = $request->electricity_type;
            $electricity_heat_cooling->save();
            if(Auth::guard('admin')->user()){
                $jsonCompanyhis = 'Created activity "electricity, heat, cooling"';
                $moduleid = 18;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Created";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
            }
            if ($electricity_heat_cooling) {
                return redirect()->route('electricity-heat-cooling.index')->with('success', 'Electricity heat cooling is successfully created.');
            } else {
                return redirect()->route('electricity-heat-cooling.index')->with('error', 'An error occurred while creating Electricity heat cooling.');
            }
        } catch (Exception $e) {
            return redirect()->route('electricity-heat-cooling.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
    /*****
     * electricity-heat-cooling details page show
     * */
    public function show(Request $request, $id)
    {
        try {
            if (!empty($id)) {
                $countries = Country::whereNull('deleted_at')->get();
                $electricity_heat_cooling = Electricity::where('id', $id)->whereNull('deleted_at')->first();
                return view('admin.electricity-heat-cooling.show', compact('electricity_heat_cooling', 'countries'));
            }
        } catch (Exception $e) {
            return redirect()->route('electricity-heat-cooling.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
    /*****
     * electricity-heat-cooling details page edit
     * */
    public function edit($id)
    {
        $country = Country::where('name', 'United Arab Emirates')->whereNull('deleted_at')->get();
        $electricity_heat_cooling = Electricity::where('id', $id)->whereNull('deleted_at')->first();
        return view('admin.electricity-heat-cooling.create', compact('electricity_heat_cooling', 'country'));
    }
    /*****
     * electricity-heat-cooling Update
     * */
    public function update(ElectricityRequest $request, $id)
    {
        // try {
            $electricity_heat_cooling = Electricity::findOrFail($id);
            $electricity_heat_cooling->activity = $request->activity;
            $electricity_heat_cooling->type = $request->type;
            $electricity_heat_cooling->country = $request->country ?? 244;
            $electricity_heat_cooling->unit = $request->unit;
            $electricity_heat_cooling->factors = $request->factors;
            $electricity_heat_cooling->electricity_type = $request->electricity_type;
            $electricity_heat_cooling->update();
            if(Auth::guard('admin')->user()){
                $jsonCompanyhis = 'Updated activity "electricity, heat, cooling"';
                $moduleid = 18;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Updated";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
            }
            $activityid =  Activity::where('name','Electricity, heat, cooling')->first();
            $companyIds = CompanyActivity::where('activity_id',$activityid->id)->get()->pluck('company_id')->toArray();
            SampleSheetCreate::dispatch($activityid,$companyIds);
            if ($electricity_heat_cooling) {
                return redirect()->route('electricity-heat-cooling.index')->with('success', 'Electricity heat cooling is successfully updated.');
            } else {
                return redirect()->route('electricity-heat-cooling.index')->with('error', 'An error occurred while updating electricity heat cooling.');
            }
        // } catch (Exception $e) {
        //     return redirect()->route('electricity-heat-cooling.index')->with('error', $e->getMessage());
        // }
        abort(404);
    }

    public function destroy($id)
    {
        try {
            $electricity_heat_cooling = Electricity::findOrFail($id);
            if ($electricity_heat_cooling->delete()) {
                $activity =  Activity::where('name','Electricity, heat, cooling')->first();
                $companyIds = CompanyActivity::where('activity_id',$activity->id)->whereNull('deleted_at')->get()->pluck('company_id')->toArray();
                SampleSheetCreate::dispatch($activity,$companyIds);
                if(Auth::guard('admin')->user()){
                    $jsonCompanyhis = 'Deleted activity "electricity, heat, cooling"';
                    $moduleid = 18; 
                    $userId = Auth::guard('admin')->user()->id;
                    $action = "Deleted";
                    $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
                }
                return redirect()->route('electricity-heat-cooling.index')->with('success', 'Electricity heat cooling is successfully deleted.');
            }
            return redirect()->route('electricity-heat-cooling.index')->with('error', 'An error occurred while deleting electricity heat cooling.');
        } catch (Exception $e) {
            return redirect()->route('electricity-heat-cooling.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
}
