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

Route::prefix('rentorders')->group(function() {
    Route::get('/', 'RentOrdersController@index')->name("rentorders.index");
    Route::get('/create', 'RentOrdersController@create')->name("rentorders.create");
    Route::delete('/{id}/delete', 'RentOrdersController@destroy')->name("rentorders.destroy");
});
