<?php

namespace App\Http\Controllers;

use App\Helper\SupplierActivationHelper;
use App\Http\Requests\StoreSupplier;
use App\Http\Requests\UpdateSupplier;
use App\Supplier;
use App\SupplierActivation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SupplierController extends Controller
{
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
    public function update(UpdateSupplier $request, Supplier $supplier)
    {
        $data = $request->validated();

        if (empty($data)) {
            return new JsonResponse(404);
        }

        $supplier->fill($data);
        $supplier->save();

        Cache::forget('suppliers_total');
        Cache::forget('suppliers_all');

        return $supplier;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Supplier $supplier
     * @return Supplier
     * @throws \Exception
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
     * @param SupplierActivationHelper $supplierActivationHelper
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function activate($token, Request $request, SupplierActivationHelper $supplierActivationHelper)
    {
        $supplier = $supplierActivationHelper->activate($token);

        Cache::forget('suppliers_total');

        return view('suppliers/activate',[
            'name' => $supplier->name
        ]);
    }

    /**
     * Show page to activate a supplier
     *
     * @param $token
     * @param Request $request
     * @param SupplierActivationHelper $supplierActivationHelper
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showActivation($token, Request $request)
    {
        /** @var Collection $result */
        $result = SupplierActivation::where(['token' => $token, 'active' => 1])->get();
        if ($result->count() != 1) {
            throw new NotFoundHttpException("Token inválido");
        }
        /** @var SupplierActivation $activation */
        $activation = $result->first();
        /** @var Supplier $supplier */
        $supplier = $activation->supplier;

        return view('suppliers/activation',[
            'name' => $supplier->name
        ]);
    }
}
