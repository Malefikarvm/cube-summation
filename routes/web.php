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

Route::get('home', function () {
    return view('welcome');
});

Route::get('/', 'Index@index');

Route::post('/update', 'Index@update');

Route::post('/query', 'Index@query');

Route::post('/set-test-cases', 'Index@setTestCases');

Route::post('/intitialize-matrix', 'Index@initializeMatrix');
