<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('setup', function () {
    return view('front.setup');
});

Route::get('/', function () {
	return view('front.index');
});

Route::get('form', function () {
	return view('front.form');
});

Route::get('run-setup', 'FrontController@runSetup');
Route::post('submit-form', 'FrontController@submitForm');
