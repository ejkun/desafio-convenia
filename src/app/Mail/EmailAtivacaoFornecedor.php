<?php

namespace App\Mail;

use App\AtivacaoFornecedor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailAtivacaoFornecedor extends Mailable
{
    use Queueable, SerializesModels;

    /** @var AtivacaoFornecedor */
    private $ativacaoFornecedor;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(AtivacaoFornecedor $ativacaoFornecedor)
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
        $fornecedor = $this->ativacaoFornecedor->fornecedor()->first();

        $aux = [
            'nome' => $fornecedor->nome,
            'valor' => $fornecedor->mensalidade,
            'url' => route('web.ativar.fornecedores',['token' => $this->ativacaoFornecedor->token]),
            'token' => $this->ativacaoFornecedor->token
        ];

        return $this->view('emails.ativacao_fornecedor',$aux);
    }
}
