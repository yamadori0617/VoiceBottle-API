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

Route::middleware('auth:api', 'throttle:60,1')->group(function () {
    Route::get('user', function(Request $request) {
        return $request->user();
    });
    Route::post('post', 'API\PostController@post');
    Route::get('get_message', 'API\GetMessageController@get_message');
});
