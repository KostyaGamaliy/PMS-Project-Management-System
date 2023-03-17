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

    Route::group([
        'as' => 'home.',
        'prefix' => 'home',
    ], function() {
        Route::get('/projects', [\App\Http\Controllers\ProjectController::class, 'index'])->name('projects');
        Route::post('/project/create', [\App\Http\Controllers\ProjectController::class, 'store'])->name('createProject');
        Route::put('/project/update/{id}', [\App\Http\Controllers\ProjectController::class, 'update'])->name('updateProject');
        Route::delete('/project/delete/{id}', [\App\Http\Controllers\ProjectController::class, 'destroy'])->name('deleteProject');
    });

    Route::post('updateLastModal', [\App\Http\Controllers\HomeController::class, 'updateLastModal'])->name('home.updateLastModal');

