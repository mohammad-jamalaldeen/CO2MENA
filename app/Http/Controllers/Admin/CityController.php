<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\City;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Validation\Rule;

class CityController extends Controller
{
    /*****
     * View Index page 
     * */
    public function index(Request $request)
    {
        $userModel = Auth::guard('admin')->user();
        if ($request->ajax()) {
            $obj1 = City::whereNull('deleted_at')
            ->orderBy('id', 'desc')
            ->get();
            
            return DataTables::of($obj1)->make(true);
        }
        return view('admin.city.list', compact('userModel'));
    }
    /*****
     * city create page
     * */
    public function create()
    {
        return view('admin.city.create');
    }
    /*****
     * city Store
     * */
    public function store(Request $request)
    {
        $request->validate(
            ['name' => 'required|min:3|unique:cities,name'],
            ['name'=>'The city field is required.']
        );
        try {
            $city = new City();
            $city->name = $request->name;
            $city->save();
            if(Auth::guard('admin')->user()){
                $jsonCompanyhis = 'Created city';
                $moduleid = 25;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Created";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
            }
            if ($city) {
                return redirect()->route('city.index')->with('success', 'City is successfully created.');
            } else {
                return redirect()->route('city.index')->with('error', 'An error occurred while creating city.');
            }
        } catch (Exception $e) {
            return redirect()->route('city.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
    /*****
     * city details page show
     * */
    public function show(Request $request, $id)
    {
        try {
            if (!empty($id)) {
                $city = City::where('id', $id)->whereNull('deleted_at')->first();
                return view('admin.city.show', compact('city'));
            }
        } catch (Exception $e) {
            return redirect()->route('city.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
    /*****
     * city details page edit
     * */
    public function edit($id)
    {
        $city = City::where('id', $id)->whereNull('deleted_at')->first();
        return view('admin.city.create', compact('city'));
    }
    /*****
     * city Update
     * */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3|unique:cities,name,' . $id,
        ]);
        try {
            $city = City::findOrFail($id);
            $city->name = $request->name;
            $city->update();
            if(Auth::guard('admin')->user()){
                $jsonCompanyhis = 'Updated city';
                $moduleid = 25;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Updated";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
            }
            if ($city) {
                return redirect()->route('city.index')->with('success', 'City is successfully updated.');
            } else {
                return redirect()->route('city.index')->with('error', 'An error occurred while updating city.');
            }
        } catch (Exception $e) {
            return redirect()->route('city.index')->with('error', $e->getMessage());
        }
        abort(404);
    }

    public function destroy($id)
    {
        try {
            $city = city::findOrFail($id);
            if ($city->delete()) {
                if(Auth::guard('admin')->user()){
                    $jsonCompanyhis = 'Deleted city';
                    $moduleid = 25;
                    $userId = Auth::guard('admin')->user()->id;
                    $action = "Deleted";
                    $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
                }
                return redirect()->route('city.index')->with('success', 'City is successfully deleted.');
            }
            return redirect()->route('city.index')->with('error', 'An error occurred while deleting city.');
        } catch (Exception $e) {
            return redirect()->route('city.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
}
