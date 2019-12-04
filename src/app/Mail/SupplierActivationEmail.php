<?php

namespace App\Mail;

use App\SupplierActivation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupplierActivationEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /** @var SupplierActivation */
    private $supplierActivation;

    /**
     * Create a new message instance.
     */
    public function __construct(SupplierActivation $supplierActivation)
    {
        $this->supplierActivation = $supplierActivation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $supplier = $this->supplierActivation->supplier()->first();

        $data = [
            'name' => $supplier->name,
            'value' => $supplier->monthlyPayment,
            'url' => route('web.show_activation.suppliers', ['token' => $this->supplierActivation->token]),
            'token' => $this->supplierActivation->token,
        ];

        return $this->view('emails.supplier_activation', $data);
    }
}
