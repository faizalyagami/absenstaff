<?php

use Illuminate\Support\Facades\Route;

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


Route::group(['middleware' => 'adminCheck', 'prefix' => 'app'], function () {
    Route::post('/create_tag', 'App\Http\Controllers\MainController@createTag');
    Route::post('/edit_tag', 'App\Http\Controllers\MainController@editTag');
    Route::post('/delete_tag', 'App\Http\Controllers\MainController@deleteTag');
    Route::post('/upload', 'App\Http\Controllers\MainController@upload');
    Route::post('/delete_image', 'App\Http\Controllers\MainController@deleteImage');
    Route::get('/get_tags', 'App\Http\Controllers\MainController@getTags');
    
    Route::post('/create_category', 'App\Http\Controllers\MainController@createCategory');
    Route::post('/edit_category', 'App\Http\Controllers\MainController@editCategory');
    Route::post('/delete_category', 'App\Http\Controllers\MainController@deleteCategory');
    Route::get('/get_categories', 'App\Http\Controllers\MainController@getCategories');
    
    Route::post('/create_user', 'App\Http\Controllers\UserController@create');
    Route::post('/edit_user', 'App\Http\Controllers\UserController@edit');
    Route::post('/delete_user', 'App\Http\Controllers\UserController@delete');
    Route::get('/get_users', 'App\Http\Controllers\UserController@gets');

    Route::post('/create_role', 'App\Http\Controllers\MainController@createRole');
    Route::post('/edit_role', 'App\Http\Controllers\MainController@editRole');
    Route::post('/delete_role', 'App\Http\Controllers\MainController@deleteRole');
    Route::get('/get_roles', 'App\Http\Controllers\MainController@getRoles');


    Route::post('/create_position', 'App\Http\Controllers\PositionController@create');
    Route::post('/edit_position', 'App\Http\Controllers\PositionController@edit');
    Route::post('/delete_position', 'App\Http\Controllers\PositionController@delete');
    Route::get('/get_positions', 'App\Http\Controllers\PositionController@gets');

    Route::post('/create_departement', 'App\Http\Controllers\DepartementController@create');
    Route::post('/edit_departement', 'App\Http\Controllers\DepartementController@edit');
    Route::post('/delete_departement', 'App\Http\Controllers\DepartementController@delete');
    Route::get('/get_departements', 'App\Http\Controllers\DepartementController@gets');

    Route::post('/create_employee', 'App\Http\Controllers\EmployeeController@create');
    Route::post('/edit_employee', 'App\Http\Controllers\EmployeeController@edit');
    Route::post('/delete_employee', 'App\Http\Controllers\EmployeeController@delete');
    Route::get('/get_employees', 'App\Http\Controllers\EmployeeController@gets');
    
});

Route::post('app/admin_login', 'App\Http\Controllers\MainController@adminLogin');
// Route::get('/home', 'App\Http\Controllers\MainController@home');

Route::get('/logout', 'App\Http\Controllers\MainController@logout');
Route::get('/', 'App\Http\Controllers\MainController@index');
Route::any('/{slug}', 'App\Http\Controllers\MainController@index');