<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Auth::routes(['verify' => true]);

Route::post('adduser', 'AdduserController@adduser')->middleware('json');
Route::post('signin', 'SigninController@login')->middleware('json')->name('signin');
Route::apiResource('products', 'ProductController')->middleware(['auth:sanctum', 'json']);
//Route::get('statistic', 'ProductController@getStatistic')->middleware(['auth:sanctum', 'json']);
Route::get('statistic', 'ProductController@getStatistic')->middleware('json');
Route::get('testmail', 'AdduserController@testMail');

