<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CMSRequest;
use Illuminate\Http\Request;
use App\Models\CmsPages;
use Illuminate\Support\Facades\Auth;
use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class CmsPagesController extends Controller
{
    /*****
     * View Index page 
     * */
    public function index(Request $request)
    {
        $userModel = Auth::guard('admin')->user();
        if ($request->ajax()) {
            $obj1 = CmsPages::whereNull('deleted_at')
                ->orderBy('id', 'desc')
                ->get();
            return DataTables::of($obj1)->make(true);
        }
        return view('admin.cms.list', compact('userModel'));
    }
    /*****
     * cms create page
     * */
    public function create()
    {
        return view('admin.cms.create');
    }
    /*****
     * cms view page
     * */
    public function cmsPages($slug)
    {
        $pages = CmsPages::all();
        $page = CmsPages::where('slug', $slug)->first();

        if (!$page) {
            abort(404); // Page not found
        }
        return view('frontend.cms.need_help', compact('page','pages'));
    }
    /*****
     * cms Store
     * */
    public function store(Request $request)
    {
        $request->validate(
            [
                'slug' => 'required|alpha_dash|unique:cms_pages,slug|max:255|min:3',
                'title' => 'required|min:3',
                'content' => 'required',
            ]
        );
        try {
            $cms = new CmsPages();
            $cms->slug = $request->slug;
            $cms->title = $request->title;
            $cms->content = $request->content;
            $cms->status = $request->status;
            $cms->save();
            if(Auth::guard('admin')->user()){
                $jsonCompanyhis = 'Created CMS';
                $moduleid = 12;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Created";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
            }
            if ($cms) {
                return redirect()->route('cms.index')->with('success', 'CMS is successfully created.');
            } else {
                return redirect()->route('cms.index')->with('error', 'An error occurred while creating CMS.');
            }
        } catch (Exception $e) {
            return redirect()->route('cms.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
    /*****
     * cms details page show
     * */
    public function show(Request $request, $id)
    {
        try {
            if (!empty($id)) {
                $cms = CmsPages::where('id', $id)->whereNull('deleted_at')->first();
                return view('admin.cms.show', compact('cms'));
            }
        } catch (Exception $e) {
            return redirect()->route('cms.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
    /*****
     * cms details page edit
     * */
    public function edit($id)
    {
        $cms = CmsPages::where('id', $id)->whereNull('deleted_at')->first();
        return view('admin.cms.create', compact('cms'));
    }
    /*****
     * fuels Update
     * */
    public function update(Request $request, $id)
    {
        $request->validate([
            'slug' => 'nullable|alpha_dash|max:255|min:3|unique:cms_pages,slug,' . $id,
        ]);
        if ($request->filled('slug')) {
            $slug = $request->input('slug');
        } else {
            $slug = CmsPages::findOrFail($id)->slug;
        }
        try {
            $cms = CmsPages::findOrFail($id);
            $cms->slug = $request->slug;
            $cms->title = $request->title;
            $cms->content = $request->content;
            $cms->status = $request->status;
            $cms->update();
            if(Auth::guard('admin')->user()){
                $jsonCompanyhis = 'Updated CMS';
                $moduleid = 12;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Updated";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
            }
            if ($cms) {
                return redirect()->route('cms.index')->with('success', 'CMS is successfully updated.');
            } else {
                return redirect()->route('cms.index')->with('error', 'An error occurred while updating CMS.');
            }
        } catch (Exception $e) {
            return redirect()->route('cms.index')->with('error', $e->getMessage());
        }
        abort(404);
    }

    public function destroy($id)
    {
        try {
            $cms = CmsPages::findOrFail($id);
            if ($cms->delete()) {
                if(Auth::guard('admin')->user()){
                    $jsonCompanyhis = 'Deleted CMS';
                    $moduleid = 12;
                    $userId = Auth::guard('admin')->user()->id;
                    $action = "Deleted";
                    $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
                }
                return redirect()->route('cms.index')->with('success', 'CMS is successfully deleted.');
            }
            return redirect()->route('cms.index')->with('error', 'An error occurred while deleting CMS.');
        } catch (Exception $e) {
            return redirect()->route('cms.index')->with('error', $e->getMessage());
        }
        abort(404);
    }
}
