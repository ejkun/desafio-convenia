<?php

namespace App\Observers;

use App\AtivacaoFornecedor;
use App\Jobs\AtivarFornecedor;
use App\Mail\EmailAtivacaoFornecedor;
use Illuminate\Support\Facades\Mail;

class AtivacaoFornecedorObserver
{
    /**
     * Handle the ativacao fornecedor "created" event.
     *
     * @param  \App\AtivacaoFornecedor  $ativacaoFornecedor
     * @return void
     */
    public function created(AtivacaoFornecedor $ativacaoFornecedor)
    {
        AtivarFornecedor::dispatch($ativacaoFornecedor)->onQueue('emails');
    }
}
