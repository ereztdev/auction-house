<?php

use Illuminate\Http\Request;
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

//Route::middleware('auth:api')->post('/add-item', 'ItemController@store');
//Route::post('/add-item', 'ItemController@store');
Route::post('/add-item', 'ItemController@store');
Route::post('/bid-item', 'BidController@store');
Route::post('/bid-user', 'BidController@getHighestBidUser');

