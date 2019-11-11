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

    private $ativacaoFornecedor;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(SupplierActivation $ativacaoFornecedor)
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
        Mail::to($this->ativacaoFornecedor->supplier()->get('email'))
            ->send(new SupplierActivationEmail($this->ativacaoFornecedor))
        ;
    }
}
