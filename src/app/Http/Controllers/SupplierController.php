<?php

namespace App\Http\Controllers;

use App\Helper\SupplierActivationHelper;
use App\Http\Requests\StoreSupplier;
use App\Supplier;
use App\SupplierActivation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
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
    public function store(StoreSupplier $request)
    {
        $validated = $request->validated();

        $model = new Supplier($validated);

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
        $data = Validator::make($request->all(),[
            'nome' => 'sometimes|required|max:255',
            'email' => 'sometimes|required|email',
            'mensalidade' => 'sometimes|required|numeric|min:0'
        ])->validated();

        $supplier->fill($data);
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
            return Supplier::total();
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
    public function activate($token, Request $request, SupplierActivationHelper $supplierActivationHelper)
    {
        $fornecedor = $supplierActivationHelper->activate($token);

        return view('suppliers/activate',[
            'supplier' => $fornecedor
        ]);
    }
}
