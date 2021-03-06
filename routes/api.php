<?php

use App\Http\Controllers\Admin\AdminController;
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

Route::get('/user/all/{limit?}', 'Admin\AdminController@index');
Route::post('/user/new', 'Admin\AdminController@store');
Route::put('/user/{id}', 'Admin\AdminController@update');
Route::delete('/user/{id}', 'Admin\AdminController@destroy');

Route::get('/user/{id}', 'User\UserController@show');

Route::get('/service/all/{limit?}', 'Service\HomeController@index');
Route::post('/service/new', 'Service\HomeController@store');
Route::get('/service/{id}', 'Service\HomeController@show');
Route::put('/service/{id}', 'Service\HomeController@update');
Route::delete('/service/{id}', 'Service\HomeController@destroy');

Route::get('/task/by/{service}/{limit?}', 'Task\DefaultTaskController@index');
Route::post('/task/{service}/new', 'Task\DefaultTaskController@store');
Route::get('/task/{id}', 'Task\DefaultTaskController@show');
Route::put('/task/{id}', 'Task\DefaultTaskController@update');
Route::delete('/task/{id}', 'Task\DefaultTaskController@destroy');
Route::post('/task/batchRemove', 'Task\DefaultTaskController@batchDestroy');


Route::get('/assignment/all/{limit?}', 'Assignment\AssignmentController@index');
Route::get('/assignment/by/{client}/{limit?}', 'Assignment\AssignmentController@indexByClient');
Route::post('/assignment/{serviceId}/{clientId}', 'Assignment\AssignmentController@store');
Route::get('/assignment/{id}', 'Assignment\AssignmentController@show');
Route::put('/assignment/{id}', 'Assignment\AssignmentController@update');
Route::delete('/assignment/{id}', 'Assignment\AssignmentController@destroy');

Route::get('/task/active/by/{assignment}/{limit?}', 'Task\ActiveTaskController@index');
Route::post('/task/active/{assignment}/new', 'Task\ActiveTaskController@store');
Route::get('/task/active/{id}', 'Task\ActiveTaskController@show');
Route::put('/task/active/{id}', 'Task\ActiveTaskController@update');
Route::delete('/task/active/{id}', 'Task\ActiveTaskController@destroy');
Route::post('/task/active/batchRemove', 'Task\ActiveTaskController@batchDestroy');

Route::get('/comments/assignment/{assignment}', 'Comment\CommentController@indexByAssignment');
Route::get('/comments/{id}', 'Comment\CommentController@show');
Route::get('/comments/task/{task}', 'Comment\CommentController@indexByTask');
Route::post('/comments/{isAssignmnt}/{id}/new', 'Comment\CommentController@store');
Route::put('/comments/{id}', 'Comment\CommentController@update');
Route::delete('/comments/{id}', 'Comment\CommentController@destroy');

Route::get('/transactions/{limit?}', 'Transaction\TransactionController@index');
Route::get('/transactions/by/{assignment}', 'Transaction\TransactionController@indexByAssignment');
Route::get('/transaction/{id}', 'Transaction\TransactionController@show');
Route::post('/transactions/new', 'Transaction\TransactionController@store');
Route::put('/transactions/{assignment}', 'Transaction\TransactionController@update');
Route::delete('/transactions/{assignment}', 'Transaction\TransactionController@destroy');

Route::get('/customers/{userId}', 'Customer\CustomerController@index');
Route::get('/customers/createIntent/{userId}', 'Customer\CustomerController@createIntent');

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function() {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');

    Route::get('get', 'AuthController@me');
    Route::get('refresh', 'AuthController@refresh');
});
