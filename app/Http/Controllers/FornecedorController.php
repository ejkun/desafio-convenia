<?php

namespace App\Http\Controllers;

use App\Fornecedor;
use Illuminate\Http\Request;

class FornecedorController extends AbstractApiController
{
    protected $className = Fornecedor::class;
    protected $props = ['nome','email','mensalidade'];
    protected $errorMessages = [
        404 => 'Fornecedor não encontrado'
    ];
}
