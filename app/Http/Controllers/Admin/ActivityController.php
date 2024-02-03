<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;
use Yajra\DataTables\DataTables;

class ActivityController extends Controller
{
    /*
     ** list of Emission Factors
    */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $Scope = Activity::leftJoin('users', function ($join) {
                $join->on('activities.last_updated_by', '=', 'users.id');
            })->whereNull('activities.deleted_at')->select('activities.*', 'users.name as Username');

            $sortField = '';
            $sortOrder = '';
            if (empty($request->get('order')) && empty($request->get('order')[0]) && empty($request->get('order')[0]['column']) && empty($request->get('order')[0]['dir'])) {
                $Scope->orderBy('activities.created_at', 'DESC');
            } else {
                $sortField = $request->get('columns')[$request->get('order')[0]['column']]['name'];
                $sortOrder = strtoupper($request->get('order')[0]['dir']);
            }
            return DataTables::of($Scope)->make(true);
        }
        return view('admin.emission-factors.list');
    }
    /*
     ** create Emission Factors form
    */
    public function create(Request $request)
    {
        do {
            $randomNumericString = generateRandomString(8);
        } while (Activity::where('no', $randomNumericString)->exists());
        return view('admin.emission-factors.create', compact('randomNumericString'));
    }

    /*
     ** store sub admin 
    */
    public function store(Request $request)
    {

        $request->validate(
            [
                'name' => 'required|string',
            ]
        );

        try {
            $scope = new Activity();
            $scope->no = $request->input('no');
            $scope->name = $request->input('name');
            $scope->user_id = Auth::guard('admin')->user()->id;
            $scope->last_updated_by = Auth::guard('admin')->user()->id;
            $scope->ip_address = $request->ip();
            $scope->save();
            if (Auth::guard('admin')->user()) {
                $jsonCompanyhis = 'Created Emission factor (' . $scope->name . ')';
                $moduleid = 12;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Created";
                $history = userHistoryManage($jsonCompanyhis, $moduleid, $userId, $action);
            }
            return redirect()->route('emission-factors.index')->with([
                'success' => 'Emission factor added successfully!'
            ]);
        } catch (Exception $e) {
            return redirect()->route('emission-factors.index')->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $scope = Activity::where('id', $id)->whereNull('deleted_at')->first();
        $user = User::find($scope->last_updated_by);
        return view('admin.emission-factors.show', compact('scope', 'user'));
    }
    public function edit($id)
    {
        $scope = Activity::where('id', $id)->whereNull('deleted_at')->first();
        return view('admin.emission-factors.edit', compact('scope'));
    }
    /**
     * Emission Factors Update
     */

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string',
            ]
        );
        try {
            $scope = Activity::findOrFail($id);
            $scope->name = $request->input('name');
            $scope->last_updated_by = Auth::guard('admin')->user()->id;
            if (Auth::guard('admin')->user()) {
                $jsonCompanyhis ='Updated Emission factor (' . $scope->name . ')';
                $moduleid = 12;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Updated";
                $history = userHistoryManage($jsonCompanyhis, $moduleid, $userId, $action);
            }
            if ($scope->save()) {
                return redirect()->route('emission-factors.index')->with('success', 'Emission factor is successfully updated.');
            }
        } catch (Exception $e) {
            return redirect()->route('emission-factors.index')->with('error', $e->getMessage());
        }

        return redirect()->route('emission-factors.index')->with('error', 'An error occurred while updating emission factor.');
    }

    /**
     * Delete Emission Factors
     */

    public function destroy($id)
    {
        try {
            $scope = Activity::findOrFail($id);
            if ($scope->delete()) {
                if (Auth::guard('admin')->user()) {
                    $jsonCompanyhis = 'Deleted Emission factor (' . $scope->name . ')';
                    $moduleid = 12;
                    $userId = Auth::guard('admin')->user()->id;
                    $action = "Deleted";
                    $history = userHistoryManage($jsonCompanyhis, $moduleid, $userId, $action);
                }
                return redirect()->route('emission-factors.index')->with('success', 'Emission factor is successfully deleted.');
            }
        } catch (Exception $e) {
            return redirect()->route('emission-factors.index')->with('error', $e->getMessage());
        }
    }
}
