<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;


class RoleController extends Controller
{
    public function index()
    {
       // Ambil semua roles dan permissions yang terkait
        $roles = DB::table('roles')
        ->select('id', 'name')
            ->get();

        // Ambil permissions untuk setiap role
        $rolesWithPermissions = DB::table('role_has_permissions')
            ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->join('roles', 'role_has_permissions.role_id', '=', 'roles.id')
            ->select('roles.id as role_id', 'roles.name as role_name', 'permissions.name as permission_name')
            ->get()
            ->groupBy('role_id'); // Kelompokkan berdasarkan role_id
        $groupedRoles = $rolesWithPermissions->groupBy('role_name');


        return view('role-permission.role.index', compact('roles', 'rolesWithPermissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rolename' => [
                'required',
                'string',
                'unique:roles,name'
            ]
        ]);

        Role::create([
            'name' => $request->rolename
        ]);

        return redirect()->route('role')->with('Success', 'Role berhasi di tambahkan');
    }

    public function update(Request $request)
    {

        $id = $request['roleid'];
        $role = Role::find($id);
        $role->name = $request['rolenames'];
        $role->update();
        return redirect()->route('role')->with('Success', 'Role berhasi di Edit');
    }

    public function destroy(Request $request)
    {
        $id = $request['roleids'];
        $role = Role::find($id);
        $role->delete();
        return redirect()->route('role')->with('Success', 'Role berhasi di Hapus');
    }

    public function addPermissionToRole($roleId)
    {
        $permissions = Permission::get();
        $role = Role::findOrFail($roleId);
        $rolePermissions = DB::table('role_has_permissions')
                                ->where('role_has_permissions.role_id', $role->id)
                                ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
                                ->all();

        return view('role-permission.role.give', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function givePermissionToRole(Request $request, $roleId)
    {
        $request->validate([
            'permission' => 'required'
        ]);

        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->permission);

        return redirect()->route('role')->with('Success', 'Role berhasi di Berikan Permesion');
    }
}
