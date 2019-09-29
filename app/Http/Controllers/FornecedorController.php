<?php

namespace App\Http\Controllers;

use App\Fornecedor;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    private function getFornecedorOrAbort($id) {
        $fornecedor = Fornecedor::find($id);

        if ($fornecedor === null) {
            abort(404, 'Fornecedor não encontrado');
        }

        return $fornecedor;
    }

    public function get($id = null) {
        if ($id === null) {
            $fornecedores = Fornecedor::all();

            return $fornecedores;
        }

        $fornecedor = $this->getFornecedorOrAbort($id);

        return $fornecedor;
    }

    public function post(Request $request)
    {
        $fornecedor = new Fornecedor();
        $fornecedor->nome = $request->input('nome');
        $fornecedor->email = $request->input('email');
        $fornecedor->mensalidade = $request->input('mensalidade');

        $fornecedor->save();

        return $fornecedor;
    }

    public function delete($id)
    {
        $fornecedor = $this->getFornecedorOrAbort($id);

        $fornecedor->delete();

        return $fornecedor;
    }

    public function patch($id, Request $request)
    {
        $fornecedor = $this->getFornecedorOrAbort($id);

        $props = ['nome','email','mensalidade'];

        foreach ($props as $p) {
            if ($request->has($p)) {
                $pV = $request->input($p);
                $fornecedor->$p = $pV;
            }
        }

        $fornecedor->save();

        return $fornecedor;
    }
}
