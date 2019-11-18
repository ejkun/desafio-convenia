<?php

namespace App\Helper;

use App\Supplier;
use App\SupplierActivation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SupplierActivationHelper
{
    /**
     * @param string $token
     * @return Supplier
     */
    public function activate(string $token): Supplier
    {
        /** @var Collection $result */
        $result = SupplierActivation::where(['token' => $token, 'ativo' => 1])->get();
        if ($result->count() != 1) {
            throw new NotFoundHttpException("Token inválido");
        }
        /** @var SupplierActivation $ativacao */
        $ativacao = $result->first();
        /** @var Supplier $fornecedor */
        $fornecedor = $ativacao->supplier;
        DB::transaction(function () use ($ativacao, $fornecedor) {
            $ativacao->ativo = 0;
            $fornecedor->ativo = 1;
            $ativacao->save();
            $fornecedor->save();
        });

        return $fornecedor;
    }
}
