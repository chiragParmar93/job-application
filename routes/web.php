<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

//Route::get('jobs', [JobController::class, 'index']);

Route::get('job/list', [JobController::class, 'getJobs'])->name('jobs.list');

// Route::get('job/destroy/{id}', [JobController::class, 'destroy'])->name('job.delete');

// Route::get('job/edit/{id}', [JobController::class, 'edit'])->name('job.edit');

// Route::get('job/update', [JobController::class, 'update'])->name('job.update');

Route::resource('jobs', JobController::class);

require __DIR__ . '/auth.php';
