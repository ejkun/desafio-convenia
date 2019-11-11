<?php

namespace App\Observers;

use App\SupplierActivation;
use App\Supplier;

class SupplierObserver
{
    /**
     * Handle the supplier "created" event.
     *
     * @param  \App\Supplier  $fornecedor
     * @return void
     */
    public function created(Supplier $fornecedor)
    {
        $ativacao = new SupplierActivation();
        $ativacao->token = md5($fornecedor->email);
        $fornecedor->activation()->save($ativacao);
    }

    public function deleting(Supplier $fornecedor)
    {
        $fornecedor->activation()->delete();
    }
}
