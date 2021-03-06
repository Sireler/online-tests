<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Router;

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




Route::namespace('Api')->group(function () {
    Route::group([

        'middleware' => 'api',
        'prefix' => 'auth'

    ], function () {

        Route::post('login', 'Auth\AuthController@login')->name('api.login');
        Route::post('logout', 'Auth\AuthController@logout');
        Route::post('register', 'Auth\AuthController@register')->middleware('guest');
        Route::get('refresh', 'Auth\AuthController@refresh');
        Route::post('me', 'Auth\AuthController@me');

    });

    Route::group([

        'middleware' => 'api',
        'prefix' => 'survey'

    ], function () {

        Route::post('create', 'SurveyController@store');
        Route::get('index', 'SurveyController@index');
        Route::delete('delete/{id}', 'SurveyController@delete');
        Route::get('get/{id}', 'SurveyController@get');
        Route::patch('update/{id}', 'SurveyController@update');
        Route::get('home', 'SurveyController@home');
        Route::get('start/{id}', 'SurveyController@start');

        Route::post('questions/create', 'QuestionController@store');
        Route::get('questions/index', 'QuestionController@index');
        Route::get('questions/get/{id}', 'QuestionController@get');
        Route::delete('questions/delete/{surveyId}/{questionId}', 'QuestionController@delete');
        Route::patch('questions/update/{id}', 'QuestionController@update');

        Route::delete('answers/{surveyId}/{answerId}', 'AnswerController@delete');
        Route::post('answers/update/{questionId}', 'AnswerController@update');

        Route::post('votes', 'VoteController@store');
        Route::get('votes/check/{id}', 'VoteController@check');
        Route::get('votes/{id}/responses', 'VoteController@responses');
    });
});

