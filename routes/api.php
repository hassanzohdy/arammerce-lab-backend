<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'namespace' => 'Api',
], function () {
    Route::post('/register', 'Auth\RegistrationController@index');
    Route::post('/login', 'Auth\LoginController@index');

    // polls
    Route::get('/polls', 'Polls\PollsController@index');
    Route::get('/polls/{id}', 'Polls\PollsController@show');
    Route::post('/polls/{id}/vote', 'Polls\PollsController@vote');
    Route::get('/polls/{pollId}/{answerId}/votes', 'Polls\PollsController@votes');

    // posts
    Route::get('/posts', 'Posts\PostsController@index');
    Route::post('/posts/create', 'Posts\PostsController@create');
    Route::post('/posts/update/{id}', 'Posts\PostsController@update');
    Route::get('/posts/{id}', 'Posts\PostController@show');
    Route::get('/posts/{id}/comments', 'Posts\PostCommentsController@index');

    // likes
    // Route::get('/posts/{id}/like/{type}', 'Posts\PostController@like');

    // tags
    Route::get('/tags/{tag}', 'Posts\TagsController@index');

    Route::group([
        'prefix' => '/management',
        'namespace' => 'Management',
    ], function () {
        Route::resource('/polls', 'Polls\PollsController');
        Route::resource('/users', 'Users\UsersController');
        Route::resource('/Tasks', 'Tasks\TasksController');
        Route::resource('/tags', 'Posts\TagsController');
        Route::resource('/posts', 'Posts\PostsController');
    });
});
