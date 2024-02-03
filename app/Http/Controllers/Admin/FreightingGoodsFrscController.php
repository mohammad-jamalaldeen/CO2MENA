<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SampleSheetCreate;
use App\Models\Activity;
use App\Models\Company;
use App\Models\CompanyActivity;
use App\Models\FreightingGoodsFlightsRails;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Facades\Auth;

class FreightingGoodsFrscController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $fgdata = FreightingGoodsFlightsRails::whereNull('deleted_at');

            if (isset($request->getvehicle)) {
                $fgdata->where('vehicle', $request->getvehicle);
            }

            if (isset($request->getunit)) {
                $fgdata->where('unit', $request->getunit);
            }
            
            $sortField = '';
            $sortOrder = '';
            if (empty($request->get('order')) && empty($request->get('order')[0]) && empty($request->get('order')[0]['column']) && empty($request->get('order')[0]['dir'])) {
                $fgdata->orderBy('created_at', 'DESC');
            } else {
                $sortField = $request->get('columns')[$request->get('order')[0]['column']]['name'];
                $sortOrder = strtoupper($request->get('order')[0]['dir']);
            }

            return DataTables::of($fgdata)->make(true);
        }
        return view('admin.freighting-goodsfr.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.freighting-goodsfr.create');
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
                'unit' => 'required|string',
                'factors' => 'required|numeric',
                // 'formula' => 'required|string',
                'distance' => 'required|string',
            ],
            ['factors'=>'The emission factor field must be a number.']
        );
        try {
            $fgstore = new FreightingGoodsFlightsRails();
            // $fgstore->row_id = $request->input('row_id');
            $fgstore->vehicle = $request->input('vehicle');
            $fgstore->type = $request->input('type');
            $fgstore->unit = $request->input('unit');
            $fgstore->factors = $request->input('factors');
            // $fgstore->formula = $request->input('formula');
            $fgstore->distance = $request->input('distance');
            $fgstore->save();
            if(Auth::guard('admin')->user()){
                $jsonCompanyhis = 'Created activity "freighting goods flights rails"';
                $moduleid = 29;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Created";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
            }
            return redirect()->route('freighting-goodsfr.index')->with([
                'success' => 'Freighting goods data is successfully added!'
            ]);
        } catch (Exception $e) {
            return redirect()->route('freighting-goodsfr.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $fgshow = FreightingGoodsFlightsRails::where('id', $id)->whereNull('deleted_at')->first();
        return view('admin.freighting-goodsfr.show', compact('fgshow'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $fgedit = FreightingGoodsFlightsRails::where('id', $id)->whereNull('deleted_at')->first();
        return view('admin.freighting-goodsfr.edit', compact('fgedit'));
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
                'unit' => 'required|string',
                'factors' => 'required|numeric',
                // 'formula' => 'required|string',
            ],
            ['factors'=>'The emission factor field must be a number.']
        );
        try {
            $empcomeditupdate = FreightingGoodsFlightsRails::findOrFail($id);
            // $empcomeditupdate->row_id = $request->input('row_id');
            $empcomeditupdate->vehicle = $request->input('vehicle');
            $empcomeditupdate->type = $request->input('type');
            $empcomeditupdate->unit = $request->input('unit');
            $empcomeditupdate->factors = $request->input('factors');
            // $empcomeditupdate->formula = $request->input('formula');
            if ($empcomeditupdate->save()) {
                $activity =  Activity::where('name','Freighting goods')->first();
                $companyIds = CompanyActivity::where('activity_id',$activity->id)->whereNull('deleted_at')->get()->pluck('company_id')->toArray();
                SampleSheetCreate::dispatch($activity,$companyIds);
                if(Auth::guard('admin')->user()){
                    $jsonCompanyhis = 'Updated activity "freighting goods flights rails"';
                    $moduleid = 29;
                    $userId = Auth::guard('admin')->user()->id;
                    $action = "Updated";
                    $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
                }
                return redirect()->route('freighting-goodsfr.index')->with('success', 'Freighting goods data is successfully updated.');
            }
        } catch (Exception $e) {
            return redirect()->route('freighting-goodsfr.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $fgdelete = FreightingGoodsFlightsRails::findOrFail($id);
            if ($fgdelete->delete()) {
                $activity =  Activity::where('name','Freighting goods')->first();
                $companyIds = CompanyActivity::where('activity_id',$activity->id)->whereNull('deleted_at')->get()->pluck('company_id')->toArray();
                SampleSheetCreate::dispatch($activity,$companyIds);
                if(Auth::guard('admin')->user()){
                    $jsonCompanyhis = 'Deleted activity "freighting goods flights rails"';
                    $moduleid = 29;
                    $userId = Auth::guard('admin')->user()->id;
                    $action = "Deleted";
                    $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
                }
                return redirect()->route('freighting-goodsfr.index')->with('success', 'Freighting goods data is successfully deleted.');
            }
        } catch (\Exception $e) {
            return redirect()->route('freighting-goodsfr.index')->with('error', $e->getMessage());
        }
    }
}
