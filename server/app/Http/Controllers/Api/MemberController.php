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
    public function show($projectId, $id) {
        $member = User::find($id);
        $role = Role::where('user_id', $id)->where('project_id', $projectId)->get();

        return response()->json(['member' => $member, 'role' => $role]);
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
        $project = Project::find($projectId);
        $roles = $project->roles;

        return response()->json(['users' => $users, 'roles' => $roles]);
    }

    public function store($id) {
        $project = Project::findOrFail($id);
        $role = Role::find(request()->input('role_id'));

        Role::create([
            'name' => $role->name,
            'project_id' => $project->id,
            'user_id' => request()->input('user_id')
        ]);

        $project->users()->attach(request()->input('user_id'));
    }

    public function update($memberId, $roleId) {
        DB::table('roles')
            ->where('id', $roleId)
            ->update(['user_id' => $memberId]);
    }

    public function destroy($projectId, $memberId) {
        $user = User::find($memberId);
        $role = Role::where('project_id', $projectId)->where('user_id', $memberId)->update(['user_id' => 0]);

        $user->projects()->detach($projectId);
    }
}
