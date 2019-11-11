<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplier;
use App\Supplier;
use App\SupplierActivation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SupplierController extends Controller
{
    protected $props = ['nome','email','mensalidade','ativo'];
    protected $bodyValidate = [
        'nome' => 'required|max:255',
        'email' => 'required|email',
        'mensalidade' => 'required|numeric|min:0'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return Supplier[]
     */
    public function index()
    {
        $models = Cache::remember('suppliers_all', 60, function () {
            return Supplier::all();
        });

        return $models;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Supplier
     */
    public function store(Request $request)
    {
        $model = new Supplier();

        $request->validate($this->bodyValidate);

        foreach ($this->props as $prop) {
            if ($request->has($prop)) {
                $model->$prop = $request->input($prop);
            }
        }

        $model->save();

        Cache::forget('suppliers_total');
        Cache::forget('suppliers_all');

        return $model;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return Supplier
     */
    public function show(Supplier $supplier)
    {
        return $supplier;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplier  $supplier
     * @return Supplier
     */
    public function update(Request $request, Supplier $supplier)
    {
        foreach ($this->props as $p) {
            if ($request->has($p)) {
                $pV = $request->input($p);
                $this
                    ->getValidationFactory()
                    ->make([$p => $pV],[$p => $this->bodyValidate[$p]])
                    ->validate()
                ;
                $supplier->$p = $pV;
            }
        }

        $supplier->save();

        Cache::forget('suppliers_total');
        Cache::forget('suppliers_all');

        return $supplier;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return Supplier
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return $supplier;
    }

    /**
     * Calculate the sum of monthly payment of activated suppliers
     *
     * @param Request $request
     * @return float
     */
    public function total(Request $request)
    {
        $total = Cache::remember('suppliers_total', 60, function () {
            return Supplier::query()
                ->selectRaw('IFNULL(SUM(mensalidade),0) as total_mensalidades, COUNT(id) as qtd_fornecedores')
                ->where('ativo','=',1)
                ->first();
        });

        return $total;
    }

    /**
     * Activate a supplier
     *
     * @param $token
     * @param Request $request
     * @return \Illuminate\View\View
     */
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
        Cache::forget('suppliers_total');
        return view('suppliers/activate',[
            'supplier' => $fornecedor
        ]);
    }
}
