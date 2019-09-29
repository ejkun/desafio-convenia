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
    Route::get('fornecedores/{id?}', 'API\FornecedorController@get')->name('get.fornecedores');
    Route::post('fornecedores', 'API\FornecedorController@post')->name('post.fornecedores');
    Route::delete('fornecedores/{id}', 'API\FornecedorController@delete')->name('delete.fornecedores');
    Route::patch('fornecedores/{id}', 'API\FornecedorController@patch')->name('patch.fornecedores');
    Route::put('fornecedores/{id}', 'API\FornecedorController@patch')->name('put.fornecedores');
});
