<?php

use App\Http\Controllers\Dev\AuthController;
use App\Http\Controllers\Dev\Mail\AgendaController;
use App\Http\Controllers\Dev\Mail\PriorityController;
use App\Http\Controllers\Dev\Mail\TypeController;
use App\Http\Controllers\Dev\MailTransactionController;
use App\Http\Controllers\Dev\MenuController;
use App\Http\Controllers\Dev\RoleController;
use App\Http\Controllers\Dev\SincerelyWordController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\UserController;
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

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/all', [UserController::class, 'all'])->name('all');
    });
    Route::prefix('mail')->name('mail.')->group(function () {
        Route::prefix('in')->name('in.')->group(function () {
            Route::get('/', [MailTransactionController::class, 'index'])->name('index');
            Route::put('/status-update/{id?}', [MailTransactionController::class, 'statusUpdate'])->name('status-update');
            Route::get('/data-table', [MailTransactionController::class, 'dataTable'])->name('data-table');
            Route::get('/{id?}', [MailTransactionController::class, 'show'])->name('show');
            Route::put('/{id?}', [MailTransactionController::class, 'update'])->name('update');
            Route::delete('/{id?}', [MailTransactionController::class, 'destroy'])->name('destroy');
            Route::post('/', [MailTransactionController::class, 'store'])->name('store');
        });
        Route::prefix('out')->name('out.')->group(function () {});
    });
    Route::prefix('master')->name('master.')->group(function () {
        Route::prefix('agenda')->name('agenda.')->group(function () {
            Route::get('/', [AgendaController::class, 'index'])->name('index');
            Route::get('/all', [AgendaController::class, 'all'])->name('all');
            Route::get('/data-table', [AgendaController::class, 'dataTable'])->name('data-table');
            Route::get('/{id?}', [AgendaController::class, 'show'])->name('show');
            Route::put('/{id?}', [AgendaController::class, 'update'])->name('update');
            Route::delete('/{id?}', [AgendaController::class, 'destroy'])->name('destroy');
            Route::post('/', [AgendaController::class, 'store'])->name('store');
        });
        Route::prefix('type')->name('type.')->group(function () {
            Route::get('/', [TypeController::class, 'index'])->name('index');
            Route::get('/all', [AgendaController::class, 'all'])->name('all');
            Route::get('/data-table', [TypeController::class, 'dataTable'])->name('data-table');
            Route::get('/{id?}', [TypeController::class, 'show'])->name('show');
            Route::put('/{id?}', [TypeController::class, 'update'])->name('update');
            Route::delete('/{id?}', [TypeController::class, 'destroy'])->name('destroy');
            Route::post('/', [TypeController::class, 'store'])->name('store');
        });
        Route::prefix('priority')->name('priority.')->group(function () {
            Route::get('/', [PriorityController::class, 'index'])->name('index');
            Route::get('/all', [AgendaController::class, 'all'])->name('all');
            Route::get('/data-table', [PriorityController::class, 'dataTable'])->name('data-table');
            Route::get('/{id?}', [PriorityController::class, 'show'])->name('show');
            Route::put('/{id?}', [PriorityController::class, 'update'])->name('update');
            Route::delete('/{id?}', [PriorityController::class, 'destroy'])->name('destroy');
            Route::post('/', [PriorityController::class, 'store'])->name('store');
        });
        Route::prefix('menu')->name('menu.')->group(function () {
            Route::get('/', [MenuController::class, 'index'])->name('index');
            Route::get('/data-table', [MenuController::class, 'dataTable'])->name('data-table');
            Route::get('/{id?}', [MenuController::class, 'show'])->name('show');
            Route::put('/{id?}', [MenuController::class, 'update'])->name('update');
            Route::delete('/{id?}', [MenuController::class, 'destroy'])->name('destroy');
            Route::post('/', [MenuController::class, 'store'])->name('store');
        });
        Route::prefix('role')->name('role.')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::get('/data-table', [RoleController::class, 'dataTable'])->name('data-table');
            Route::get('/{id?}', [RoleController::class, 'show'])->name('show');
            Route::put('/{id?}', [RoleController::class, 'update'])->name('update');
            Route::delete('/{id?}', [RoleController::class, 'destroy'])->name('destroy');
            Route::post('/', [RoleController::class, 'store'])->name('store');
        });
        Route::prefix('sincerely-word')->name('sincerely-word.')->group(function () {
            Route::get('/', [SincerelyWordController::class, 'index'])->name('index');
            Route::get('/all', [SincerelyWordController::class, 'all'])->name('all');
            Route::get('/data-table', [SincerelyWordController::class, 'dataTable'])->name('data-table');
            Route::get('/{id?}', [SincerelyWordController::class, 'show'])->name('show');
            Route::put('/{id?}', [SincerelyWordController::class, 'update'])->name('update');
            Route::delete('/{id?}', [SincerelyWordController::class, 'destroy'])->name('destroy');
            Route::post('/', [SincerelyWordController::class, 'store'])->name('store');
        });
    });
});
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/register', [AuthController::class, 'signup'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});
