<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TideGaugeController;
use App\Http\Controllers\UserController;
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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/tidegauges', [TideGaugeController::class, 'index'])->name('tidegauges.index');
    Route::get('/tidegauges/create', [TideGaugeController::class, 'create'])->middleware('admin')->name('tidegauges.create');
    Route::post('/tidegauges', [TideGaugeController::class, 'store'])->middleware('admin')->name('tidegauges.store');
    Route::get('/tidegauges/{id}/edit', [TideGaugeController::class, 'edit'])->name('tidegauges.edit');
    Route::put('/tidegauges/{id}', [TideGaugeController::class, 'update'])->name('tidegauges.update');
    Route::delete('/tidegauges/{id}', [TideGaugeController::class, 'destroy'])->middleware('admin')->name('tidegauges.destroy');
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
});




require __DIR__.'/auth.php';
