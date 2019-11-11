<?php

namespace App\Http\Controllers;

use App\SupplierActivation;
use App\Supplier;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SupplierController extends Controller
{
    public function activate($token, Request $request)
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

        Cache::forget(\App\Http\Controllers\API\SupplierController::CACHE_BASE_NAME . '_total');

        return view('supplier/activate',[
            'supplier' => $fornecedor
        ]);
    }
}
