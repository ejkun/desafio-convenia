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

Route::group(['as' => 'web.'], function () {
    Route::post('suppliers/activate/{token}', 'SupplierController@activate')->name('activate.suppliers');
    Route::get('suppliers/activate/{token}', 'SupplierController@showActivation')->name('show_activation.suppliers');
});
