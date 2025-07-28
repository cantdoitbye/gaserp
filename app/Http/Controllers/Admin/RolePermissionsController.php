<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
class RolePermissionsController extends Controller
{
    //
    public function rolePermissions(Request $r){
        // Get admin by ID (you can customize this to get the specific admin ID)
        $admin = Admin::find(1);
        if ($admin) {
            $adminpermissions = json_decode($admin->permissions, true);
        } else {
            // Initialize permissions as an empty array if the admin is not found
            $adminpermissions = [];
        }
        $subadmin = Admin::find(2);
        if ($subadmin) {
            $subadminpermissions = json_decode($subadmin->permissions, true);
        } else {
            // Initialize permissions as an empty array if the admin is not found
            $subadminpermissions = [];
        }
        $otheradmin = Admin::find(4);
        if ($otheradmin) {
            $otheradminpermissions = json_decode($otheradmin->permissions, true);
        } else {
            // Initialize permissions as an empty array if the admin is not found
            $otheradminpermissions = [];
        }
        return view('admin.rolePermissions.index', compact('adminpermissions','subadminpermissions','otheradminpermissions'));   
    }
    public function updatePermission(Request $request)
    {
        // Get admin by ID
        $admin = Admin::find($request->admin_id);

        // Decode the permissions JSON
        $permissions = json_decode($admin->permissions, true);

        // Check if the module exists in the current permissions
        $module = $request->page;
        $action = $request->permission; // e.g. 'view', 'edit', 'delete'
        $isChecked = $request->value; // 1 if checked, 0 if unchecked

        // Initialize permissions for the module if not set
        if (!isset($permissions[$module])) {
            $permissions[$module] = [];
        }

        // Add or remove permission based on checkbox state
        if ($isChecked) {
            // Add permission if not already present
            if (!in_array($action, $permissions[$module])) {
                $permissions[$module][] = $action;
            }
        } else {
            // Remove permission if unchecked
            $permissions[$module] = array_diff($permissions[$module], [$action]);

            // If there are no permissions left for the module, remove it from the array
            if (empty($permissions[$module])) {
                unset($permissions[$module]);
            }
        }

        // Update the permissions in the database
        $admin->permissions = json_encode($permissions);
        $admin->save();

        return response()->json(['success' => true, 'permissions' => $permissions]);
    }
}
