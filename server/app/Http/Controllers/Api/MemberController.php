<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function show($id) {
        $member = User::find($id);
        $role = Role::findOrFail($member->role_id);
        $permissions = $role->permissions;

        return response()->json(['member' => $member, 'role' => $role, 'permissions' => $permissions]);
    }

    public function edit($id)
    {
        $project = Project::find($id);
        $users = $project->users()->get();
        $roles = [];

        foreach ($users as $user) {
            $role = $user->role()->first();
            if ($role) {
                $roles[] = $role;
            }
        }

        return response()->json(['roles' => $roles]);
    }

    public function update($memberId, $roleId) {
        DB::table('users')
            ->where('id', $memberId)
            ->update(['role_id' => $roleId]);
    }

    public function destroy($projectId, $memberId) {
        $user = User::find($memberId);
        $user->projects()->detach($projectId);
    }
}
