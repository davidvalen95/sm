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

header("Access-Control-Allow-Origin: http://localhost:4200");


header("Access-Control-Allow-Credentials: true");

//header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, authorization, Authorization, X-Csrf-Token");

Route::group(['middleware'=>'web'],function(){

    Route::match(array('GET', 'POST'), '/user/login', 'UserController@anyLogin');


});


Route::group(['middleware'=>['web', 'auth']],function(){


    Route::match(array('GET', 'POST'), '/app/top', 'AppController@anyTop');


    Route::match(array('GET', 'POST'), '/user/top', 'UserController@anyTop');
    Route::match(array('GET', 'POST'), '/user/op', 'UserController@anyOp');
    Route::match(array('GET', 'POST'), '/user/logout', 'UserController@anyLogout');
    Route::match(array('GET', 'POST'), '/user/auto-complete', 'UserController@anyAutoComplete');
    Route::match(array('GET', 'POST'), '/user/detail', 'UserController@anyDetailById');


    Route::match(array('GET', 'POST'), 'branch/top', 'BranchController@anyTop');
    Route::match(array('GET', 'POST'), 'branch/op', 'BranchController@anyOp');


    Route::match(array('GET', 'POST'), '/branch/config/web/top', 'BranchWebConfigurationController@anyTop');
    Route::match(array('GET', 'POST'), '/branch/config/web/op', 'BranchWebConfigurationController@anyOp');

    Route::match(array('GET', 'POST'), 'absence/top', 'AbsenceController@anyTop');
    Route::match(array('GET', 'POST'), 'absence/op', 'AbsenceController@anyOp');


    Route::match(array('GET', 'POST'), 'thread/top', 'ThreadController@anyTop');
    Route::match(array('GET', 'POST'), 'thread/op', 'ThreadController@anyOp');


});


