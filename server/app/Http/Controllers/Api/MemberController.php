<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function show($id) {
        $member = User::find($id);
        $role = Role::findOrFail($member->role_id);
        $permissions = $role->permissions;

        return response()->json(['member' => $member, 'role' => $role, 'permissions' => $permissions]);
    }
}
