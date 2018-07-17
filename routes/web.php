<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/home/{branchName?}', "WebPage\HomeController@getHome")->name('get.home');
Route::get('/visi-misi/', "WebPage\VisiMisiController@getVisiMisi")->name('get.visiMisi');
Route::get('/year-planning/{branchName?}', "WebPage\YearPlanningController@getYearPlanning")->name('get.yearPlanning');
Route::get('/event/{branchName?}', "WebPage\EventController@getEvent")->name('get.event');
Route::get('/contact-us/{branchName?}', "WebPage\ContactController@getContact")->name('get.contact');


Route:: get('/absence/generate', 'AbsenceController@generateAbsence');









