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
        Route::post('refresh', 'Auth\AuthController@refresh');
        Route::post('me', 'Auth\AuthController@me');

    });

    Route::group([

        'middleware' => 'api',
        'prefix' => 'survey'

    ], function () {

        Route::post('create', 'SurveyController@store');
        Route::get('index', 'SurveyController@index');

    });
});

