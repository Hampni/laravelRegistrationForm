<?php

use Illuminate\Support\Facades\Route;

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


Route::group(['middleware' => ['web']], function () {
    Route::get('/', 'RegistrationFormController@index');
    Route::get('/members', 'MembersController@index');
    Route::get('/adminPanel', 'AdminPanelController@index')->middleware('auth');
    Route::get('/update/{id}', 'AdminPanelController@update')->middleware('auth');
    Route::get('/addMember', 'AdminPanelController@add')->middleware('auth');
    Auth::routes();
});
