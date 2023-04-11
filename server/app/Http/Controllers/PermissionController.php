<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermissionRequest;
use App\Models\Permission;
use App\Models\Project;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function store(StorePermissionRequest $request, Project $project) {
        $data = $request->except('_token');

        $permissions = Permission::create($data);

        return back();
    }
}
