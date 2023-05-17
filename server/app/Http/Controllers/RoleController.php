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
        $roles = $project->roles()->get();

        return view("Projects.Project.roles.index", compact('project', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        return view("Projects.Project.roles.create", ['project' => $project]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        $rules = ['name' => 'required|string|min:5|max:125'];
        $this->validate( $request, $rules);

        $data['name'] = $request->get('name');
        $data['project_id'] = $project->id;
        $data['user_id'] = 0;

        $role = Role::create($data);

        return redirect()->route('admin.project.roles.index', ['project' => $project]);
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
        return view('Projects.Project.roles.edit', compact('project', 'role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $rules = ['name' => 'required|string|min:2|max:50'];
        $this->validate( $request, $rules);

        $roles = $project->roles;

        DB::table('roles')
            ->where('id', $request->get('role_id'))
            ->update(['name' => $request->get('name')]);

        return redirect()->route('admin.project.roles.index', ['project' => $project, 'roles' => $roles]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Role $role)
    {
        $role->delete();

        $roles = $project->roles();

        return redirect()->route('admin.project.roles.index', ['project' => $project, 'roles' => $roles]);
    }
}
