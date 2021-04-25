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

Route::post('register', 'API\RegisterController@register');
//Route::post('post', 'API\PostController@post');
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->get('/post', function (Request $request) {
    return;
});
*/
Route::get('/user', function(Request $request) {
    return $request->user();
});

Route::middleware('auth:api', 'throttle:60,1')->group(function () {
    // この中に書いたルーティング全てに適用される
    Route::post('post', 'API\PostController@post');
});

Route::middleware('auth:api')->get('/receipt_status', function (Request $request) {
    return;
});                               
