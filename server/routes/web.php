<?php

use Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::redirect('/', '/login');

    Route::get('/home', function () {
        if (session('status')) {
            return redirect()->route('home')->with('status', session('status'));
        }
        return view('home');
    })->name('home');

    Route::group([
        'as' => 'home.',
        'prefix' => 'home',
    ], function() {
        Route::resource('projects', \App\Http\Controllers\ProjectController::class);

        Route::group([
            'as' => 'project.dashboard.',
            'prefix' => '/project',
        ], function() {
            Route::post('/{project}/board/store',  [\App\Http\Controllers\DashboardController::class, 'store'])->name('store');
            Route::get('/{project}/board/create',  [\App\Http\Controllers\DashboardController::class, 'create'])->name('create');
            Route::get('/{project}/board/{dashboard}', [\App\Http\Controllers\DashboardController::class, 'show'])->name('show');
            Route::get('/{project}/board/{dashboard}/edit', [\App\Http\Controllers\DashboardController::class, 'edit'])->name('edit');
            Route::put('/{project}/board/{dashboard}/update', [\App\Http\Controllers\DashboardController::class, 'update'])->name('update');
            Route::delete('/{project}/board/{dashboard}/delete',  [\App\Http\Controllers\DashboardController::class, 'destroy'])->name('destroy');
        });

        Route::group([
            'as' => 'project.dashboard.task.',
            'prefix' => '/project/{project}/board/{dashboard}/task',
        ], function() {
            Route::get('/create',  [\App\Http\Controllers\TaskController::class, 'create'])->name('create');
            Route::post('/store',  [\App\Http\Controllers\TaskController::class, 'store'])->name('store');
            Route::delete('/{task}/delete',  [\App\Http\Controllers\TaskController::class, 'destroy'])->name('destroy');
            Route::get('/{task}/edit', [\App\Http\Controllers\TaskController::class, 'edit'])->name('edit');
            Route::put('/{task}/update', [\App\Http\Controllers\TaskController::class, 'update'])->name('update');
            Route::get('/{task}/show', [\App\Http\Controllers\TaskController::class, 'show'])->name('show');
        });

        Route::group([
            'as' => 'project.members.',
            'prefix' => '/{project}/members',
        ], function () {
            Route::get('/', [\App\Http\Controllers\MemberController::class, 'index'])->name('index');
            Route::get('/{user}/delete', [\App\Http\Controllers\MemberController::class, 'destroy'])->name('destroy');
            Route::get('/create', [\App\Http\Controllers\MemberController::class, 'create'])->name('create');
            Route::post('/store', [\App\Http\Controllers\MemberController::class, 'store'])->name('store');
            Route::get('/{user}/edit', [\App\Http\Controllers\MemberController::class, 'edit'])->name('edit');
            Route::put('/update', [\App\Http\Controllers\MemberController::class, 'update'])->name('update');
        });
        Route::post('/members/get-permissions', [\App\Http\Controllers\MemberController::class, 'getPermissions'])->name('project.members.getPermissions');

        Route::get('/{project}/roles/index' , [\App\Http\Controllers\RoleController::class, 'index'])->name('project.roles.index');
        Route::get('/{project}/roles/{role}/edit' , [\App\Http\Controllers\RoleController::class, 'edit'])->name('project.roles.edit');
        Route::put('/{project}/roles/update' , [\App\Http\Controllers\RoleController::class, 'update'])->name('project.roles.update');
        Route::get('/{project}/roles/{role}/delete' , [\App\Http\Controllers\RoleController::class, 'destroy'])->name('project.roles.destroy');
        Route::get('/{project}/roles/create' , [\App\Http\Controllers\RoleController::class, 'create'])->name('project.roles.create');
        Route::post('/{project}/roles/store' , [\App\Http\Controllers\RoleController::class, 'store'])->name('project.roles.store');

        Route::post('/permission/store' , [\App\Http\Controllers\PermissionController::class, 'store'])->name('permission.store');
        Route::post('/permission/destroy' , [\App\Http\Controllers\PermissionController::class, 'destroy'])->name('permission.destroy');

    });

    Route::post('updateLastModal', [\App\Http\Controllers\HomeController::class, 'updateLastModal'])->name('home.updateLastModal');

