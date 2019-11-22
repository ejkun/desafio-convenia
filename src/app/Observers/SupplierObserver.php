<?php

namespace App\Observers;

use App\SupplierActivation;
use App\Supplier;

class SupplierObserver
{
    /**
     * Handle the supplier "created" event.
     *
     * @param  \App\Supplier  $supplier
     * @return void
     */
    public function created(Supplier $supplier)
    {
        $activation = new SupplierActivation();
        $activation->token = md5($supplier->email);
        $supplier->activation()->save($activation);
    }

    public function deleting(Supplier $supplier)
    {
        $supplier->activation()->delete();
    }
}
