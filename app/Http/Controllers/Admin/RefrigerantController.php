<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RefrigerantRequest;
use App\Jobs\SampleSheetCreate;
use App\Models\Activity;
use App\Models\Company;
use App\Models\CompanyActivity;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\Refrigerant;
use Illuminate\Support\Facades\Auth;
use Exception;

class RefrigerantController extends Controller
{
    /*****
     * Refrigerant Index page 
     * */
    public function index(Request $request)
    {
        $userModel = Auth::guard('admin')->user();
        $unit = $request->unit;
        if ($request->ajax()) {
            $obj1 = Refrigerant::whereNull('deleted_at');
            if(!empty($unit) && $unit !== ''){
                $obj1 = $obj1->where('unit', $unit);
            }
            if(!empty($request->type) && $request->type != ""){
                $obj1 = $obj1->where('type', $request->type);
            }
            $obj1 = $obj1->orderBy('id','desc')->get();
            return DataTables::of($obj1)->make(true);
        }
        return view('admin.refrigerant.list', compact('userModel'));
    }
    /*****
     * Refrigerant create page
     * */
    public function create()
    {
        return view('admin.refrigerant.create');
    }
    /*****
     * Refrigerant Store
     * */
    public function store(RefrigerantRequest $request)
    {
        try {
            $refrigerant = new Refrigerant();
            $refrigerant->emission = $request->emission;
            $refrigerant->unit = $request->unit;
            $refrigerant->type = $request->type;
            $refrigerant->factors = $request->factors;
            $refrigerant->save();
            if(Auth::guard('admin')->user()){
                $jsonCompanyhis = 'Created activity "refrigerant"';
                $moduleid = 32;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Created";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
            }
            if ($refrigerant) {
                return redirect()->route('refrigerants.index')->with('success', 'Refrigerant is successfully created.');
            } else {
                return redirect()->route('refrigerants.index')->with('error', 'An error occurred while creating refrigerant.');
            }
        } catch (Exception $e) {
            return redirect()->route('refrigerants.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
    /*****
     * Refrigerant details page show
     * */
    public function show(Request $request, $id)
    {
        try {
            if (!empty($id)) {
                $refrigerant = Refrigerant::where('id', $id)->whereNull('deleted_at')->first();
                return view('admin.refrigerant.show', compact('refrigerant'));
            }
        } catch (Exception $e) {
            return redirect()->route('refrigerants.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
    /*****
     * Refrigerant details page edit
     * */
    public function edit($id)
    {
        $refrigerant = Refrigerant::where('id', $id)->whereNull('deleted_at')->first();
        return view('admin.refrigerant.create', compact('refrigerant'));
    }
    /*****
     * Refrigerant Update
     * */
    public function update(RefrigerantRequest $request, $id)
    {
        try {
            $refrigerant = Refrigerant::findOrFail($id);
            $refrigerant->emission = $request->emission;
            $refrigerant->type = $request->type;
            $refrigerant->unit = $request->unit;
            $refrigerant->factors = $request->factors;
            $refrigerant->update();
            if(Auth::guard('admin')->user()){
                $jsonCompanyhis = 'Updated activity "refrigerant"';
                $moduleid = 32;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Updated";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
            }
            $activity =  Activity::where('name','Refrigerants')->first();
            $companyIds = CompanyActivity::where('activity_id',$activity->id)->whereNull('deleted_at')->get()->pluck('company_id')->toArray();
            SampleSheetCreate::dispatch($activity,$companyIds);
            if ($refrigerant) {
                return redirect()->route('refrigerants.index')->with('success', 'Refrigerant is successfully updated.');
            } else {
                return redirect()->route('refrigerants.index')->with('error', 'An error occurred while updating refrigerant.');
            }
        } catch (Exception $e) {
            return redirect()->route('refrigerants.index')->with('error', $e->getMessage());
        }
        abort(404);
    }

    public function destroy($id)
    {
        try {
            $refrigerant = Refrigerant::findOrFail($id);
            if ($refrigerant->delete()) {
                $activity =  Activity::where('name','Refrigerants')->first();
                $companyIds = CompanyActivity::where('activity_id',$activity->id)->whereNull('deleted_at')->get()->pluck('company_id')->toArray();
                SampleSheetCreate::dispatch($activity,$companyIds);
                if(Auth::guard('admin')->user()){
                    $jsonCompanyhis = 'Deleted activity "refrigerant"';
                    $moduleid = 32;
                    $userId = Auth::guard('admin')->user()->id;
                    $action = "Deleted";
                    $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
                }
                return redirect()->route('refrigerants.index')->with('success', 'Refrigerant is successfully deleted.');
            }
            return redirect()->route('refrigerants.index')->with('error', 'An error occurred while deleting refrigerant.');
        } catch (Exception $e) {
            return redirect()->route('refrigerants.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
}
