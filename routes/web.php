<?php

use Illuminate\Support\Facades\Auth;
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
    Route::get('/', 'RegistrationFormController@index')->name('homepage');
    Route::get('/members', 'MembersController@index')->name('members');
    Route::get('/adminPanel', 'AdminPanelController@index')->middleware('auth')->name('admin_panel');
    Route::get('/update/{id}', 'AdminPanelController@update')->middleware('auth')->name('update_member');
    Route::get('/addMember', 'AdminPanelController@add')->middleware('auth')->name('add_member');
    Auth::routes();
});
