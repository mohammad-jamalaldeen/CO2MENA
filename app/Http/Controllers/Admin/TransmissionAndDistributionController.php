<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TransmissionAndDistributionRequest;
use App\Jobs\SampleSheetCreate;
use App\Models\Activity;
use App\Models\Company;
use App\Models\CompanyActivity;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\TransmissionAndDistribution;
use Illuminate\Support\Facades\Auth;
use Exception;

class TransmissionAndDistributionController extends Controller
{
    /*****
     * View Index page 
     * */
    public function index(Request $request)
    {
        $userModel = Auth::guard('admin')->user();
        $unit = $request->unit;
        if ($request->ajax()) {
            $obj1 = TransmissionAndDistribution::whereNull('deleted_at');
            if(!empty($unit) && $unit !== '')
            {
                $obj1 = $obj1->where('unit', $unit);
            }
            $obj1 = $obj1->orderBy('id', 'desc')->get();
            return DataTables::of($obj1)->make(true);
        }
        return view('admin.transmission-and-distribution.list', compact('userModel'));
    }
    /*****
     * transmission-and-distribution create page
     * */
    public function create()
    {
        return view('admin.transmission-and-distribution.create');
    }
    /*****
     * transmission-and-distribution Store
     * */
    public function store(TransmissionAndDistributionRequest $request)
    {
        try {
            $transmission_and_distribution = new TransmissionAndDistribution();
            $transmission_and_distribution->activity = $request->activity;
            $transmission_and_distribution->unit = $request->unit;
            $transmission_and_distribution->factors = $request->factors;
            $transmission_and_distribution->save();
            if(Auth::guard('admin')->user()){
                $jsonCompanyhis = 'Created activity "transmission and distribution"';
                $moduleid = 19;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Created";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
            }
            if ($transmission_and_distribution) {
                return redirect()->route('transmission-and-distribution.index')->with('success', 'Transmission and distribution is successfully created.');
            } else {
                return redirect()->route('transmission-and-distribution.index')->with('error', 'An error occurred while creating transmission and distribution.');
            }
        } catch (Exception $e) {
            return redirect()->route('transmission-and-distribution.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
    /*****
     * transmission-and-distribution details page show
     * */
    public function show(Request $request, $id)
    {
        try {
            if (!empty($id)) {
                $transmission_and_distribution = TransmissionAndDistribution::where('id', $id)->whereNull('deleted_at')->first();
                return view('admin.transmission-and-distribution.show', compact('transmission_and_distribution'));
            }
        } catch (Exception $e) {
            return redirect()->route('transmission-and-distribution.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
    /*****
     * transmission-and-distribution details page edit
     * */
    public function edit($id)
    {
        $transmission_and_distribution = TransmissionAndDistribution::where('id', $id)->whereNull('deleted_at')->first();
        return view('admin.transmission-and-distribution.create', compact('transmission_and_distribution'));
    }
    /*****
     * transmission-and-distribution Update
     * */
    public function update(TransmissionAndDistributionRequest $request, $id)
    {
        try {
            $transmission_and_distribution = TransmissionAndDistribution::findOrFail($id);
            $transmission_and_distribution->activity = $request->activity;
            $transmission_and_distribution->unit = $request->unit;
            $transmission_and_distribution->factors = $request->factors;
            $transmission_and_distribution->update();
            if(Auth::guard('admin')->user()){
                $jsonCompanyhis = 'Updated activity "transmission and distribution"';
                $moduleid = 19;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Updated";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
            }
            $activity =  Activity::where('name','T&D')->first();
            $companyIds = CompanyActivity::where('activity_id',$activity->id)->get()->pluck('company_id')->toArray();
            SampleSheetCreate::dispatch($activity,$companyIds);
            if ($transmission_and_distribution) {
                return redirect()->route('transmission-and-distribution.index')->with('success', 'Transmission and distribution is successfully updated.');
            } else {
                return redirect()->route('transmission-and-distribution.index')->with('error', 'An error occurred while updating transmission and distribution.');
            }
        } catch (Exception $e) {
            return redirect()->route('transmission-and-distribution.index')->with('error', $e->getMessage());
        }
        abort(404);
    }

    public function destroy($id)
    {
        try {
            $transmission_and_distribution = TransmissionAndDistribution::findOrFail($id);
            if ($transmission_and_distribution->delete()) {
                $activity =  Activity::where('name','T&D')->first();
                if(Auth::guard('admin')->user()){
                    $jsonCompanyhis = 'Deleted activity "transmission and distribution"';
                    $moduleid = 19;
                    $userId = Auth::guard('admin')->user()->id;
                    $action = "Deleted";
                    $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
                }
                $companyIds = CompanyActivity::where('activity_id',$activity->id)->get()->pluck('company_id')->toArray();
                SampleSheetCreate::dispatch($activity,$companyIds);
                return redirect()->route('transmission-and-distribution.index')->with('success', 'Transmission and distribution is successfully deleted.');
            }
            return redirect()->route('transmission-and-distribution.index')->with('error', 'An error occurred while deleting transmission and distribution.');
        } catch (Exception $e) {
            return redirect()->route('transmission-and-distribution.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
}
