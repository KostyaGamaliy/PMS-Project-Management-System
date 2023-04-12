<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\Dashboard;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        return view("Projects.Project.members.show", ['project' => $project]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Project $project)
    {
        $users = User::whereDoesntHave('projects', function ($query) use ($project){
            $query->where('project_id', $project->id);
        })->get();

        $roles = [];

        foreach ($users as $user) {
            $role = $user->role()->first();
            if ($role) {
                $roles[] = $role;
            }
        }

        if ($request->has('role_id')) {
            $role = Role::findOrFail($request->input('role_id'));

            $permissions = $role->permissions;
        }

        return view('Projects.Project.members.create', ['project' => $project, 'users' => $users, 'roles' => $roles, 'permissions' => $permissions ?? []]);
    }

    public function getPermissions(Request $request) {
        $role = Role::findOrFail($request->input('role_id'));
        $permissions = $role->permissions;

        return $permissions;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        $rules = ['user_id' => 'required|int', 'role_id' => 'int'];
        $this->validate( $request, $rules);

        DB::table('users')
            ->where('id', $request->get('user_id'))
            ->update(['role_id' => $request->get('role_id')]);

        $project->users()->attach($request->get('user_id'));

        return redirect()->route('home.project.members.index', ['project' => $project]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, User $user)
    {
        $users = $project->users()->get();
        $roles = [];

        foreach ($users as $user) {
            $role = $user->role()->first();
            if ($role) {
                $roles[] = $role;
            }
        }

        return view('Projects.Project.members.edit', compact('project', 'user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $rules = ['role_id' => 'int'];
        $this->validate( $request, $rules);

        DB::table('users')
            ->where('id', $request->get('user_id'))
            ->update(['role_id' => $request->get('role_id')]);

        return redirect()->route('home.project.members.index', ['project' => $project]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, User $user)
    {
        $user->projects()->detach($project->id);

        return redirect()->route('home.project.members.index', ['project' => $project]);
    }
}
