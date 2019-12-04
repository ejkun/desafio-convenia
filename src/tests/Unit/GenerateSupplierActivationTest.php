<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GenerateSupplierActivationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testGeneration()
    {
        \App\SupplierActivation::flushEventListeners();
        $supplier = factory(\App\Supplier::class, 1)->state('active')->create()[0];

        $this->assertNotNull($supplier->activation);
    }
}
