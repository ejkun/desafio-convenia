<?php

namespace App\Observers;

use App\Supplier;
use App\SupplierActivation;

class SupplierObserver
{
    /**
     * Handle the supplier "created" event.
     *
     * @param \App\Supplier $supplier
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
