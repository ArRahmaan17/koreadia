<?php

use App\Http\Controllers\Dev\AuthController;
use App\Http\Controllers\Dev\EmployeeController;
use App\Http\Controllers\Dev\EventScheduleController;
use App\Http\Controllers\Dev\Mail\AgendaController;
use App\Http\Controllers\Dev\Mail\PriorityController;
use App\Http\Controllers\Dev\Mail\TypeController;
use App\Http\Controllers\Dev\MailOutController;
use App\Http\Controllers\Dev\MailTransactionController;
use App\Http\Controllers\Dev\MenuController;
use App\Http\Controllers\Dev\OrganizationController;
use App\Http\Controllers\Dev\RoleController;
use App\Http\Controllers\Dev\RoleUserController;
use App\Http\Controllers\Dev\SincerelyWordController;
use App\Http\Controllers\Dev\UserController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\MailController;
use App\Http\Controllers\Frontend\TrackingController;
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

Route::get('/master/agenda/all', [AgendaController::class, 'all'])->name('master.agenda.all')->middleware('public.limiter');
Route::get('/master/type/all', [TypeController::class, 'all'])->name('master.type.all')->middleware('public.limiter');
Route::get('/master/priority/all', [PriorityController::class, 'all'])->name('master.priority.all')->middleware('public.limiter');
Route::get('/event/timeline/{id?}', [EventScheduleController::class, 'showTimeline'])->name('event.show-timeline');
Route::post('/mail/in', [MailTransactionController::class, 'store'])->name('mail.in.store')->middleware('public.limiter');
Route::middleware('check.auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::prefix('mail')->name('mail.')->group(function () {
        Route::prefix('in')->name('in.')->group(function () {
            Route::get('/', [MailTransactionController::class, 'index'])->name('index');
            Route::get('/report/{id?}', [MailTransactionController::class, 'reportFile'])->name('report');
            Route::put('/request-notified/{id?}', [MailTransactionController::class, 'requestedNotified'])->name('request-notified');
            Route::put('/show-file/{folder?}/{id?}', [MailTransactionController::class, 'showFile'])->name('show-file');
            Route::put('/status-update/{id?}', [MailTransactionController::class, 'statusUpdate'])->name('status-update');
            Route::get('/data-table', [MailTransactionController::class, 'dataTable'])->name('data-table');
            Route::get('/{id?}', [MailTransactionController::class, 'show'])->name('show');
            Route::put('/{id?}', [MailTransactionController::class, 'update'])->name('update');
            Route::delete('/{id?}', [MailTransactionController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('out')->name('out.')->group(function () {
            Route::get('/', [MailOutController::class, 'index'])->name('index');
            Route::get('/data-table', [MailOutController::class, 'dataTable'])->name('data-table');
            Route::get('/{id?}', [MailOutController::class, 'show'])->name('show');
            Route::put('/{id?}', [MailOutController::class, 'update'])->name('update');
            Route::delete('/{id?}', [MailOutController::class, 'destroy'])->name('destroy');
            Route::post('/', [MailOutController::class, 'store'])->name('store');
        });
    });
    Route::prefix('event')->name('event.')->group(function () {
        Route::get('/', [EventScheduleController::class, 'index'])->name('index');
        Route::get('/data-table', [EventScheduleController::class, 'dataTable'])->name('data-table');
        Route::put('/event-update/{id?}', [EventScheduleController::class, 'requestBroadcast'])->name('event-update');
        Route::get('/{id?}', [EventScheduleController::class, 'show'])->name('show');
        Route::put('/{id?}', [EventScheduleController::class, 'update'])->name('update');
        Route::delete('/{id?}', [EventScheduleController::class, 'destroy'])->name('destroy');
        Route::post('/', [EventScheduleController::class, 'store'])->name('store');
    });
    Route::prefix('master')->name('master.')->group(function () {
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
        Route::prefix('employee')->name('employee.')->group(function () {
            Route::get('/', [EmployeeController::class, 'index'])->name('index');
            Route::get('/all', [EmployeeController::class, 'all'])->name('all');
            Route::get('/data-table', [EmployeeController::class, 'dataTable'])->name('data-table');
            Route::get('/{id?}', [EmployeeController::class, 'show'])->name('show');
            Route::put('/{id?}', [EmployeeController::class, 'update'])->name('update');
            Route::delete('/{id?}', [EmployeeController::class, 'destroy'])->name('destroy');
            Route::post('/', [EmployeeController::class, 'store'])->name('store');
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
            Route::get('/all', [RoleController::class, 'all'])->name('all');
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
        Route::prefix('organization')->name('organization.')->group(function () {
            Route::get('/', [OrganizationController::class, 'index'])->name('index');
            Route::get('/all', [OrganizationController::class, 'all'])->name('all');
            Route::get('/data-table', [OrganizationController::class, 'dataTable'])->name('data-table');
            Route::get('/{id?}', [OrganizationController::class, 'show'])->name('show');
            Route::put('/{id?}', [OrganizationController::class, 'update'])->name('update');
            Route::delete('/{id?}', [OrganizationController::class, 'destroy'])->name('destroy');
            Route::post('/', [OrganizationController::class, 'store'])->name('store');
        });
        Route::prefix('role-user')->name('role-user.')->group(function () {
            Route::get('/', [RoleUserController::class, 'index'])->name('index');
            Route::get('/all', [RoleUserController::class, 'all'])->name('all');
            Route::get('/all-user', [RoleUserController::class, 'allUser'])->name('all-user');
            Route::get('/data-table', [RoleUserController::class, 'dataTable'])->name('data-table');
            Route::get('/{id?}', [RoleUserController::class, 'show'])->name('show');
            Route::put('/{id?}', [RoleUserController::class, 'update'])->name('update');
            Route::delete('/{id?}', [RoleUserController::class, 'destroy'])->name('destroy');
            Route::post('/', [RoleUserController::class, 'store'])->name('store');
        });
        Route::prefix('user')->name('user.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/all', [UserController::class, 'all'])->name('all');
            Route::get('/data-table', [UserController::class, 'dataTable'])->name('data-table');
            Route::get('/{id?}', [UserController::class, 'show'])->name('show');
            Route::put('/{id?}', [UserController::class, 'update'])->name('update');
            Route::delete('/{id?}', [UserController::class, 'destroy'])->name('destroy');
            Route::post('/', [UserController::class, 'store'])->name('store');
        });
    });
});
Route::middleware(['check.un-auth'])->group(function () {
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('/process-password', [AuthController::class, 'executeResetPassword'])->name('process-password')->middleware('throttle:3,1');
    Route::post('/password-update', [AuthController::class, 'passwordUpdate'])->name('password-update');
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware('throttle:3,1');
    Route::get('/register', [AuthController::class, 'signup'])->name('signup');
    Route::post('/register', [AuthController::class, 'register'])->name('register')->middleware('throttle:3,1');
});
Route::get('/', [FrontendController::class, 'home'])->name('fe-home');
Route::get('/tracking', [TrackingController::class, 'tracking'])->name('fe-tracking');
Route::get('/tracking-surat', [MailTransactionController::class, 'tracking'])->name('tracking')->middleware('public.limiter');
Route::get('/mail', [MailController::class, 'index'])->name('send-mail');
