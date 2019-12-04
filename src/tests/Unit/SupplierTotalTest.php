<?php

namespace Tests\Unit;

use App\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SupplierTotalTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testTotal()
    {
        \App\Supplier::flushEventListeners();
        $suppliers = factory(\App\Supplier::class, 3)->state('active')->create();
        $expectedTotal = 0;
        foreach ($suppliers as $supplier) {
            $expectedTotal += $supplier->monthlyPayment;
        }

        $total = Supplier::total()['total_payments'];

        $this->assertEquals($expectedTotal,$total);

        $newSupplier = factory(\App\Supplier::class, 1)->create()[0];
        $newSupplier->active = 1;
        $newSupplier->save();

        $newExpectedTotal = $expectedTotal + $newSupplier->monthlyPayment;

        $total = Supplier::total()['total_payments'];

        $this->assertEquals($newExpectedTotal,$total);
    }
}
