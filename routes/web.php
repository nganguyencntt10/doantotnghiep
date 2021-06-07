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

Route::get('/', 'DisplayCustomerController@index')->name('customer.index');
Route::get('services', 'DisplayCustomerController@services')->name('customer.services');
Route::get('service/{slug}', 'DisplayCustomerController@service')->name('customer.service');




Route::middleware(['AuthAdmin:auth'])->group(function () {
	Route::prefix('admin')->group(function () {
		// đăng nhập
		Route::get('/login', 'DisplayAdminController@login')->name('admin.login');
		Route::post('/login', 'AuthAdminController@login')->name('admin.login');
	});
});
Route::post('logout', 'AuthAdminController@logout')->name('admin.logout');
Route::middleware(['AuthAdmin:admin'])->group(function () {
	Route::prefix('admin')->group(function () {
		
		Route::get('/', 'DisplayAdminController@dashboard')->name('admin.dashboard');

		Route::prefix('services')->group(function () {
			Route::get('/', 'Admin\ServicesController@index')->name('admin.services.index');
			Route::post('/create', 'Admin\ServicesController@store')->name('admin.services.store');
		});

		Route::prefix('room')->group(function () {
			Route::get('/', 'Admin\RoomController@index')->name('admin.room.index');
			Route::post('/create', 'Admin\RoomController@store')->name('admin.room.store');
		});

		Route::prefix('customer')->group(function () {
			Route::get('/', 'Admin\CustomerController@index')->name('admin.customer.index');
			Route::post('/create', 'Admin\CustomerController@store')->name('admin.customer.store');
		});

	});
});

Route::middleware(['AuthAdmin:manage'])->group(function () {
	Route::prefix('manage')->group(function () {
		
		Route::get('/', 'DisplayAdminController@manager')->name('manage.dashboard');
	});
});