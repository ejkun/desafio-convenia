<?php

namespace App\Http\Controllers;

use App\Fornecedor;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    function get($id = null) {
        if ($id === null) {
            $fornecedores = Fornecedor::all();

            return $fornecedores;
        }

        $fornecedor = Fornecedor::find($id);

        if ($fornecedor === null) {
            abort(404,'Fornecedor não encontrado');
        }

        return $fornecedor;
    }

    function post(Request $request)
    {
        $fornecedor = new Fornecedor();
        $fornecedor->nome = $request->input('nome');
        $fornecedor->email = $request->input('email');
        $fornecedor->mensalidade = $request->input('mensalidade');

        $fornecedor->save();

        return $fornecedor;
    }
}
