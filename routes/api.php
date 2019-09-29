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

// Fornecedores
Route::get('fornecedores/{id?}', 'FornecedorController@get');
Route::post('fornecedores', 'FornecedorController@post');
Route::delete('fornecedores/{id}', 'FornecedorController@delete');
Route::patch('fornecedores/{id}', 'FornecedorController@patch');
