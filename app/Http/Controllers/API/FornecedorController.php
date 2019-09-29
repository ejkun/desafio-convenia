<?php

namespace App\Http\Controllers\API;

use App\Fornecedor;
use Illuminate\Http\Request;

class FornecedorController extends AbstractApiController
{
    protected $className = Fornecedor::class;
    protected $props = ['nome','email','mensalidade'];
    protected $errorMessages = [
        404 => 'Fornecedor não encontrado'
    ];
    protected $bodyValidate = [
        'nome' => 'required|max:255',
        'email' => 'required|email',
        'mensalidade' => 'required|numeric|min:0'
    ];
}
