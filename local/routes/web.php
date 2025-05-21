<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MeasurementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TideGaugeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\WeatherDataController;
use App\Http\Controllers\WidgetController;
use App\Http\Controllers\DeviceSettingsController;
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
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/tidegauge', function () {
        return view('tidegauge');
    });
    Route::get('/widget/{serial}', [WidgetController::class, 'show'])->name('widget.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/tidegauges', [TideGaugeController::class, 'index'])->name('tidegauges.index');
    Route::get('/tidegauges/create', [TideGaugeController::class, 'create'])->middleware('admin')->name('tidegauges.create');
    Route::post('/tidegauges', [TideGaugeController::class, 'store'])->middleware('admin')->name('tidegauges.store');
    Route::get('/tidegauges/{id}/edit', [TideGaugeController::class, 'edit'])->name('tidegauges.edit');
    Route::put('/tidegauges/{id}', [TideGaugeController::class, 'update'])->name('tidegauges.update');
    Route::delete('/tidegauges/{id}', [TideGaugeController::class, 'destroy'])->middleware('admin')->name('tidegauges.destroy');

    Route::get('/tidegauges/{id}/view', [TideGaugeController::class, 'view'])->name('tidegauges.view');

    Route::get('/tidegauges/{id}/adddata', [MeasurementController::class, 'create'])->name('measurement.create');
    Route::get('/measurement', [MeasurementController::class, 'index'])->name('measurement.index');
    Route::post('/measurement/create', [MeasurementController::class, 'store'])->name('measurement.store');
    Route::get('/measurement/{id}/edit', [MeasurementController::class, 'edit'])->name('measurement.edit');
    Route::put('/measurement/{id}', [MeasurementController::class, 'update'])->name('measurement.update');
    Route::delete('/measurement/{id}', [MeasurementController::class, 'destroy'])->name('measurement.destroy');

    Route::get('/weather', [WeatherController::class, 'index'])->name('weather.index');
    Route::get('/weather/create', [WeatherController::class, 'create'])->name('weather.create');
    Route::post('/weather/create', [WeatherController::class, 'store'])->name('weather.store');
    Route::get('/weather/{id}/edit', [WeatherController::class, 'edit'])->name('weather.edit');
    Route::put('/weather/{id}', [WeatherController::class, 'update'])->name('weather.update');
    Route::delete('/weather/{id}', [WeatherController::class, 'destroy'])->name('weather.destroy');

    Route::get('/weatherdata', [WeatherDataController::class, 'index'])->name('weatherdata.index');
    Route::get('/weatherdata/create', [WeatherDataController::class, 'create'])->name('weatherdata.create');
    Route::post('/weatherdata/create', [WeatherDataController::class, 'store'])->name('weatherdata.store');
    Route::get('/weatherdata/{id}/edit', [WeatherDataController::class, 'edit'])->name('weatherdata.edit');
    Route::put('/weatherdata/{id}', [WeatherDataController::class, 'update'])->name('weatherdata.update');
    Route::delete('/weatherdata/{id}', [WeatherDataController::class, 'destroy'])->name('weatherdata.destroy');
});

Route::middleware('admin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/assign-tidegauges', [UserController::class, 'assignTideGaugesPage'])->name('assign.tidegauges');
    Route::post('/assign-tidegauges', [UserController::class, 'storeTideGaugesAssignment'])->name('store.tidegauges');

    Route::get('/deviceSettings', [DeviceSettingsController::class, 'index'])->name('deviceSettings.index');
    Route::get('/deviceSettings/{serial}', [DeviceSettingsController::class, 'view'])->name('deviceSettings.view');
});




require __DIR__.'/auth.php';
