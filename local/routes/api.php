<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\TideGaugeController;
use App\Http\Controllers\API\WeatherDataController;
use App\Http\Controllers\API\DeviceSettingsController;

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

Route::get('/tidegauge', [TideGaugeController::class, 'index']);
Route::get('/tidegauge/{id}', [TideGaugeController::class, 'show']);
Route::get('/tidesBySerial/{serial}', [TideGaugeController::class, 'getItemsBySerial']);
Route::post('/tidedata', [TideGaugeController::class, 'store']);

Route::get('/weatherdata', [WeatherDataController::class, 'index']);
Route::post('/weathers', [WeatherDataController::class, 'store']);
Route::get('/weatherdata/{id}', [WeatherDataController::class, 'show']);
Route::get('/weatherdata/serial/{serial}', [WeatherDataController::class, 'getItemsBySerial']);
Route::delete('/weatherdata', [WeatherDataController::class, 'destroyAll']);
Route::delete('/weatherdata/{serial}', [WeatherDataController::class, 'destroyBySerial']);

Route::post('/deviceSettings', [DeviceSettingsController::class, 'store']);
