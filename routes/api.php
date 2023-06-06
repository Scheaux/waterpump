<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\PumpMeterRecordController;
use App\Http\Controllers\ResidentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Protected routes
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/periods', PeriodController::class);
    Route::apiResource('/pumprecords', PumpMeterRecordController::class);
    Route::patch('/pumprecords', [PumpMeterRecordController::class, 'updateByPeriodId']);
    Route::apiResource('/residents', ResidentController::class);
    Route::apiResource('/bills', BillController::class);
});
