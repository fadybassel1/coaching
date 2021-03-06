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

Auth::routes();

//home page routes...
Route::group(['namespace' => 'user', 'prefix' => 'user'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/api/group-stat', 'HomeController@group_stat');
    Route::get('/api/recent-posts', 'HomeController@recent_posts');
    Route::get('/api/suggested-groups', 'HomeController@suggested_groups');
    Route::post('api/posts/{id}/like', 'PostController@addLike');
    Route::delete('api/posts/{id}/like', 'PostController@deleteLike');
    Route::post('/addNewPost', 'PostController@addNewPost');
    Route::get('/api/view-user-groups', 'GroupController@userGroups');
    Route::get('/api/search-groups/{keyword}', 'GroupController@showGroups');
    Route::get('/api/group-posts/{id}', 'GroupController@showPosts');
    Route::get('/group/{id}', 'GroupController@show');
    Route::get('/requestGroupJoin/{id}', 'GroupController@requestGroupJoin');
});
Route::post('user/addComment', 'CommentController@addComment');
