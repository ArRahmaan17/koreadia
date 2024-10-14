<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Dev\Mail\AgendaController;
use App\Http\Controllers\Dev\Mail\PriorityController;
use App\Http\Controllers\Dev\Mail\TypeController;
use App\Http\Controllers\User\HomeController;
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

Route::middleware('auth')->get('/', [HomeController::class, 'index'])->name('home');
Route::middleware('auth')->prefix('master')->name('master.')->group(function () {
    Route::prefix('agenda')->name('agenda.')->group(function () {
        Route::get('/', [AgendaController::class, 'index'])->name('index');
        Route::get('/data-table', [AgendaController::class, 'dataTable'])->name('data-table');
        Route::get('/{id?}', [AgendaController::class, 'show'])->name('show');
        Route::put('/{id?}', [AgendaController::class, 'update'])->name('update');
        Route::delete('/{id?}', [AgendaController::class, 'destroy'])->name('destroy');
        Route::post('/', [AgendaController::class, 'store'])->name('store');
    });
    Route::prefix('type')->name('type.')->group(function () {
        Route::get('/', [TypeController::class, 'index'])->name('index');
        Route::get('/data-table', [TypeController::class, 'dataTable'])->name('data-table');
        Route::get('/{id?}', [TypeController::class, 'show'])->name('show');
        Route::put('/{id?}', [TypeController::class, 'update'])->name('update');
        Route::delete('/{id?}', [TypeController::class, 'destroy'])->name('destroy');
        Route::post('/', [TypeController::class, 'store'])->name('store');
    });
    Route::prefix('priority')->name('priority.')->group(function () {
        Route::get('/', [PriorityController::class, 'index'])->name('index');
        Route::get('/data-table', [PriorityController::class, 'dataTable'])->name('data-table');
        Route::get('/{id?}', [PriorityController::class, 'show'])->name('show');
        Route::put('/{id?}', [PriorityController::class, 'update'])->name('update');
        Route::delete('/{id?}', [PriorityController::class, 'destroy'])->name('destroy');
        Route::post('/', [PriorityController::class, 'store'])->name('store');
    });
});
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/register', [AuthController::class, 'signup'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});
