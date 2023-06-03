<?php

use App\Http\Controllers\PeriodController;
use App\Http\Controllers\PumpMeterRecordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('/periods', PeriodController::class);
Route::apiResource('/pumprecords', PumpMeterRecordController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
