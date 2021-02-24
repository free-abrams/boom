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

Route::group(['namespace' => 'App\Http\Controllers'], function () {
	Route::group(['middleware' => 'guest'], function () {
		Route::get('auth', 'AuthController@getLoginForm')->name('getLoginForm');
		Route::post('auth', 'AuthController@login')->name('login');
	});
	
	Route::group(['middleware' => ['login', 'adminRbac']], function() {
		Route::any('logout', 'AuthController@logout')->name('logout');
		Route::get('/', 'HomeController@index')->name('index');
		Route::get('/error', 'HomeController@error')->name('index.error');
		Route::resource('index', 'IndexController');
		Route::resource('role', 'RoleController');
		Route::resource('permission', 'PermissionController');
	});
});
