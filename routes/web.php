<?php

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('/tasks')->group(function () {
    Route::get('', 'TasksController@index');
    Route::get('list', 'TasksController@taskList');
    Route::get('{task}', 'TasksController@show');
    Route::post('store', 'TasksController@store')->middleware('admin');
    Route::patch('{task}', 'TasksController@update')->middleware('admin');
    Route::patch('{task}/toggle', 'TasksController@toggleStatus');
    Route::post('destroy', 'TasksController@destroyMass')->middleware('admin');
    Route::delete('{task}/destroy', 'TasksController@destroy')->middleware('admin');
});

/*
 * Current user
 * */
Route::prefix('/user')->group(function () {
    Route::get('', 'CurrentUserController@show');
    Route::patch('', 'CurrentUserController@update');
    Route::patch('/password', 'CurrentUserController@updatePassword');
});

/*
 * File upload (e.g. avatar)
 * */
Route::post('/files/store', 'FilesController@store');
Route::get('users', 'CurrentUserController@users');