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
    Route::get('fornecedores/{id?}', 'API\FornecedorController@get')->name('fornecedores.get')->where('id', '\d+');
    Route::post('fornecedores', 'API\FornecedorController@post')->name('fornecedores.post');
    Route::delete('fornecedores/{id}', 'API\FornecedorController@delete')->name('fornecedores.delete')->where('id', '\d+');
    Route::patch('fornecedores/{id}', 'API\FornecedorController@patch')->name('fornecedores.patch')->where('id', '\d+');
    Route::put('fornecedores/{id}', 'API\FornecedorController@patch')->name('fornecedores.put')->where('id', '\d+');
    Route::get('fornecedores/total', 'API\FornecedorController@total')->name('fornecedores.total');
});
