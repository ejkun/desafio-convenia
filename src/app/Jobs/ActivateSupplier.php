<?php

namespace App\Jobs;

use App\Mail\SupplierActivationEmail;
use App\SupplierActivation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ActivateSupplier implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private $supplierActivation;

    /**
     * Create a new job instance.
     *
     * ActivateSupplier constructor.
     *
     * @param SupplierActivation $supplierActivation
     */
    public function __construct(SupplierActivation $supplierActivation)
    {
        $this->supplierActivation = $supplierActivation;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Mail::to($this->supplierActivation->supplier()->get('email'))
            ->send(new SupplierActivationEmail($this->supplierActivation))
        ;
    }
}
