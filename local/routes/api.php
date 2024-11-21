<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/tidegauge', [\App\Http\Controllers\API\TideGaugeController::class, 'index']);
Route::get('/tidegauge/{id}', [\App\Http\Controllers\API\TideGaugeController::class, 'show']);
Route::get('/tidesBySerial/{serial}', [\App\Http\Controllers\API\TideGaugeController::class, 'getItemsBySerial']);
Route::post('/tidedata', [\App\Http\Controllers\API\TideGaugeController::class, 'store']);
