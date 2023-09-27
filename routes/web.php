<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectTasksController;
use App\Models\Project;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::group(['middleware'=> 'auth'], function () {

    Route::resource('/projects', ProjectController::class);
    Route::resource('/projects/{project}/tasks', ProjectTasksController::class);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
