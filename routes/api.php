<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register', 'API\RegisterController@register');
Route::middleware('auth:api', 'throttle:60,1')->group(function () {
    Route::get('user', function(Request $request) {
        return $request->user();
    });
    Route::post('post', 'API\PostController@post');
    Route::post('get_message', 'API\GetMessageController@get_message');
});
