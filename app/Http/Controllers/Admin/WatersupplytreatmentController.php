<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WatersupplytreatmentRequest;
use App\Jobs\SampleSheetCreate;
use App\Models\Activity;
use App\Models\CompanyActivity;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\Watersupplytreatment;
use Illuminate\Support\Facades\Auth;
use Exception;

class WatersupplytreatmentController extends Controller
{
    /*****
     * View Index page 
     * */
    public function index(Request $request)
    {
        $userModel = Auth::guard('admin')->user();
        $unit = $request->unit;
        $type = $request->type;
        if ($request->ajax()) {
            $obj1 = Watersupplytreatment::whereNull('deleted_at');
            if (!empty($type) && $type !== '') {
                $obj1 = $obj1->where('type', $type);
            }
            if (!empty($unit) && $unit !== '') {
                $obj1 = $obj1->where('unit', $unit);
            }
            $obj1 = $obj1->orderBy('id', 'desc')->get();
            return DataTables::of($obj1)->make(true);
        }
        return view('admin.water-supply-treatment.list', compact('userModel'));
    }

    /*****
     * water-supply-treatment create page
     * */
    public function create()
    {
        return view('admin.water-supply-treatment.create');
    }
    /*****
     * water-supply-treatment Store
     * */
    public function store(WatersupplytreatmentRequest $request)
    {
        try {
            $watersupplytreatment = new Watersupplytreatment();
            $watersupplytreatment->type = $request->type;
            $watersupplytreatment->unit = $request->unit;
            $watersupplytreatment->factors = $request->factors;
            $watersupplytreatment->save();
            if(Auth::guard('admin')->user()){
                $jsonCompanyhis = 'Created activity "Water supply treatment"';
                $moduleid = 20;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Created";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
            }
            if ($watersupplytreatment) {
                return redirect()->route('water-supply-treatment.index')->with('success', 'Water supply treatment is successfully created.');
            } else {
                return redirect()->route('water-supply-treatment.index')->with('error', 'An error occurred while creating water supply treatment.');
            }
        } catch (Exception $e) {
            return redirect()->route('water-supply-treatment.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
    /*****
     * water-supply-treatment details page show
     * */
    public function show(Request $request, $id)
    {
        try {
            if (!empty($id)) {
                $watersupplytreatment = Watersupplytreatment::where('id', $id)->whereNull('deleted_at')->first();
                return view('admin.water-supply-treatment.show', compact('watersupplytreatment'));
            }
        } catch (Exception $e) {
            return redirect()->route('water-supply-treatment.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
    /*****
     * water-supply-treatment details page edit
     * */
    public function edit($id)
    {
        $watersupplytreatment = Watersupplytreatment::where('id', $id)->whereNull('deleted_at')->first();
        return view('admin.water-supply-treatment.create', compact('watersupplytreatment'));
    }
    /*****
     * water-supply-treatment Update
     * */
    public function update(WatersupplytreatmentRequest $request, $id)
    {
        try {
            $watersupplytreatment = Watersupplytreatment::findOrFail($id);
            $watersupplytreatment->type = $request->type;
            $watersupplytreatment->unit = $request->unit;
            $watersupplytreatment->factors = $request->factors;
            $watersupplytreatment->update();
            if(Auth::guard('admin')->user()){
                $jsonCompanyhis = 'Updated activity "water supply treatment"';
                $moduleid = 20;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Updated";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
            }
            if ($watersupplytreatment) {
                $activity =  Activity::where('name', 'Water')->first();
                $companyIds = CompanyActivity::where('activity_id',$activity->id)->whereNull('deleted_at')->get()->pluck('company_id')->toArray();
                SampleSheetCreate::dispatch($activity,$companyIds);
                return redirect()->route('water-supply-treatment.index')->with('success', 'Water supply treatment is successfully updated.');
            } else {
                return redirect()->route('water-supply-treatment.index')->with('error', 'An error occurred while updating water supply treatment.');
            }
        } catch (Exception $e) {
            return redirect()->route('water-supply-treatment.index')->with('error', $e->getMessage());
        }
        abort(404);
    }

    public function destroy($id)
    {
        try {
            $watersupplytreatment = Watersupplytreatment::findOrFail($id);
            if ($watersupplytreatment->delete()) {
                $activity =  Activity::where('name', 'Water')->first();
                $companyIds = CompanyActivity::where('activity_id',$activity->id)->whereNull('deleted_at')->get()->pluck('company_id')->toArray();
                SampleSheetCreate::dispatch($activity,$companyIds);
                if(Auth::guard('admin')->user()){
                    $jsonCompanyhis = 'Deleted activity "water supply treatment"';
                    $moduleid = 20;
                    $userId = Auth::guard('admin')->user()->id;
                    $action = "Deleted";
                    $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
                }
                return redirect()->route('water-supply-treatment.index')->with('success', 'Water supply treatment is successfully deleted.');
            }
            return redirect()->route('water-supply-treatment.index')->with('error', 'An error occurred while deleting water supply treatment.');
        } catch (Exception $e) {
            return redirect()->route('water-supply-treatment.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
}
