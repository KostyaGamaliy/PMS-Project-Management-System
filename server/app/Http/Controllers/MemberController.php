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

        $roles = $project->roles;

        return view('Projects.Project.members.create', ['project' => $project, 'users' => $users, 'roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        $rules = ['user_id' => 'required|int', 'role_id' => 'int'];
        $this->validate( $request, $rules);

//        $role = Role::find($request->get('role_id'));
//        $data['name'] = $role->name;
//        $data['project_id'] = $project->id;
//        $data['user_id'] = $request->get('user_id');
//
//        Role::create($data);

        DB::table('roles')
            ->where('id', $request->get('role_id'))
            ->update(['user_id' => $request->get('user_id'), 'project_id' => $project->id]);

        $project->users()->attach($request->get('user_id'));

        return redirect()->route('admin.project.members.index', ['project' => $project]);
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
        $roles = $project->roles;



        return view('Projects.Project.members.edit', compact('project', 'user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $rules = ['role_id' => 'int'];
        $this->validate( $request, $rules);

        DB::table('roles')
            ->where('id', $request->get('role_id'))
            ->update(['user_id' => $request->get('user_id')]);

        return redirect()->route('admin.project.members.index', ['project' => $project]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, User $user)
    {
        $roles = $project->roles;
        foreach ($roles as $role) {
            if ($role->user_id == $user->id) {
//                $role->delete();
            }
        }

        $user->projects()->detach($project->id);

        return redirect()->route('admin.project.members.index', ['project' => $project]);
    }
}
