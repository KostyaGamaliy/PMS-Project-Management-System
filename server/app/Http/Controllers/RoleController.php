<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Project;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $roles = Role::all();

        return view("Projects.Project.roles.index", compact('project', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        $permissions = Permission::all();

        return view("Projects.Project.roles.create", ['project' => $project, 'permissions' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

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
    public function edit(Project $project, Role $role)
    {
        $selectedRole = $role->permissions()->get(['id'])->pluck('id')->toArray();
        $permissions = Permission::all();

        return view('Projects.Project.roles.edit', compact('project', 'role', 'selectedRole', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $rules = ['name' => 'required|string|min:2|max:50', 'permission_id' => 'array'];
        $this->validate( $request, $rules);
        $roles = Role::all();
        $role = Role::find($request->get('role_id'));
        $permissions = $role->permissions()->get(['id'])->pluck('id')->toArray();

        DB::table('roles')
            ->where('id', $request->get('role_id'))
            ->update(['name' => $request->get('name')]);

        $role->permissions()->detach($permissions);
        $role->permissions()->attach($request->get('permission_id'));

        return redirect()->route('home.project.roles.index', ['project' => $project, 'roles' => $roles]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Role $role)
    {

        $role->users()->update(['role_id' => null]);
        $role->delete();
        $roles = Role::all();

        return redirect()->route('home.project.roles.index', ['project' => $project, 'roles' => $roles]);
    }
}
