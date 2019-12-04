<?php

namespace Tests\Unit;

use App\Helper\SupplierActivationHelper;
use App\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SupplierActivationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testActivation()
    {
        \App\SupplierActivation::flushEventListeners();
        $supplier = factory(\App\Supplier::class, 1)->state('active')->create()[0];
        $token = $supplier->activation->token;
        $helper = $this->app->make(SupplierActivationHelper::class);

        $helper->activate($token);

        $supplier = Supplier::find($supplier->id);

        $this->assertEquals($supplier->active, 1);
        $this->assertEquals($supplier->activation->active, 0);

        $this->expectExceptionMessage("Token inválido");
        $helper->activate($token);
    }

    public function testActivationRandomToken()
    {
        $helper = $this->app->make(SupplierActivationHelper::class);

        $this->expectExceptionMessage("Token inválido");
        $helper->activate("randomstring");
    }
}
