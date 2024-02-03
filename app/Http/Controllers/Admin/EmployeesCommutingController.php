<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SampleSheetCreate;
use App\Models\Activity;
use App\Models\Company;
use App\Models\CompanyActivity;
use App\Models\EmployeesCommuting;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Facades\Auth;

class EmployeesCommutingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $empcomdata = EmployeesCommuting::whereNull('deleted_at');

            if (isset($request->getvehicle)) {
                $empcomdata->where('vehicle', $request->getvehicle);
            }

            if (isset($request->gettype)) {
                $empcomdata->where('type', $request->gettype);
            }

            if (isset($request->getfuel)) {
                $empcomdata->where('fuel', $request->getfuel);
            }

            if (isset($request->getunit)) {
                $empcomdata->where('unit', $request->getunit);
            }

            $sortField = '';
            $sortOrder = '';
            if (empty($request->get('order')) && empty($request->get('order')[0]) && empty($request->get('order')[0]['column']) && empty($request->get('order')[0]['dir'])) {
                $empcomdata->orderBy('created_at', 'DESC');
            } else {
                $sortField = $request->get('columns')[$request->get('order')[0]['column']]['name'];
                $sortOrder = strtoupper($request->get('order')[0]['dir']);
            }

            return DataTables::of($empcomdata)->make(true);
        }

        return view('admin.employees-commuting.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.employees-commuting.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                // 'row_id' => 'required|int',
                'vehicle' => 'required|string',
                'type' => 'required|string',
                'fuel' => 'required|string',
                'unit' => 'required|string',
                'factors' => 'required|numeric',
                // 'formula' => 'required|string',
            ]
        );
        try {
            $empcomstore = new EmployeesCommuting();
            // $empcomstore->row_id = $request->input('row_id');
            $empcomstore->vehicle = $request->input('vehicle');
            $empcomstore->type = $request->input('type');
            $empcomstore->fuel = $request->input('fuel');
            $empcomstore->unit = $request->input('unit');
            $empcomstore->factors = $request->input('factors');
            $empcomstore->total_distance = $request->input('total_distance');
            // $empcomstore->formula = $request->input('formula');
            $empcomstore->save();
            if(Auth::guard('admin')->user()){
                $jsonCompanyhis = 'Created activity "employees commuting"';
                $moduleid = 27;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Created";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
            }
            return redirect()->route('employees-commuting.index')->with([
                'success' => 'Employees commuting data is successfully added.'
            ]);
        } catch (Exception $e) {
            return redirect()->route('employees-commuting.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $empcomshow = EmployeesCommuting::where('id', $id)->whereNull('deleted_at')->first();
        return view('admin.employees-commuting.show', compact('empcomshow'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $empcomedit = EmployeesCommuting::where('id', $id)->whereNull('deleted_at')->first();
        return view('admin.employees-commuting.edit', compact('empcomedit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                // 'row_id' => 'required|int',
                'vehicle' => 'required|string',
                'type' => 'required|string',
                'fuel' => 'required|string',
                'unit' => 'required|string',
                'factors' => 'required|numeric',
                // 'formula' => 'required|string',
            ]
        );
        try {
            $empcomeditupdate = EmployeesCommuting::findOrFail($id);
            // $empcomeditupdate->row_id = $request->input('row_id');
            $empcomeditupdate->vehicle = $request->input('vehicle');
            $empcomeditupdate->type = $request->input('type');
            $empcomeditupdate->fuel = $request->input('fuel');
            $empcomeditupdate->unit = $request->input('unit');
            $empcomeditupdate->factors = $request->input('factors');
            // $empcomeditupdate->formula = $request->input('formula');
            if ($empcomeditupdate->save()) {
                $activity =  Activity::where('name','Employees commuting')->first();
                $companyIds = CompanyActivity::where('activity_id',$activity->id)->whereNull('deleted_at')->get()->pluck('company_id')->toArray();
                SampleSheetCreate::dispatch($activity,$companyIds);
                if(Auth::guard('admin')->user()){
                    $jsonCompanyhis = 'Updated activity "employees commuting"';
                    $moduleid = 27;
                    $userId = Auth::guard('admin')->user()->id;
                    $action = "Updated";
                    $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
                }
                return redirect()->route('employees-commuting.index')->with('success', 'Employees commuting data is successfully updated.');
            }
        } catch (Exception $e) {
            return redirect()->route('employees-commuting.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $empcomdelete = EmployeesCommuting::findOrFail($id);
            if ($empcomdelete->delete()) {
                $activity =  Activity::where('name','Employees commuting')->first();
                $companyIds = CompanyActivity::where('activity_id',$activity->id)->whereNull('deleted_at')->get()->pluck('company_id')->toArray();
                SampleSheetCreate::dispatch($activity,$companyIds);
                if(Auth::guard('admin')->user()){
                    $jsonCompanyhis = 'Deleted activity "employees commuting"';
                    $moduleid = 27;
                    $userId = Auth::guard('admin')->user()->id;
                    $action = "Deleted";
                    $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
                }
                return redirect()->route('employees-commuting.index')->with('success', 'Employees commuting is successfully deleted.');
            }
        } catch (\Exception $e) {
            return redirect()->route('employees-commuting.index')->with('error', $e->getMessage());
        }
    }
}
