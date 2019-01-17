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

/**
 * WEB INTERFACE ROUTES
 */
Route::group(['middleware' => 'web'], function() {

    Route::get("/", "UiController@showLogin")->name('login');

    Route::post("/", "UiController@doLogin");

    Route::get("/showsearch", "UiController@showSearch");

    Route::get("/dosearch", "UiController@doSearch");

    Route::post("/dosearch", "UiController@doSearch");

});