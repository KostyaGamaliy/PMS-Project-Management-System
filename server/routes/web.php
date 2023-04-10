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

        Route::get('/{project}/members', [\App\Http\Controllers\MemberController::class, 'index'])->name('project.members.index');
        Route::get('/{project}/members/{user}/delete', [\App\Http\Controllers\MemberController::class, 'destroy'])->name('project.members.destroy');

        //Route::get('/project/{project_id}/members', [\App\Http\Controllers\ProjectController::class, 'show'])->name('show');

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

    });

    Route::post('updateLastModal', [\App\Http\Controllers\HomeController::class, 'updateLastModal'])->name('home.updateLastModal');

