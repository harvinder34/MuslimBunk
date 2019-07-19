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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('home');
});
Auth::routes();

Route::get('/admin', function() {
	
	if (Auth::check() && Auth::user()->role == '1') {
		return redirect('/admin/dashboard');
	}
	return view('admin.login');
});
Route::group(['middleware' => 'App\Http\Middleware\Admin'], function() 
{
	Route::resource('/admin/dashboard', 'Admin\AdminController');
	
	Route::resource('/admin/user', 'Admin\UserController');
	Route::any('admin/user/deactivate/{id}', 'Admin\UserController@deactivate');
	Route::any('admin/user/activate/{id}', 'Admin\UserController@activate');
	Route::any('admin/user/status/{id}/{status}', 'Admin\UserController@status');
	
	Route::resource('/admin/listing', 'Admin\ListingController');
	Route::any('admin/listing/deactivate/{id}', 'Admin\ListingController@deactivate');
	Route::any('admin/listing/activate/{id}', 'Admin\ListingController@activate');
	Route::any('admin/listing/view/{id}', 'Admin\ListingController@view');	
	Route::any('admin/listing/status/{id}/{status}', 'Admin\ListingController@status');
	
});	
