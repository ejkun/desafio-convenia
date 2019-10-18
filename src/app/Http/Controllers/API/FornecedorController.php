<?php

namespace App\Http\Controllers\API;

use App\Fornecedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FornecedorController extends AbstractApiController
{
    const CACHE_BASE_NAME = 'fornecedor';
    protected $className = Fornecedor::class;
    protected $props = ['nome','email','mensalidade','ativo'];
    protected $errorMessages = [
        404 => 'Fornecedor não encontrado'
    ];
    protected $bodyValidate = [
        'nome' => 'required|max:255',
        'email' => 'required|email',
        'mensalidade' => 'required|numeric|min:0'
    ];

    public function total(Request $request)
    {
        $total = Cache::remember(self::CACHE_BASE_NAME.'_total', $this->cacheTime, function () {
            return Fornecedor::query()
                ->selectRaw('IFNULL(SUM(mensalidade),0) as total_mensalidades, COUNT(id) as qtd_fornecedores')
                ->where('ativo','=',1)
                ->first();
        });

        return $total;
    }

    protected function afterPut(Request $request)
    {
        $this->removeCache($request->get('id'));
    }

    protected function afterPatch(Request $request)
    {
        $this->removeCache($request->get('id'));
    }

    public function removeCache($id = null)
    {
        $chave = self::CACHE_BASE_NAME . '_' . ($id !== null ? $id : 'all');
        Cache::forget($chave);
        Cache::forget(self::CACHE_BASE_NAME . '_all');
    }
}
