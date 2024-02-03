<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MaterialUseRequest;
use App\Jobs\SampleSheetCreate;
use App\Models\Activity;
use App\Models\Company;
use App\Models\CompanyActivity;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\MaterialUse;
use Illuminate\Support\Facades\Auth;
use Exception;

class MaterialUseController extends Controller
{
    /*****
     * View Index page 
     * */
    public function index(Request $request)
    {
        //return view('admin.material-use.list');
        $userModel = Auth::guard('admin')->user();
        $activity = $request->activity;
        if ($request->ajax()) {
            $obj1 = MaterialUse::whereNull('deleted_at');
            if(!empty($activity) && $activity !== '')
            {
                $obj1 = $obj1->where('activity', $activity);
            }
            $obj1 = $obj1->orderBy('id', 'desc')->get();
            return DataTables::of($obj1)->make(true);
        }
        return view('admin.material-use.list', compact('userModel'));
    }
    /*****
     * fuels create page
     * */
    public function create()
    {
        return view('admin.material-use.create');
    }
    /*****
     * fuels Store
     * */
    public function store(MaterialUseRequest $request)
    {
        try {
            $material_use = new MaterialUse();
            $material_use->row_id = $request->row_id;
            $material_use->activity = $request->activity;
            $material_use->waste_type = $request->waste_type;
            $material_use->factors = $request->factors;
            $material_use->formula = $request->formula;
            $material_use->save();
            if(Auth::guard('admin')->user()){
                $jsonCompanyhis = 'Created activity "material use"';
                $moduleid = 21;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Created";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
            }
            if ($material_use) {
                return redirect()->route('material-use.index')->with('success', 'Material use is successfully created.');
            } else {
                return redirect()->route('material-use.index')->with('error', 'An error occurred while creating material use.');
            }
        } catch (Exception $e) {
            return redirect()->route('material-use.index')->with('error', $e->getMessage());
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
                $material_use = MaterialUse::where('id', $id)->whereNull('deleted_at')->first();
                return view('admin.material-use.show', compact('material_use'));
            }
        } catch (Exception $e) {
            return redirect()->route('material-use.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
    /*****
     * fuels details page edit
     * */
    public function edit($id)
    {
        $material_use = MaterialUse::where('id', $id)->whereNull('deleted_at')->first();
        return view('admin.material-use.create', compact('material_use'));
    }
    /*****
     * fuels Update
     * */
    public function update(MaterialUseRequest $request, $id)
    {
        
        try {
            
            $material_use = MaterialUse::findOrFail($id);
            $material_use->row_id = $request->row_id;
            $material_use->activity = $request->activity;
            $material_use->waste_type = $request->waste_type;
            $material_use->factors = $request->factors;
            $material_use->formula = $request->formula;
            $material_use->update();
            if(Auth::guard('admin')->user()){
                $jsonCompanyhis = 'Updated activity "material use"';
                $moduleid = 21;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Updated";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
            }
            $activity =  Activity::where('name','Material use')->first();
            $companyIds = CompanyActivity::where('activity_id',$activity->id)->whereNull('deleted_at')->get()->pluck('company_id')->toArray();
            SampleSheetCreate::dispatch($activity,$companyIds);

            if ($material_use) {
                
                return redirect()->route('material-use.index')->with('success', 'Material use is successfully updated.');
            } else {
                return redirect()->route('material-use.index')->with('error', 'An error occurred while updating material use.');
            }
        } catch (Exception $e) {
            return redirect()->route('material-use.index')->with('error', $e->getMessage());
        }
        abort(404);
    }

    public function destroy($id)
    {
        try {
            $material_use = MaterialUse::findOrFail($id);
            if ($material_use->delete()) {
                $activity =  Activity::where('name','Material use')->first();
                $companyIds = CompanyActivity::where('activity_id',$activity->id)->whereNull('deleted_at')->get()->pluck('company_id')->toArray();
                SampleSheetCreate::dispatch($activity,$companyIds);
                if(Auth::guard('admin')->user()){
                    $jsonCompanyhis = 'Deleted activity "material use"';
                    $moduleid = 21;
                    $userId = Auth::guard('admin')->user()->id;
                    $action = "Deleted";
                    $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
                }
                return redirect()->route('material-use.index')->with('success', 'Material use is successfully deleted.');
            }
            return redirect()->route('material-use.index')->with('error', 'An error occurred while deleting material use.');
        } catch (Exception $e) {
            return redirect()->route('material-use.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
}
