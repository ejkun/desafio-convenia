<?php

namespace App\Http\Controllers\API;

use App\Fornecedor;
use Illuminate\Http\Request;

class FornecedorController extends AbstractApiController
{
    protected $className = Fornecedor::class;
    protected $props = ['nome','email','mensalidade','ativo'];
    protected $errorMessages = [
        404 => 'Fornecedor não encontrado'
    ];
    protected $bodyValidate = [
        'nome' => 'required|max:255',
        'email' => 'required|email',
        'mensalidade' => 'required|numeric|min:0'
    ];

    public function total(Request $request)
    {
        $total = Fornecedor::query()
            ->selectRaw('IFNULL(SUM(mensalidade),0) as total_mensalidades, COUNT(id) as qtd_fornecedores')
            ->where('ativo','=',0)
            ->get();

        return $total;
    }
}
