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

Route::resource('user', 'UserController')->except(['index', 'create', 'store']);
Route::prefix('search')->as('search.')->group(function() {
    Route::get('', 'SearchController@index')->name('index');
    Route::post('', 'SearchController@submit')->name('submit');
    Route::get('/result', 'SearchController@result')->name('result');
});

Route::get('/', 'HomeController@index')->name('index');
Route::get('/logout', function () {
    auth()->logout();
});
