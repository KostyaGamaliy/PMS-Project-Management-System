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
        $userRoles =
        $role = Role::findOrFail($member->role_id);
        $permissions = $role->permissions;

        return response()->json(['member' => $member, 'role' => $role, 'permissions' => $permissions]);
    }

    public function edit($id)
    {
        $project = Project::find($id);
        $users = $project->users()->get();
        $roles = $project->roles;

        return response()->json(['roles' => $roles]);
    }

    public function create($projectId) {
        $users = User::whereDoesntHave('projects', function ($query) use ($projectId){
            $query->where('project_id', $projectId);
        })->get();

        $roles = Role::all();

        foreach ($roles as $role) {
            $role->permissions = $role->permissions;
        }

        return response()->json(['users' => $users, 'roles' => $roles]);
    }

    public function store($id) {
        $project = Project::findOrFail($id);

        DB::table('users')
            ->where('id', request()->input('user_id'))
            ->update(['role_id' => request()->input('role_id')]);

        $project->users()->attach(request()->input('user_id'));
    }

    public function update($memberId, $roleId) {
        DB::table('roles')
            ->where('id', $roleId)
            ->update(['user_id' => $memberId]);
    }

    public function destroy($projectId, $memberId) {
        $user = User::find($memberId);
        $user->projects()->detach($projectId);
    }
}
