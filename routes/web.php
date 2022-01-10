<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DailyActivityController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('welcome', [
		'active' => 'home'
	]);
})->middleware('auth');

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::prefix('departement')->name('departement.')->middleware('admin')->group(function () {
	Route::get('/', [DepartementController::class, 'index'])->name('index');
	Route::post('/', [DepartementController::class, 'store'])->name('store');
	Route::get('/create', [DepartementController::class, 'create'])->name('create');
	Route::get('/edit/{departement}', [DepartementController::class, 'edit'])->name('edit');
	Route::post('/edit/{departement}', [DepartementController::class, 'update'])->name('update');
});

Route::prefix('position')->name('position.')->middleware('admin')->group(function () {
	Route::get('/', [PositionController::class, 'index'])->name('index');
	Route::post('/', [PositionController::class, 'store'])->name('store');
	Route::get('/create', [PositionController::class, 'create'])->name('create');
	Route::get('/edit/{position}', [PositionController::class, 'edit'])->name('edit');
	Route::post('/edit/{position}', [PositionController::class, 'update'])->name('update');
});

Route::prefix('employee')->name('employee.')->middleware('admin')->group(function () {
	Route::get('/', [EmployeeController::class, 'index'])->name('index');
	Route::post('/', [EmployeeController::class, 'store'])->name('store');
	Route::get('/create', [EmployeeController::class, 'create'])->name('create');
	Route::get('/edit/{employee}', [EmployeeController::class, 'edit'])->name('edit');
	Route::post('/edit/{employee}', [EmployeeController::class, 'update'])->name('update');
	Route::get('/show/{employee}', [EmployeeController::class, 'show'])->name('show');
});

Route::prefix('user')->name('user.')->middleware('admin')->group(function () {
	Route::get('/', [UserController::class, 'index'])->name('index');
	Route::post('/', [UserController::class, 'store'])->name('store');
	Route::get('/create', [UserController::class, 'create'])->name('create');
	Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
	Route::post('/edit/{user}', [UserController::class, 'update'])->name('update');
	Route::get('/show/{user}', [UserController::class, 'show'])->name('show');
});

Route::prefix('daily-activity')->name('daily-activity.')->middleware('auth')->group(function () {
	Route::get('/', [DailyActivityController::class, 'index'])->name('index');
	Route::post('/', [DailyActivityController::class, 'store'])->name('store');
	Route::get('/create', [DailyActivityController::class, 'create'])->name('create');
	Route::get('/edit/{dailyActivity}', [DailyActivityController::class, 'edit'])->name('edit');
	Route::post('/edit/{dailyActivity}', [DailyActivityController::class, 'update'])->name('update');
	Route::get('/show/{dailyActivity}', [DailyActivityController::class, 'show'])->name('show');
});
