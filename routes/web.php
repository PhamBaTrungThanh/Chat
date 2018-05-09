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


Auth::routes();
Route::get('/wellcome', 'HomeController@wellcome')->name('wellcome');
Route::get('/splash', 'HomeController@splash')->name('splash');
Route::get('/', 'HomeController@index')->name('index');

