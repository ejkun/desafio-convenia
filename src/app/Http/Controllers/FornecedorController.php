<?php

namespace App\Http\Controllers;

use App\AtivacaoFornecedor;
use App\Fornecedor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FornecedorController extends Controller
{
    public function ativar($token, Request $request)
    {
        /** @var Collection $result */
        $result = AtivacaoFornecedor::where(['token' => $token, 'ativo' => 1])->get();

        if ($result->count() != 1) {
            throw new NotFoundHttpException("Token inválido");
        }

        /** @var AtivacaoFornecedor $ativacao */
        $ativacao = $result->first();
        /** @var Fornecedor $fornecedor */
        $fornecedor = $ativacao->fornecedor;

        DB::transaction(function () use ($ativacao, $fornecedor) {
            $ativacao->ativo = 0;
            $fornecedor->ativo = 1;

            $ativacao->save();
            $fornecedor->save();
        });

        Cache::forget(\App\Http\Controllers\API\FornecedorController::CACHE_BASE_NAME . '_total');

        return view('fornecedor/ativar',[
            'fornecedor' => $fornecedor
        ]);
    }
}
