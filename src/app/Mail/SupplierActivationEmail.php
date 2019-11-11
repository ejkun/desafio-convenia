<?php

namespace App\Mail;

use App\SupplierActivation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupplierActivationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var SupplierActivation */
    private $ativacaoFornecedor;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(SupplierActivation $ativacaoFornecedor)
    {
        $this->ativacaoFornecedor = $ativacaoFornecedor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fornecedor = $this->ativacaoFornecedor->supplier()->first();

        $aux = [
            'nome' => $fornecedor->nome,
            'valor' => $fornecedor->mensalidade,
            'url' => route('web.activate.suppliers',['token' => $this->ativacaoFornecedor->token]),
            'token' => $this->ativacaoFornecedor->token
        ];

        return $this->view('emails.supplier_activation',$aux);
    }
}
