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
        Route::get('friend/sidebar', 'FriendController@ajaxSidebar')->name('sidebar');
        Route::post('/friend/submit', 'FriendController@submit')->name('submit');
        
    });
    Route::resource('user', 'UserController')->except(['index', 'create', 'store']);
    Route::get('/notification/{notification_id}', 'UserController@markRead')->name('user.notification.read');
});
Route::post("conversation/{conversation}/message", "ConversationController@message")->name("conversation.message");
Route::get("conversation/{conversation}/sidebar", "ConversationController@showSidebar")->name("conversation.sidebar");
Route::resource('conversation', 'ConversationController');
Route::get("conversation/with/{friend}", "ConversationController@with")->name("conversation.with");

Route::get('/search', 'SearchController')->name('search');

Route::get('/', 'HomeController@index')->name('index');
