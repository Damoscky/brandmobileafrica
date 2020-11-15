<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function($router){

    /** Cache */
    Route::get('/clear-cache', function() {
        Artisan::call('cache:clear');
        Artisan::call('config:cache');
        return "Cache is cleared";
    });

    Route::get('/test', function(){
        return "Hello";
    });

    /** QUESTION ROUTE **/
    Route::group(['prefix' => 'question'], function($router){
        Route::get('/', 'v1\Question\QuestionController@index');
        Route::get('/{id}', 'v1\Question\QuestionController@show');
        Route::get('/filter/{categoryid}', 'v1\Question\QuestionController@filterQuestion');
        Route::post('/store', 'v1\Question\QuestionController@store');
        Route::put('/update/{id}', 'v1\Question\QuestionController@update');
        Route::delete('/delete/{id}', 'v1\Question\QuestionController@destroy');
        Route::post('/upload', 'v1\Question\QuestionController@uploadQuestion');
    });

    /** CATEGORY ROUTE **/
    Route::group(['prefix' => 'category'], function($router){
        Route::get('/', 'v1\Category\CategoryController@index');
        Route::post('/store', 'v1\Category\CategoryController@store');
        Route::get('/{id}', 'v1\Category\CategoryController@show');
    });

    /** Choice Route **/
    Route::group(['prefix' => 'choice'], function($router){
        Route::post('/store', 'v1\Choice\ChoiceController@store');
        Route::put('/update/{id}', 'v1\Choice\ChoiceController@update');
        Route::delete('/delete/{id}', 'v1\Choice\ChoiceController@destroy');
    });
});
