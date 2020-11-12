<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function($router){

    Route::get('/test', function(){
        return "Hello";
    });

    /** QUESTION ROUTE **/
    Route::group(['prefix' => 'question'], function($router){
        Route::get('/', 'v1\Question\QuestionController@index');
        Route::post('/store', 'v1\Question\QuestionController@store');
    });
});
