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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'App\Http\Controllers\MainController@home');

Route::post('/app/create_tag', 'App\Http\Controllers\MainController@createTag');
Route::post('/app/edit_tag', 'App\Http\Controllers\MainController@editTag');
Route::post('/app/delete_tag', 'App\Http\Controllers\MainController@deleteTag');
Route::post('/app/upload', 'App\Http\Controllers\MainController@upload');
Route::post('/app/delete_image', 'App\Http\Controllers\MainController@deleteImage');
Route::get('/app/get_tags', 'App\Http\Controllers\MainController@getTags');

Route::post('/app/create_category', 'App\Http\Controllers\MainController@createCategory');
Route::post('/app/edit_category', 'App\Http\Controllers\MainController@editCategory');
Route::post('/app/delete_category', 'App\Http\Controllers\MainController@deleteCategory');
Route::get('/app/get_categories', 'App\Http\Controllers\MainController@getCategories');

Route::any('{slug}', function() {
    return view('welcome');
});