<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        return view('Projects.Project.dashboards.create', ['project' => $project]);
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
    public function show(string $project_id, string $dashboard_id)
    {
        $project = Project::where('id', $project_id)->first();
        $dashboard = Dashboard::where('id', $dashboard_id)->first();

        return view('Projects.Project.dashboards.show', ['dashboard' => $dashboard, 'project' => $project]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
