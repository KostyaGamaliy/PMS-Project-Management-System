<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDashboardRequest;
use App\Models\Dashboard;
use App\Models\Project;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index($id) {
        $dashboards = Project::findOrFail($id)->dashboards;

        return response()->json(['dashboards' => $dashboards]);
    }

    public function store(StoreDashboardRequest $request) {
        $data = $request->validated();

        $dashboard = Dashboard::create($data);
//        return response()->json(['dashboard' => $dashboard]);
    }
}
