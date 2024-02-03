<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FlightRequest;
use App\Jobs\SampleSheetCreate;
use App\Models\Activity;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\Flight;
use App\Models\City;
use App\Models\CompanyActivity;
use Illuminate\Support\Facades\Auth;
use Exception;

class FightsController extends Controller
{
    /*****
     * View Index page 
     * */
    public function index(Request $request)
    {
        $userModel = Auth::guard('admin')->user();
        $cities = City::all();
        $class = $request->class;
        $city = $request->city;
        $single_way_and_return = $request->single_way_and_return;
        if ($request->ajax()) {
            $obj1 = Flight::with(['origin', 'destination'])->whereNull('deleted_at');
            if(!empty($class) && $class !== '')
            {
                $obj1 = $obj1->where('class', $class);
            }
            if(!empty($single_way_and_return) && $single_way_and_return !== '')
            {
                $obj1 = $obj1->where('single_way_and_return', $single_way_and_return);
            }
            if (!empty($city)) {
                $obj1 = $obj1->where(function($q) use ($city) {
                    $q->whereHas('origin', function($q) use ($city) {
                        $q->where('id', $city);
                    })->orWhereHas('destination', function($q) use ($city) {
                        $q->where('id', $city);
                    });
                });
            }  
            $obj1 = $obj1 ->orderBy('flights.id', 'desc')->get();
            return DataTables::of($obj1)->make(true);
        }
        return view('admin.flight.list', compact('userModel','cities'));
    }
    /*****
     * Flight create page
     * */
    public function create()
    {
        $cities = City::whereNull('deleted_at')->get();
        return view('admin.flight.create', compact('cities'));
    }
    /*****
     * Flight Store
     * */
    public function store(FlightRequest $request)
    {
        try {
            $flight = new Flight();
            $flight->origin = $request->origin;
            $flight->destination = $request->destination;
            $flight->distance = $request->distance;
            $flight->class = $request->class;
            $flight->single_way_and_return = $request->single_way_and_return;
            if(Auth::guard('admin')->user()){
                $jsonCompanyhis = 'Created activity "flight"';
                $moduleid = 24;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Created";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
            }
            $flight->save();
            if ($flight) {
                return redirect()->route('flight.index')->with('success', 'Flight is successfully created.');
            } else {
                return redirect()->route('flight.index')->with('error', 'An error occurred while creating flight.');
            }
        } catch (Exception $e) {
            return redirect()->route('flight.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
    /*****
     * flight details page show
     * */
    public function show(Request $request, $id)
    {
        try {
            if (!empty($id)) {
                $cities = City::whereNull('deleted_at')->get();
                $flight = Flight::where('id', $id)->whereNull('deleted_at')->first();
                return view('admin.flight.show', compact('flight','cities'));
            }
        } catch (Exception $e) {
            return redirect()->route('flight.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
    /*****
     * flight details page edit
     * */
    public function edit($id)
    {
        $cities = City::whereNull('deleted_at')->get();
        $flight = Flight::where('id', $id)->whereNull('deleted_at')->first();
        return view('admin.flight.create', compact('flight', 'cities'));
    }
    /*****
     * flight Update
     * */
    public function update(FlightRequest $request, $id)
    {
        try {
            $flight = Flight::findOrFail($id);
            $flight->origin = $request->origin;
            $flight->distance = $request->distance;
            $flight->destination = $request->destination;
            $flight->class = $request->class;
            $flight->single_way_and_return = $request->single_way_and_return;
            if(Auth::guard('admin')->user()){
                $jsonCompanyhis = 'Updated activity "flight"';
                $moduleid = 24;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Updated";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
            }
            $flight->update();
            $activity =  Activity::where('name','Flight and Accommodation')->first();
            $companyIds = CompanyActivity::where('activity_id',$activity->id)->whereNull('deleted_at')->get()->pluck('company_id')->toArray();
            SampleSheetCreate::dispatch($activity,$companyIds);
            if ($flight) {
                return redirect()->route('flight.index')->with('success', 'Flight is successfully updated.');
            } else {
                return redirect()->route('flight.index')->with('error', 'An error occurred while updating flight.');
            }
        } catch (Exception $e) {
            return redirect()->route('flight.index')->with('error', $e->getMessage());
        }
        abort(404);
    }

    public function destroy($id)
    {
        try {
            $flight = Flight::findOrFail($id);
            if ($flight->delete()) {
                $activity =  Activity::where('name','Flight and Accommodation')->first();
                $companyIds = CompanyActivity::where('activity_id',$activity->id)->whereNull('deleted_at')->get()->pluck('company_id')->toArray();
                SampleSheetCreate::dispatch($activity,$companyIds);
                if(Auth::guard('admin')->user()){
                    $jsonCompanyhis = 'Deleted activity "flight"';
                    $moduleid = 24;
                    $userId = Auth::guard('admin')->user()->id;
                    $action = "Deleted";
                    $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
                }
                return redirect()->route('flight.index')->with('success', 'Flight is successfully deleted.');
            }
            return redirect()->route('flight.index')->with('error', 'An error occurred while deleting flight.');
        } catch (Exception $e) {
            return redirect()->route('flight.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
}
