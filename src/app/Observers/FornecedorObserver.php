<?php

namespace App\Observers;

use App\AtivacaoFornecedor;
use App\Fornecedor;

class FornecedorObserver
{
    /**
     * Handle the fornecedor "created" event.
     *
     * @param  \App\Fornecedor  $fornecedor
     * @return void
     */
    public function created(Fornecedor $fornecedor)
    {
        $ativacao = new AtivacaoFornecedor();
        $ativacao->token = md5($fornecedor->email);
        $fornecedor->ativacao()->save($ativacao);
    }

    public function deleting(Fornecedor $fornecedor)
    {
        $fornecedor->ativacao()->delete();
    }
}
