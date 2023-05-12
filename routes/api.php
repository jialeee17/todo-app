<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToDosController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\RestoreCenterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Restore Center
Route::prefix('restoreCenter')->name('restoreCenter.')->group(function () {
    Route::get('/data', [RestoreCenterController::class, 'getTrashedTodosData'])->name('data');
    Route::post('/restore/{id}', [RestoreCenterController::class, 'restore'])->name('restore');
});

// Activity Log
Route::prefix('activityLog')->name('activityLog.')->group(function () {
    Route::get('/data', [ActivityLogController::class, 'getActivityLogData'])->name('data');
});