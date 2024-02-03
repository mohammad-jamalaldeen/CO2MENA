<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FuelRequest;
use App\Jobs\SampleSheetCreate;
use App\Models\Activity;
use App\Models\CompanyActivity;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\Fuels;
use Illuminate\Support\Facades\Auth;
use Exception;

class FuelsController extends Controller
{
    /*****
     * View Index page 
     * */
    public function index(Request $request)
    {
        $userModel = Auth::guard('admin')->user();
        $type = $request->type;
        $unit = $request->unit;
        if ($request->ajax()) {
            $obj1 = Fuels::whereNull('deleted_at');
            if(!empty($type) && $type !== '')
            {
                $obj1 = $obj1->where('type', $type);
            }
            if(!empty($unit) && $unit !== '')
            {
                $obj1 = $obj1->where('unit', $unit);
            }
            $obj1 = $obj1->orderBy('id', 'desc')->get();
            return DataTables::of($obj1)->make(true);
        }
        return view('admin.fuels.list', compact('userModel'));
    }
    /*****
     * fuels create page
     * */
    public function create()
    {
        return view('admin.fuels.create');
    }
    /*****
     * fuels Store
     * */
    public function store(FuelRequest $request)
    {
        try {
            $fuels = new Fuels();
            $fuels->type = $request->type;
            $fuels->fuel = $request->fuel;
            $fuels->unit = $request->unit;
            $fuels->factor = $request->factor;
            $fuels->save();

            if(Auth::guard('admin')->user()){
                $jsonCompanyhis = 'Created activity "fuel"';
                $moduleid = 16;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Created";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
            }
            
            if ($fuels) { 
                return redirect()->route('fuels.index')->with('success', 'Fuel is successfully created.');
            } else {
                return redirect()->route('fuels.index')->with('error', 'An error occurred while creating fuel.');
            }
        } catch (Exception $e) {
            return redirect()->route('fuels.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
    /*****
     * fuels details page show
     * */
    public function show(Request $request, $id)
    {
        try {
            if (!empty($id)) {
                $fuels = Fuels::where('id', $id)->whereNull('deleted_at')->first();
                return view('admin.fuels.show', compact('fuels'));
            }
        } catch (Exception $e) {
            return redirect()->route('fuels.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
    /*****
     * fuels details page edit
     * */
    public function edit($id)
    {
        $fuels = Fuels::where('id', $id)->whereNull('deleted_at')->first();
        return view('admin.fuels.create', compact('fuels'));
    }
    /*****
     * fuels Update
     * */
    public function update(FuelRequest $request, $id)
    {
        try {
            $fuels = Fuels::findOrFail($id);
            $fuels->type = $request->type;
            $fuels->fuel = $request->fuel;
            $fuels->unit = $request->unit;
            $fuels->factor = $request->factor;
            $fuels->update();
            if(Auth::guard('admin')->user()){
                $jsonCompanyhis = 'Updated activity "fuel"';
                $moduleid = 16;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Updated";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
            }
            $activity =  Activity::where('name','Fuels')->first();
            $companyIds = CompanyActivity::where('activity_id',$activity->id)->whereNull('deleted_at')->get()->pluck('company_id')->toArray();
            SampleSheetCreate::dispatch($activity,$companyIds);
            if ($fuels) {
                return redirect()->route('fuels.index')->with('success', 'Fuel is successfully updated.');
            } else {
                return redirect()->route('fuels.index')->with('error', 'An error occurred while updating fuel.');
            }
        } catch (Exception $e) {
            return redirect()->route('fuels.index')->with('error', $e->getMessage());
        }
        abort(404);
    }

    public function destroy($id)
    {
        try{
            $fuels = Fuels::findOrFail($id);
            if ($fuels->delete()) {
                $activity =  Activity::where('name','Fuels')->first();
                $companyIds = CompanyActivity::where('activity_id',$activity->id)->whereNull('deleted_at')->get()->pluck('company_id')->toArray();
                SampleSheetCreate::dispatch($activity,$companyIds);
                if(Auth::guard('admin')->user()){
                    $jsonCompanyhis = 'Deleted activity "fuel"';
                    $moduleid = 16;
                    $userId = Auth::guard('admin')->user()->id;
                    $action = "Deleted";
                    $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
                }
                return redirect()->route('fuels.index')->with('success', 'Fuel is successfully deleted.');
            }
            return redirect()->route('fuels.index')->with('error', 'An error occurred while deleting fuel.');
        } catch (Exception $e) {
            return redirect()->route('fuels.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
}
