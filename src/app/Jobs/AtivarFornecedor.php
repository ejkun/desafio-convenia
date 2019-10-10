<?php

namespace App\Jobs;

use App\AtivacaoFornecedor;
use App\Mail\EmailAtivacaoFornecedor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class AtivarFornecedor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $ativacaoFornecedor;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(AtivacaoFornecedor $ativacaoFornecedor)
    {
        $this->ativacaoFornecedor = $ativacaoFornecedor;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->ativacaoFornecedor->fornecedor()->get('email'))
            ->send(new EmailAtivacaoFornecedor($this->ativacaoFornecedor))
        ;
    }
}
