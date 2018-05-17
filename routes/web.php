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

Route::namespace('User')->group(function() {
    
    Route::prefix('user')->as('user.friend.')->group(function(){
        Route::get('/friend', 'FriendController@index')->name('index');
        Route::post('/friend/submit', 'FriendController@submit')->name('submit');

    });
    Route::resource('user', 'UserController')->except(['index', 'create', 'store']);
});

Route::get('/search', 'SearchController')->name('search');

Route::get('/', 'HomeController@index')->name('index');
Route::get('/logout', function () {
    auth()->logout();
});
