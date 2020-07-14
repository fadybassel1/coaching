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
    return view('admin.dashboard');
})->middleware('auth:admin')->name('admin.dashboard');


Route::group(['namespace' => 'Auth','middleware'=>['guest:admin','guest:web']], function () {
    Route::get('login', 'AdminLoginController@showLoginForm');
    Route::post('login', 'AdminLoginController@login')->name('admin.login.submit');
});


Route::get('/posts','PostController@index');
Route::get('post-comment/{id}','CommentController@index');
Route::get('post-comment-view/{id}','CommentController@viewComments');


Route::get('/postss',function(){
    return view('admin.posts');
});

