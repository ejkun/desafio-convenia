<?php

namespace App\Helper;

use App\Supplier;
use App\SupplierActivation;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SupplierActivationHelper
{
    /**
     * @param string $token
     *
     * @return Supplier
     */
    public function activate(string $token): Supplier
    {
        // @var Collection $result
        $result = SupplierActivation::where(['token' => $token, 'active' => 1])->get();
        if (1 != $result->count()) {
            throw new NotFoundHttpException('Token inválido');
        }
        // @var SupplierActivation $activation
        $activation = $result->first();
        // @var Supplier $supplier
        $supplier = $activation->supplier;
        DB::transaction(function () use ($activation, $supplier) {
            $activation->active = 0;
            $supplier->active = 1;
            $activation->save();
            $supplier->save();
        });

        return $supplier;
    }
}
