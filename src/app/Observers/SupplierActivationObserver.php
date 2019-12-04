<?php

namespace App\Observers;

use App\Jobs\ActivateSupplier;
use App\SupplierActivation;

class SupplierActivationObserver
{
    /**
     * Handle the SupplierActivation "created" event.
     *
     * @param \App\SupplierActivation $supplierActivation
     */
    public function created(SupplierActivation $supplierActivation)
    {
        ActivateSupplier::dispatch($supplierActivation)->onQueue('emails');
    }
}
