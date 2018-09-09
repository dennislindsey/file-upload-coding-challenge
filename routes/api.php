<?php

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

Route::get('file', 'FileController@index')->name('api.file.index');
Route::post('file', 'FileController@store')->name('api.file.store');
Route::patch('file/{storedFile}', 'FileController@update')->name('api.file.update');
Route::delete('file/{storedFile}', 'FileController@destroy')->name('api.file.destroy');
