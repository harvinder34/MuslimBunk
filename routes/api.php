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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix' => 'v1'], function () {
	
	Route::post('login', 'Api\UserController@login');
	Route::post('register', 'Api\UserController@register');
	
	Route::resource('users', 'Api\UserController');
	Route::post('users/update', 'Api\UserController@update'); /* custom update with additional perms */
	
	Route::resource('listing', 'Api\ListingController');
	Route::any('listing/city/{city}', 'Api\ListingController@getListingByCity');
	Route::any('listing/roomate/{gender}/{max_flatmates}', 'Api\ListingController@getListingByFlatmates');
	Route::post('listing/monthlyBudget', 'Api\ListingController@getListingByMonthlyBudget');
	Route::post('listing/{orderBy}/{order}', 'Api\ListingController@getListingByOrder');
});