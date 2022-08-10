<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MemberController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('members', 'Api\MemberController@index');
Route::get('members/all', 'Api\MemberController@getAllMembers');
Route::get('members/countMembers', 'Api\MemberController@countMembers');
Route::post('members/changeDisplay/{memberId}/{toDo}', 'Api\MemberController@changeDisplay');

Route::get('countries', 'Api\CountryController@index');

Route::post('saveFirstStep', 'Api\FirstStepController@index');
Route::post('saveSecondStep', 'Api\SecondStepController@index');


