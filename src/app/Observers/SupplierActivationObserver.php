<?php

namespace App\Observers;

use App\SupplierActivation;
use App\Jobs\ActivateSupplier;
use App\Mail\SupplierActivationEmail;
use Illuminate\Support\Facades\Mail;

class SupplierActivationObserver
{
    /**
     * Handle the ativacao supplier "created" event.
     *
     * @param  \App\SupplierActivation  $ativacaoFornecedor
     * @return void
     */
    public function created(SupplierActivation $ativacaoFornecedor)
    {
        ActivateSupplier::dispatch($ativacaoFornecedor)->onQueue('emails');
    }
}
