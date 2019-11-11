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

Route::group(['as' => 'api.'], function () {
    Route::get('suppliers/{id?}', 'API\SupplierController@get')->name('suppliers.get')->where('id', '\d+');
    Route::post('suppliers', 'API\SupplierController@post')->name('suppliers.post');
    Route::delete('suppliers/{id}', 'API\SupplierController@delete')->name('suppliers.delete')->where('id', '\d+');
    Route::patch('suppliers/{id}', 'API\SupplierController@patch')->name('suppliers.patch')->where('id', '\d+');
    Route::put('suppliers/{id}', 'API\SupplierController@patch')->name('suppliers.put')->where('id', '\d+');
    Route::get('suppliers/total', 'API\SupplierController@total')->name('suppliers.total');
});
