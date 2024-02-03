<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyIndustry;
use App\Models\Activity;
use App\Models\industryScope;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class IndustryScopeController extends Controller
{
    public function index(Request $request)
    {

        // $industryScopeobj1 = industryScope::with('industry','emission','scope')->select('industry_scopes.*', DB::raw('GROUP_CONCAT(emission_type_id) as emission_types'))->groupBy('industry_id', 'scope_id')->get()->toArray();
        // $datascope = [];
        
        // foreach($industryScopeobj1 as $key => $industryscope){
        //     if(!in_array($industryscope['industry']['name'],$datascope)){
        //         $emissionArr = explode(',', $industryscope['emission_types']);
        //         $emissiontypeArr = [];
        //         foreach($emissionArr as $emission){
        //             $emissionquery = EmissionType::where('id',$emission)->first();
        //             $emissiontypeArr[] = $emissionquery->name;   
        //         }
        //         $datascope[$industryscope['industry']['name']][$industryscope['scope']['name']] = implode(',',$emissiontypeArr);
        //         $datascope[$industryscope['industry']['name']]['date'] = $industryscope['created_at'];
        //     }
        // }
        if($request->ajax()){
            $industryScopeobj1 = industryScope::with(['industry'])->select('industry_scopes.*')->groupBy('industry_id');
            
            if(isset($request->search['value']) && $request->search['value'] != ""){
                $search = $request->search['value'];
                $industryScopeobj1->whereHas('industry',function($query) use($search){
                        $query->where('name','like','%'.$search.'%');
                });
            }else{
                $industryScopeobj1;
            }
            return DataTables::of($industryScopeobj1)->make(true);
        }
        return view('admin.scopes.list');
    }

    public function create(Request $request,$id=null)
    {
        $scope1Array = [];
        $scope2Array = [];
        $scope3Array = [];
        
        if($id != null){
            
            $industryScopeobj1 = industryScope::where('industry_id',$id)->get()->toArray();
            if(count($industryScopeobj1) > 0){
                foreach ($industryScopeobj1 as $value) {
                    if($value['scope_id'] == '1'){
                        $scope1Array[] = $value['activity_id']; 
                    }
                    if($value['scope_id'] == '2'){
                        $scope2Array[] = $value['activity_id']; 
                    }
                    if($value['scope_id'] == '3'){
                        $scope3Array[] = $value['activity_id']; 
                    }
                }
            } else {
                $url = route('scopes.create').'?id='.$id;
                return redirect()->to($url);
            }
        }else{
            $industryScopeobj1 = null;
        }
        $companyIndustry = CompanyIndustry::whereNull('deleted_at')->orderBy('name','asc')->get();
        $emissionTypes = Activity::whereNull('deleted_at')->orderBy('name','asc')->get();
        return view('admin.scopes.create', compact('companyIndustry', 'emissionTypes','industryScopeobj1','scope1Array','scope2Array','scope3Array'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'industry'=>'required',
            'scope1'=>'required',
        ]);

        try{
            $count1 = !empty($request->scope1) ? count($request->scope1):0;
            $count2 = !empty($request->scope2) ? count($request->scope2):0;
            $count3 = !empty($request->scope3) ? count($request->scope3):0;
            $sumscope = $count1 + $count2 + $count3;
            $emissionTypescount = Activity::orderBy('name','asc')->count();
            if($emissionTypescount == $sumscope){
                $industry = industryScope::where('industry_id',$request->industry)->delete();
                /************************ Create *********************** */
                $industryscope = new industryScope();
                if(!empty($request->scope1)){
                    $scop1array = [];
                    foreach($request->scope1 as $scope1){
                        $scop1arrayobj =[
                            'industry_id'=> $request->industry,
                            'scope_id'=> '1',
                            'activity_id'=>$scope1
                        ];
                        array_push($scop1array, $scop1arrayobj);
                    }
                    industryScope::insert($scop1array);
                }
                if(!empty($request->scope2)){
                    $scop2array = [];
                    foreach($request->scope2 as $scope2){
                        $scop2arrayobj =[
                            'industry_id'=> $request->industry,
                            'scope_id'=> '2',
                            'activity_id'=>$scope2
                        ];
                        array_push($scop2array, $scop2arrayobj);
                    }
                    industryScope::insert($scop2array);
                }
                if(!empty($request->scope3)){
                    $scop3array = [];
                    foreach($request->scope3 as $scope3){
                        $scop3arrayobj =[
                            'industry_id'=> $request->industry,
                            'scope_id'=> '3',
                            'activity_id'=>$scope3
                        ];
                        array_push($scop3array, $scop3arrayobj);
                    }
                    industryScope::insert($scop3array);
                }
                return redirect()->route('scopes.index')->with("success", "Industry scope is successfully created");
            } else {
                return redirect()->back()->with("error", "Please select all scope");
            }
        }catch(Exception $e){
            return redirect()->route('scopes.index')->with("error", $e->getMessage());
        }
    }

    public function show($id)
    {
        $industryScopeinfo = industryScope::with('industry','activity','scope')->where('industry_id',$id)->select('industry_scopes.*', DB::raw('GROUP_CONCAT(activity_id) as emission_types'))->groupBy('industry_id', 'scope_id')->get()->toArray();
        $datascope = [];
        if(count($industryScopeinfo) > 0){
            
            $emissiontypeArr1 = [];
            $emissiontypeArr2 = [];
            $emissiontypeArr3 = [];
            foreach($industryScopeinfo as $key => $industry){
                $datascope['industry'] = $industry['industry']['name'];
                $emissionArr = explode(',', $industry['emission_types']);
                foreach($emissionArr as $emission){
                    $emissionquery = Activity::where('id',$emission)->first();
                    if($industry['scope_id'] == "1"){
                        $emissiontypeArr1[] = $emissionquery->name;
                    }else if($industry['scope_id'] == "2"){
                        $emissiontypeArr2[] = $emissionquery->name;
                    }else{
                        $emissiontypeArr3[] = $emissionquery->name;
                    }
                }
                $datascope['date'] = $industry['created_at'];    
            }
            $datascope['scope1'] = implode(', ', $emissiontypeArr1);
            $datascope['scope2'] = implode(', ', $emissiontypeArr2);
            $datascope['scope3'] = implode(', ', $emissiontypeArr3);
        }
        return view('admin.scopes.show', compact('industryScopeinfo','datascope'));
    }

}
