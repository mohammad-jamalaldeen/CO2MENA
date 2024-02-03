<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VehicleRequest;
use App\Jobs\SampleSheetCreate;
use App\Models\Activity;
use App\Models\Company;
use App\Models\CompanyActivity;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Exception;

class VehiclesController extends Controller
{
    /*****
     * vehicles Index page 
     * */
    public function index(Request $request)
    {
        $userModel = Auth::guard('admin')->user();

        $vehicle_type = $request->vehicle_type;
        $vehicle = $request->vehicle;
        $vehicle1 = $request->vehicle1;
        $type = $request->type;
        $type1 = $request->type1;
        $fuel = $request->fuel;
        $fuel1 = $request->fuel1;
        if ($request->ajax()) {
            $obj1 = Vehicle::whereNull('deleted_at');
            if (!empty($vehicle_type) && $vehicle_type !== '') {
                $obj1 = $obj1->where('vehicle_type', $vehicle_type);
            }
            if (!empty($vehicle) && $vehicle !== '') {
                $obj1 = $obj1->where('vehicle', $vehicle);
            }
            if (!empty($vehicle1) && $vehicle1 !== '') {
                $obj1 = $obj1->where('vehicle', $vehicle1);
            }
            if (!empty($type) && $type !== '') {
                $obj1 = $obj1->where('type', $type);
            }
            if (!empty($type1) && $type1 !== '') {
                $obj1 = $obj1->where('type', $type1);
            }
            if (!empty($fuel) && $fuel !== '') {
                $obj1 = $obj1->where('fuel', $fuel);
            }
            if (!empty($fuel1) && $fuel1 !== '') {
                $obj1 = $obj1->where('fuel', $fuel1);
            }
            $obj1 = $obj1->orderBy('id', 'desc')->get();
            return DataTables::of($obj1)->make(true);
        }
        return view('admin.vehicles.list', compact('userModel'));
    }


    /*****
     * vehicles create page
     * */
    public function create()
    {
        return view('admin.vehicles.create');
    }
    /*****
     * vehicle Store
     * */
    public function store(VehicleRequest $request)
    {
        try {
            $vehicles = new Vehicle();
            $vehicles->vehicle = $request->vehicle;
            $vehicles->type = $request->type;
            $vehicles->fuel = $request->fuel;
            $vehicles->factors = $request->factors;
            $vehicles->distance = $request->distance;
            $vehicles->vehicle_type = $request->vehicle_type;
            $vehicles->save();
            if(Auth::guard('admin')->user()){
                $jsonCompanyhis = 'Created activity "vehicle"';
                $moduleid = 17;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Created";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
            }
            if ($vehicles) {
                return redirect()->route('vehicles.index')->with('success', 'Vehicle is successfully created.');
            } else {
                return redirect()->route('vehicles.index')->with('error', 'An error occurred while creating vehicle.');
            }
        } catch (Exception $e) {
            return redirect()->route('vehicles.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
    /*****
     * vehicles details page show
     * */
    public function show(Request $request, $id)
    {
        try {
            if (!empty($id)) {
                $vehicles = Vehicle::where('id', $id)->whereNull('deleted_at')->first();
                return view('admin.vehicles.show', compact('vehicles'));
            }
        } catch (Exception $e) {
            return redirect()->route('vehicles.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
    /*****
     * vehicle details page edit
     * */
    public function edit($id)
    {
        $vehicles = Vehicle::where('id', $id)->whereNull('deleted_at')->first();
        return view('admin.vehicles.create', compact('vehicles'));
    }
    /*****
     * vehicles Update
     * */
    public function update(VehicleRequest $request, $id)
    {
        try {
            $vehicles = Vehicle::findOrFail($id);
            $vehicles->vehicle = $request->vehicle;
            $vehicles->type = $request->type;
            $vehicles->fuel = $request->fuel;
            $vehicles->factors = $request->factors;
            $vehicles->distance = $request->distance;
            $vehicles->vehicle_type = $request->vehicle_type;
            $vehicles->update();
            if(Auth::guard('admin')->user()){
                $jsonCompanyhis = 'Updated activity "vehicle"';
                $moduleid = 17;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Updated";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
            }
            $activity =  Activity::where('name','Owned vehicles')->first();
            $companyIds = CompanyActivity::where('activity_id',$activity->id)->whereNull('deleted_at')->get()->pluck('company_id')->toArray();
            SampleSheetCreate::dispatch($activity,$companyIds);
            if ($vehicles) {
                return redirect()->route('vehicles.index')->with('success', 'Vehicle is successfully updated.');
            } else {
                return redirect()->route('vehicles.index')->with('error', 'An error occurred while updating vehicle.');
            }
        } catch (Exception $e) {
            return redirect()->route('vehicles.index')->with('error', $e->getMessage());
        }
        abort(404);
    }

    public function destroy($id)
    {
        try {
            $vehicles = Vehicle::findOrFail($id);
            if ($vehicles->delete()) {
                $activity =  Activity::where('name','Owned vehicles')->first();
                $companyIds = CompanyActivity::where('activity_id',$activity->id)->whereNull('deleted_at')->get()->pluck('company_id')->toArray();
                SampleSheetCreate::dispatch($activity,$companyIds);
                if(Auth::guard('admin')->user()){
                    $jsonCompanyhis = 'Deleted activity "vehicle"';
                    $moduleid = 17;
                    $userId = Auth::guard('admin')->user()->id;
                    $action = "Deleted";
                    $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
                }
                return redirect()->route('vehicles.index')->with('success', 'Vehicle is successfully deleted.');
            }
            return redirect()->route('vehicles.index')->with('error', 'An error occurred while deleting vehicle.');
        } catch (Exception $e) {
            return redirect()->route('vehicles.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
}
