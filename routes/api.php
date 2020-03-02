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

Route::middleware(['auth:api', 'force-json'])->get('user', function (Request $request) {
    return $request->user();
});

Route::middleware('force-json')->post('user/register', 'Auth\RegisterController@register');
Route::middleware('force-json')->post('user/login', 'Auth\LoginController@login');


Route::middleware(['auth:api', 'force-json'])->put('task/fib', 'TaskController@fibonacci');
Route::middleware(['auth:api', 'force-json'])->put('task/ip', 'TaskController@ip');
Route::middleware(['auth:api', 'force-json'])->get('status/{id}', 'StatusController@status');
