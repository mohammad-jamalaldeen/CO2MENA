<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Datasheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class ManageDatasheetsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $datasheets = Datasheet::all();
        $filterLastAction = [];
        foreach ($datasheets as $items) {
            if (!in_array($items->last_action_by, $filterLastAction)) {
                $filterLastAction[] = $items->last_action_by;
            }
        }
        if($request->ajax()){
            $statusFilter = $request->input('getstatus');
            $dateTimeFilter = $request->input('getdatetime');
            $getlastaction = $request->input('getlastaction');
            $company = $request->input('company_filter');
    
            $datasheets = Datasheet::with('company')->whereNull('deleted_at');
            if($request->input('draw') == 1)
            {
                $datasheets = $datasheets->orderByDesc('id');
            }
    
            if ($statusFilter !== null) {
                $datasheets->where('status', $statusFilter);
            }
    
            if($company != "" && !empty($company)){
                $datasheets->where('company_id', $company);
            }
            if ($getlastaction !== null) {
                $datasheets->where('last_action_by', $getlastaction);
            }
    
            if ($dateTimeFilter !== null) {
                $dateTime = strtotime(str_replace('T', ' ', $dateTimeFilter));
                $hourMinuteFilter = date('H:i', $dateTime);
    
                $datasheets->whereRaw('TIME_FORMAT(date_time, "%H:%i") = ?', [$hourMinuteFilter]);
            }

            if (isset($request->viewreportingDate_filter)) {
                $reporting_date = $request->viewreportingDate_filter;
                $dateRangeArray = explode(' to ', $reporting_date);
                if (count($dateRangeArray) == 1) {
                    $startDate = $dateRangeArray[0];
                    $reporting_start_date = date('Y-m-d', strtotime($startDate));
                    $datasheets->where(DB::raw('DATE(reporting_start_date)'), $reporting_start_date);
                } else if (count($dateRangeArray) == 2) {
                    $startDate = $dateRangeArray[0];
                    $endDate = $dateRangeArray[1];
                    $reporting_start_date = date('Y-m-d', strtotime($startDate));
                    $reporting_end_date = date('Y-m-d', strtotime($endDate));
                    $datasheets->where(DB::raw('DATE(reporting_start_date)'), $reporting_start_date)->where(DB::raw('DATE(reporting_end_date)'), $reporting_end_date);
                } else {
                    $datasheets;
                }
            } else {
                $datasheets;
            }
    
            return DataTables::of($datasheets)
                ->addIndexColumn()
                ->editColumn('date_time', function ($row) {
                    return date('M d, Y H:i', strtotime($row->date_time));
                    // return convertToDubaiTimezone($row->date_time);
                })->editColumn('reporting_start_date', function ($row) {
                    $start_date = date('d/m/Y', strtotime($row->reporting_start_date));
                    $end_date = date('d/m/Y', strtotime($row->reporting_end_date));
                    return $start_date . ' - ' . $end_date;
                })
                ->rawColumns(['date_time', 'reporting_start_date'])->make(true);
        }
        $companies = Company::whereNull('deleted_at')->where('is_draft','0')->orderBy('company_name','asc')->get()->toArray();
        return view('admin.datasheets.index', compact('datasheets', 'filterLastAction', 'companies'));
    }

    public function ajaxlist(Request $request)
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $get_details = Datasheet::with(['company'])->where('id', $id)->whereNull('deleted_at')->first();
        return view('admin.datasheets.show', compact('get_details'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function uplodedSheet($id)
    {
        $datasheet = Datasheet::find($id);

        if (!$datasheet) {
            abort(404);
        }
        $uplodedSheetPath = $datasheet->uploded_sheet;

        if (!$uplodedSheetPath || !Storage::disk('datasheet')->exists($uplodedSheetPath)) {
            abort(404);
        }
        return response()->file(storage_path('app/public/uploads/datasheets/' . $uplodedSheetPath));
    }

    public function emissionCalculated($id)
    {
        $datasheet = Datasheet::find($id);

        if (!$datasheet) {
            abort(404);
        }
        $emissionCalculatedPath = $datasheet->emission_calculated;

        if (!$emissionCalculatedPath || !Storage::disk('datasheet')->exists($emissionCalculatedPath)) {
            abort(404);
        }
        return response()->file(storage_path('app/public/uploads/datasheets/' . $emissionCalculatedPath));
    }
}
