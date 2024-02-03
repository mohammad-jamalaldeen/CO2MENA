<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WasteDisposalRequest;
use App\Jobs\SampleSheetCreate;
use App\Models\Activity;
use App\Models\CompanyActivity;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\WasteDisposal;
use Illuminate\Support\Facades\Auth;
use Exception;

class WasteDisposalController extends Controller
{
    /*****
     * Waste disposal Index page 
     * */
    public function index(Request $request)
    {
        $userModel = Auth::guard('admin')->user();
        if ($request->ajax()) {
            $obj1 = WasteDisposal::whereNull('deleted_at')->orderBy('id', 'desc');
            if(!empty($request->type) && $request->type != ""){
                $obj1->where('type' , $request->type);
            }
            $obj1 = $obj1->orderBy('id', 'desc')->get();
            return DataTables::of($obj1)->make(true);
        }
        return view('admin.waste-disposal.list', compact('userModel'));
    }
    /*****
     * Waste disposal create page
     * */
    public function create()
    {
        return view('admin.waste-disposal.create');
    }
    /*****
     * Waste disposal Store
     * */
    public function store(WasteDisposalRequest $request)
    {
        try {
            $waste_disposal = new WasteDisposal();
            $waste_disposal->waste_type = $request->waste_type;
            $waste_disposal->type = $request->type;
            $waste_disposal->factors = $request->factors;
            $waste_disposal->save();
            if (Auth::guard('admin')->user()) {
                $jsonCompanyhis = 'Created activity "waste disposal"';
                $moduleid = 22;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Created";
                $history = userHistoryManage($jsonCompanyhis, $moduleid, $userId, $action);
            }
            if ($waste_disposal) {
                return redirect()->route('waste-disposal.index')->with('success', 'Waste disposal is successfully created.');
            } else {
                return redirect()->route('waste-disposal.index')->with('error', 'An error occurred while creating waste disposal.');
            }
        } catch (Exception $e) {
            return redirect()->route('waste-disposal.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
    /*****
     * Waste disposal details page show
     * */
    public function show(Request $request, $id)
    {
        try {
            if (!empty($id)) {
                $waste_disposal = WasteDisposal::where('id', $id)->whereNull('deleted_at')->first();
                return view('admin.waste-disposal.show', compact('waste_disposal'));
            }
        } catch (Exception $e) {
            return redirect()->route('waste-disposal.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
    /*****
     * Waste disposal details page edit
     * */
    public function edit($id)
    {
        $waste_disposal = WasteDisposal::where('id', $id)->whereNull('deleted_at')->first();
        return view('admin.waste-disposal.create', compact('waste_disposal'));
    }
    /*****
     * Waste disposal Update
     * */
    public function update(WasteDisposalRequest $request, $id)
    {
        try {
            $waste_disposal = WasteDisposal::findOrFail($id);
            $waste_disposal->waste_type = $request->waste_type;
            $waste_disposal->type = $request->type;
            $waste_disposal->factors = $request->factors;
            $waste_disposal->update();
            if (Auth::guard('admin')->user()) {
                $jsonCompanyhis = 'Updated activity "waste disposal"';
                $moduleid = 22;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Updated";
                $history = userHistoryManage($jsonCompanyhis, $moduleid, $userId, $action);
            }
            $activity =  Activity::where('name', 'Waste disposal')->first();
            $companyIds = CompanyActivity::where('activity_id', $activity->id)->whereNull('deleted_at')->get()->pluck('company_id')->toArray();
            SampleSheetCreate::dispatch($activity, $companyIds);
            if ($waste_disposal) {
                return redirect()->route('waste-disposal.index')->with('success', 'Waste disposal is successfully updated.');
            } else {
                return redirect()->route('waste-disposal.index')->with('error', 'An error occurred while updating waste disposal.');
            }
        } catch (Exception $e) {
            return redirect()->route('waste-disposal.index')->with('error', $e->getMessage());
        }
        abort(404);
    }

    public function destroy($id)
    {
        try {
            $waste_disposal = WasteDisposal::findOrFail($id);
            if ($waste_disposal->delete()) {
                $activity =  Activity::where('name', 'Waste disposal')->first();
                $companyIds = CompanyActivity::where('activity_id', $activity->id)->whereNull('deleted_at')->get()->pluck('company_id')->toArray();
                SampleSheetCreate::dispatch($activity, $companyIds);
                if (Auth::guard('admin')->user()) {
                    $jsonCompanyhis = 'Deleted activity "waste disposal"';
                    $moduleid = 22;
                    $userId = Auth::guard('admin')->user()->id;
                    $action = "Deleted";
                    $history = userHistoryManage($jsonCompanyhis, $moduleid, $userId, $action);
                }
                return redirect()->route('waste-disposal.index')->with('success', 'Waste disposal is successfully deleted.');
            }
            return redirect()->route('waste-disposal.index')->with('error', 'An error occurred while deleting waste disposal.');
        } catch (Exception $e) {
            return redirect()->route('waste-disposal.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
}
