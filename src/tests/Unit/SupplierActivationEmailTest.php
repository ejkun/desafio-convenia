<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupplierActivationEmailTest extends TestCase
{
    use RefreshDatabase;

    public function testEmailSent()
    {
        $supplier = factory(\App\Supplier::class, 1)->create()[0];

        $emails = $this->app->make('swift.transport')->driver()->messages();

        $this->assertCount(1, $emails);
        $this->assertEquals([$supplier->email], array_keys($emails[0]->getTo()));
    }
}
