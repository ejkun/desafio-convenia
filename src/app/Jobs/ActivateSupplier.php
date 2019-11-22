<?php

namespace App\Jobs;

use App\SupplierActivation;
use App\Mail\SupplierActivationEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ActivateSupplier implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $supplierActivation;

    /**
     * Create a new job instance.
     *
     * ActivateSupplier constructor.
     * @param SupplierActivation $supplierActivation
     */
    public function __construct(SupplierActivation $supplierActivation)
    {
        $this->$supplierActivation = $supplierActivation;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->supplierActivation->supplier()->get('email'))
            ->send(new SupplierActivationEmail($this->supplierActivation))
        ;
    }
}
