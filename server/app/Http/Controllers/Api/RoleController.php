<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index() {
        $roles = Role::all();

        return response()->json(['roles' => $roles]);
    }

    public function store(Request $request) {
        Role::create($request->all());
    }

    public function destroy($id) {
        $role = Role::find($id);

        $role->delete();
    }

    public function getPermissions($id) {
        $role = Role::find($id);
        $permissions = $role->permissions;

        return response()->json(['permissions' => $permissions]);
    }
}
