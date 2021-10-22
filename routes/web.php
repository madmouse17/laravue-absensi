<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Pegawai\HomeController;
use App\Http\Controllers\Pegawai\AbsensiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });
Route::get('/', function () {
    return Redirect::route('login');
});

Route::group(['prefix' => 'admin',  'middleware' => ['auth', 'role:admin']], function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Admin/Dashboard');
    })->name('dashboard');

    //RETURN JSON
    Route::get('/user/json', [UserController::class, 'json']);
    Route::get('/position/json', [PositionController::class, 'json']);
    Route::get('/employe/json', [EmployeController::class, 'json']);

    //Delete All
    Route::delete('user/destroy-all/{id}', [UserController::class, 'deleteAll'])->name('user.deleteAll');
    Route::delete('position/destroy-all/{id}', [PositionController::class, 'deleteAll'])->name('position.deleteAll');
    Route::delete('employe/destroy-all/{id}', [EmployeController::class, 'deleteAll'])->name('employe.deleteAll');


    Route::resource('/user', UserController::class);
    Route::resource('/position', PositionController::class);
    Route::resource('/employe', EmployeController::class);

    Route::resource('/location', LocationController::class);
});
Route::group(['prefix' => 'employe',  'middleware' => ['auth', 'role:pegawai']], function () {
    Route::post('/attendance/out', [AttendanceController::class, 'out'])->name('attendance.out');
    Route::post('/attendance/permission', [AttendanceController::class, 'permission'])->name('attendance.permission');

    //json
    Route::get('/absensi/json', [AbsensiController::class, 'json']);

    Route::get('/presensi/permission/', ['as' => 'permission', HomeController::class, 'permission'])->name('presensi.permission');
    Route::resource('/presensi', HomeController::class);
    Route::resource('/attendance', AttendanceController::class);
    Route::resource('/absensi', AbsensiController::class);
});


require __DIR__ . '/auth.php';
