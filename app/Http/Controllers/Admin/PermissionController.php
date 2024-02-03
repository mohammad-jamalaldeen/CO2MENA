<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Module,
    Permission,
    UserRole,
    User
};

class PermissionController extends Controller
{
    public function index()
    {
        $userRoleData = [];
        $userRole = [];
        try {
            $userRoleData = UserRole::where('type', UserRole::BACKEND)->whereNot('role', 'Super Admin')->get()->toArray();
            $userRole = UserRole::select('id', 'role')->where('type', UserRole::BACKEND)->whereNotIn('role', ['Super Admin'])->get();
            $userData = User::select('id', 'name', 'user_role_id')->with('userRole')->whereIn('user_role_id', $userRole->pluck('id')->toArray())->get()->toArray();
            return view('admin/permission/list', compact('userRoleData', 'userData'));
        } catch (\Exception $e) {
            $error = $e->getMessage();
            p($error);
            return view('admin/permission/list', compact('error', 'userRoleData', 'userData'));
        }
    }

    public function listModule(Request $request)
    {
        try {
            $whereFrom = ($request->submitType == 'User') ? 'user_id' : 'user_role_id';
            $whereTo = ($request->submitType == 'User') ? $request->userId : $request->userRole;

            $moduleData = Module::select('id', 'module_name')->with(['permissions' => function ($query) use ($whereFrom, $whereTo) {
                $query->where($whereFrom, '=', $whereTo);
            }])->where('module_type', $request->role)->get()
            ->toArray();

            $roleWisePermissionFlag = array_reduce($moduleData, function ($carry, $value) {
                return $carry && (count($value['permissions']) === 0);
            }, true);

            if($roleWisePermissionFlag && $whereFrom == 'user_id')
            {
                $userData = User::select('id', 'user_role_id')->where('id', $whereTo)->first();
                $userRoleId = $userData->user_role_id;
                $moduleData = Module::select('id', 'module_name')
                ->with(['permissions' => function ($query) use ($userRoleId) {
                    $query->where('user_role_id', '=', $userRoleId);
                }])->where('module_type', $request->role)->get()
                ->toArray();
            }

            return response()->json(['status' => 'success', 'message' => "Data retrieved successfully.", 'data' => $moduleData]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage(), 'data' => []]);
        }
    }

    public function updatePermission(Request $request)
    {
        try {
            $moduleData = Module::select('id', 'module_name', 'module_type', 'module_slug')->where('module_type', $request->role_type)
                ->get()
                ->toArray();
            $permissionArray = [];

            foreach ($moduleData as $module) {
                $actions = ['create', 'index', 'show', 'edit', 'delete', 'download', 'manageemission', 'pendingdocument'];

                foreach ($actions as $action) {
                    if ($request[$action] !== NULL) {
                        if (array_key_exists($module['id'], $request[$action])) {
                            if($module['module_slug'] == 'dashboard' && $module['module_type'] == 'admin' && $action == 'download')
                            {
                                $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'print-chart', $request->filter_permission_type, $request->user_id);    
                            }

                            if($module['module_slug'] == 'backend-permission' && $module['module_type'] == 'admin' && $action == 'index')
                            {
                                $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'list-module', $request->filter_permission_type, $request->user_id);    
                                $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'update', $request->filter_permission_type, $request->user_id);    
                            }

                            if($module['module_slug'] == 'frontend-permission' && $module['module_type'] == 'admin' && $action == 'index')
                            {
                                $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'list-module', $request->filter_permission_type, $request->user_id);    
                                $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'update', $request->filter_permission_type, $request->user_id);    
                            }

                            if($module['module_slug'] == 'customer' && $module['module_type'] == 'admin'){
                                if($action == 'index'){
                                    $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'status-change', $request->filter_permission_type, $request->user_id);
                                }
                                if($action == 'pendingdocument'){
                                    $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'pending-document', $request->filter_permission_type, $request->user_id);
                                }
                                if($action == 'manageemission'){
                                    $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'manage-emission-store', $request->filter_permission_type, $request->user_id);
                                    $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'emission-data', $request->filter_permission_type, $request->user_id);
                                }
                            }

                            if($module['module_slug'] == 'datasheet' && $module['module_type'] == 'admin' && $action == "show"){
                                $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'uploded-sheet', $request->filter_permission_type, $request->user_id);
                                $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'emission_calculated', $request->filter_permission_type, $request->user_id);
                            }

                            if($module['module_slug'] == 'frontend-datasheets' && $module['module_type'] == 'frontend' && $action == "create"){
                                $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'sample-calculation', $request->filter_permission_type, $request->user_id);
                                $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'publish-datasheet', $request->filter_permission_type, $request->user_id);
                            }

                            if($module['module_slug'] == 'frontend-datasheets' && $module['module_type'] == 'frontend' && $action == "index"){
                                $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'ajax', $request->filter_permission_type, $request->user_id);
                            }
                            
                            if($module['module_slug'] == 'profile' && $module['module_type'] == 'frontend' && $action == "edit"){
                                $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'store', $request->filter_permission_type, $request->user_id);
                                $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'set-activity', $request->filter_permission_type, $request->user_id);
                                $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'profile-image-remove', $request->filter_permission_type, $request->user_id);
                            }

                            if($module['module_slug'] == 'staff' && $module['module_type'] == 'frontend' && $action == "edit"){
                                $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'getMember', $request->filter_permission_type, $request->user_id);
                            }

                            if($module['module_slug'] == 'staff' && $module['module_type'] == 'frontend' && $action == "index"){
                                $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'activity', $request->filter_permission_type, $request->user_id);
                                $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'loadMore', $request->filter_permission_type, $request->user_id);
                                $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'activityDatewise', $request->filter_permission_type, $request->user_id);


                            }

                            if($module['module_slug'] == 'dashboard' && $module['module_type'] == 'frontend' && $action == "index"){
                                $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'scope1', $request->filter_permission_type, $request->user_id);
                                $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'scope2', $request->filter_permission_type, $request->user_id);
                                $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'scope3', $request->filter_permission_type, $request->user_id);
                                $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'calculateTotalSum', $request->filter_permission_type, $request->user_id);
                            }

                            if($module['module_slug'] == 'dashboard' && $module['module_type'] == 'frontend' && $action == "download"){
                                $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'generate-pdf', $request->filter_permission_type, $request->user_id);
                                $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'scope-two-pdf', $request->filter_permission_type, $request->user_id);
                                $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'scope-one-pdf', $request->filter_permission_type, $request->user_id);
                                $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'scope-three-pdf', $request->filter_permission_type, $request->user_id);
                            }

                            if($action == 'create')
                            {
                                $permissionArray[] = $this->permissionObject($module['id'], $request->userrole,'store', $request->filter_permission_type, $request->user_id);    
                            }

                            if($action == 'edit')
                            {
                                $permissionArray[] = $this->permissionObject($module['id'], $request->userrole, 'update', $request->filter_permission_type, $request->user_id);    
                            }
                            $permissionArray[] = $this->permissionObject($module['id'], $request->userrole, $action, $request->filter_permission_type, $request->user_id);
                        }
                    }
                }
            }
           
            ($request->filter_permission_type == 'Role')  ? Permission::where('user_role_id', $request->userrole)->delete() : Permission::where('user_id', $request->user_id)->delete();
            Permission::insert($permissionArray);
            return ($request->page == 'frontend-permission') ? redirect('admin/frontend-permission')->with('success', 'Permissions are assigned successfully.') : redirect('admin/backend-permission')->with('success', 'Permissions are assigned successfully.');
        } catch (\Exception $e) {
            return ($request->page == 'frontend-permission') ? redirect('admin/frontend-permission')->with('error', $e->getMessage()) : redirect('admin/backend-permission')->with('error', $e->getMessage());
        }
    }

    public function permissionObject($module, $userrole, $action, $filterPermissionType, $userId)
    {
        $result = [
            'module_id' => $module,
            'action' => $action,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];


        if ($filterPermissionType == 'Role') {
            $result['user_role_id'] = $userrole;
        } else {
            $result['user_id'] = $userId;
        }

        return $result;
    }

    public function frontendPermission()
    {
        $userRoleData = [];
        $userRole = [];

        try {
            $userRoleData = UserRole::where('type', UserRole::FRONTEND)->get()->toArray();
            $userRole = UserRole::select('id', 'role')->where('type', UserRole::FRONTEND)->get();
            $userData = User::select('id', 'name', 'user_role_id')->with('userRole')->whereIn('user_role_id', $userRole->pluck('id')->toArray())->get()->toArray();
            return view('admin/permission/frontend-list', compact('userRoleData', 'userData'));
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return view('admin/permission/frontend-list', compact('error', 'userRoleData', 'userData'));
        }
    }
}
