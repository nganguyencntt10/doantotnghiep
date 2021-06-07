<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::prefix('service')->group(function () {
	// lấy ra tất cả dịch vụ
	Route::get('/getall', 'Admin\ServicesController@getall')->name('admin.service.getall');
	Route::get('/getallwith', 'Admin\ServicesController@getallwith')->name('admin.service.getallwith');
});

Route::prefix('serviceprocedure')->group(function () {
	// lấy ra tất cả dịch vụ
	Route::get('/getall', 'Admin\ServicesController@getallprocedure')->name('admin.serviceprocedure.getall');
});

Route::prefix('room')->group(function () {
	// lấy ra tất cả phòng
	Route::get('/getall', 'Admin\RoomController@getall')->name('admin.room.getall');
	Route::get('/getById', 'Admin\RoomController@getById')->name('admin.room.getById');
});

Route::prefix('customer')->group(function () {
	// lấy ra tất cả phòng
	Route::get('/getall', 'Admin\CustomerController@getall')->name('admin.customer.getall');
});



