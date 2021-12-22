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
    
    Route::post('/create_user', 'App\Http\Controllers\MainController@createUser');
    Route::post('/edit_user', 'App\Http\Controllers\MainController@editUser');
    Route::post('/delete_user', 'App\Http\Controllers\MainController@deleteUser');
    Route::get('/get_users', 'App\Http\Controllers\MainController@getUsers');

    Route::post('/create_role', 'App\Http\Controllers\MainController@createRole');
    Route::post('/edit_role', 'App\Http\Controllers\MainController@editRole');
    Route::post('/delete_role', 'App\Http\Controllers\MainController@deleteRole');
    Route::get('/get_roles', 'App\Http\Controllers\MainController@getRoles');
    
});

Route::post('app/admin_login', 'App\Http\Controllers\MainController@adminLogin');
// Route::get('/home', 'App\Http\Controllers\MainController@home');

Route::get('/logout', 'App\Http\Controllers\MainController@logout');
Route::get('/', 'App\Http\Controllers\MainController@index');
Route::any('/{slug}', 'App\Http\Controllers\MainController@index');