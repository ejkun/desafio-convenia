<?php

namespace App\Observers;

use App\SupplierActivation;
use App\Jobs\ActivateSupplier;
use App\Mail\SupplierActivationEmail;
use Illuminate\Support\Facades\Mail;

class SupplierActivationObserver
{
    /**
     * Handle the SupplierActivation "created" event.
     *
     * @param  \App\SupplierActivation  $supplierActivation
     * @return void
     */
    public function created(SupplierActivation $supplierActivation)
    {
        ActivateSupplier::dispatch($supplierActivation)->onQueue('emails');
    }
}
