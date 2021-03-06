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


Route::group(['namespace' => 'Auth', 'middleware' => ['guest:admin', 'guest:web']], function () {
    Route::get('login', 'AdminLoginController@showLoginForm');
    Route::post('login', 'AdminLoginController@login')->name('admin.login.submit');
});
Route::group(['namespace' => 'admin'], function () {
    Route::get('groups', 'AdminController@groups');
    Route::get('group/{id}/requests', 'AdminController@group_requests');
    Route::get('{groupID}/requestUser/{id}/accept', 'AdminController@accept_request');
    Route::get('{groupID}/requestUser/{id}/reject', 'AdminController@reject_request');
    Route::get('createGroup', 'AdminController@view_create_group');
    Route::post('create', 'AdminController@create_group')->name('admin.create_group');
    Route::get('groupMembers/{id}', 'AdminController@group_members');
    Route::get('{memberID}/remove_member/{groupID}', 'AdminController@remove_group_member');
});



Route::group(['middleware' => 'auth'], function () {
    Route::get('/getposts', 'user\PostController@index');
    Route::get('post-comment/{id}', 'CommentController@index');
    Route::get('post-likes/{id}', 'user\PostController@getLikes');
    Route::get('/posts', function () {
        return view('admin.posts');
    });
});
