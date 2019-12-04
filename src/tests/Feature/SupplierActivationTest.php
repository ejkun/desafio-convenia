<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SupplierActivationTest extends TestCase
{
    use RefreshDatabase;

    public function testActivationPageSuccess()
    {
        $supplier = factory(\App\Supplier::class, 1)->state('active')->create()[0];

        $response = $this->get('/suppliers/activate/'.$supplier->activation->token);

        $response->assertStatus(200);
    }

    public function testActivationPageNotFound()
    {
        $response = $this->get('/suppliers/activate/notatoken');

        $response->assertStatus(404);
    }
}
