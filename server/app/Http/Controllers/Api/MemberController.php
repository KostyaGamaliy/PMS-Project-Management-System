<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function show($projectId, $id) {
        $project = Project::find($projectId);
        $this->authorize('view', $project);

        $member = User::find($id);
        $role = Role::where('user_id', $id)->where('project_id', $projectId)->get();

        return response()->json(['member' => $member, 'role' => $role]);
    }

    public function edit($id)
    {
        $project = Project::find($id);
        $this->authorize('view', $project);

        $users = $project->users()->get();
        $roles = $project->roles;

        return response()->json(['roles' => $roles]);
    }

    public function create($projectId) {
        $project = Project::find($projectId);
        $this->authorize('view', $project);

        $users = User::whereDoesntHave('projects', function ($query) use ($projectId){
            $query->where('project_id', $projectId);
        })->get();

        $roles = $project->roles;

        return response()->json(['users' => $users, 'roles' => $roles]);
    }

    public function store($id) {
        $project = Project::findOrFail($id);
        $this->authorize('view', $project);

        $role = Role::find(request()->input('role_id'));

        Role::create([
            'name' => $role->name,
            'project_id' => $project->id,
            'user_id' => request()->input('user_id')
        ]);

        $project->users()->attach(request()->input('user_id'));
    }

    public function update($memberId, $roleId, $projectId) {
        $project = Project::find($projectId);
        $this->authorize('update', $project);

        DB::table('roles')
            ->where('project_id', $projectId)
            ->where('user_id', $memberId)
            ->update(['user_id' => 0]);

        DB::table('roles')
            ->where('id', $roleId)
            ->update(['user_id' => $memberId]);
    }

    public function destroy($projectId, $memberId) {
        $project = Project::find($projectId);
        $this->authorize('delete', $project);

        $user = User::find($memberId);
        Message::where('project_id', $projectId)->where('sender_id', $memberId)->delete();
        Role::where('project_id', $projectId)->where('user_id', $memberId)->update(['user_id' => 0]);

        $user->projects()->detach($projectId);
    }
}
