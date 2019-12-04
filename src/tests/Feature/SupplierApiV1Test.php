<?php

namespace Tests\Feature;

use App\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SupplierApiV1Test extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testGetAll()
    {
        $supplier = factory(\App\Supplier::class, 4)->state('active')->create();
        $response = $this->getJson('/api/v1/suppliers');

        $response->assertStatus(200);
        $response->assertJson($supplier->toArray());
    }

    public function testGetOneSuccess()
    {
        $supplier = factory(\App\Supplier::class, 1)->state('active')->create()[0];
        $response = $this->getJson('/api/v1/suppliers/'.$supplier->id);

        $response->assertStatus(200);
        $response->assertJson($supplier->toArray());
    }

    public function testStoreSuccess()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'monthlyPayment' => $this->faker->numberBetween(100, 1000),
        ];
        $response = $this->postJson('/api/v1/suppliers', $data);

        $response->assertStatus(201);
        $response->assertJson($data);
    }

    public function testStoreMissingBody()
    {
        $data = [];
        $response = $this->postJson('/api/v1/suppliers', $data);

        $response->assertStatus(422);
        $response->assertJson([
            'errors' => [
                'name' => ['The name field is required.'],
                'email' => ['The email field is required.'],
                'monthlyPayment' => ['The monthly payment field is required.'],
            ],
        ]);
    }

    public function testStoreWrongBody()
    {
        $data = [
            'name' => 'a',
            'email' => 'notavalidemail',
            'monthlyPayment' => -1,
        ];
        $response = $this->postJson('/api/v1/suppliers', $data);

        $response->assertStatus(422);
        $response->assertJson([
            'errors' => [
                'name' => ['The name must be at least 3 characters.'],
                'email' => ['The email must be a valid email address.'],
                'monthlyPayment' => ['The monthly payment must be at least 0.'],
            ],
        ]);
    }

    public function testGetOneFail()
    {
        $response = $this->getJson('/api/v1/suppliers/1');

        $response->assertStatus(404);
    }

    public function testUpdateSuccess()
    {
        $supplier = factory(\App\Supplier::class, 1)->state('active')->create();
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'monthlyPayment' => $this->faker->numberBetween(100, 1000),
        ];
        $response = $this->patchJson('/api/v1/suppliers/1', $data);

        $response->assertStatus(200);
        $response->assertJson($data);
    }

    public function testUpdateNotFound()
    {
        $data = [];
        $response = $this->patchJson('/api/v1/suppliers/1', $data);

        $response->assertStatus(404);
    }

    public function testUpdateMissingBody()
    {
        $supplier = factory(\App\Supplier::class, 1)->state('active')->create();
        $data = [];
        $response = $this->patchJson('/api/v1/suppliers/1', $data);

        $response->assertStatus(422);
        $response->assertJson([
            'errors' => [
                'name' => ['The name field is required when none of the others are present.'],
                'email' => ['The email field is required when none of the others are present.'],
                'monthlyPayment' => ['The monthly payment field is required when none of the others are present.'],
            ],
        ]);
    }

    public function testUpdateWrongBody()
    {
        $supplier = factory(\App\Supplier::class, 1)->state('active')->create();
        $data = [
            'name' => 'a',
            'email' => 'notavalidemail',
            'monthlyPayment' => -1,
        ];
        $response = $this->patchJson('/api/v1/suppliers/1', $data);

        $response->assertStatus(422);
        $response->assertJson([
            'errors' => [
                'name' => ['The name must be at least 3 characters.'],
                'email' => ['The email must be a valid email address.'],
                'monthlyPayment' => ['The monthly payment must be at least 0.'],
            ],
        ]);
    }

    public function testDeleteSuccess()
    {
        $supplier = factory(\App\Supplier::class, 1)->state('active')->create()[0];

        $response = $this->deleteJson('/api/v1/suppliers/1');

        $response->assertStatus(200);

        $this->expectExceptionMessage('No query results for model [App\\Supplier] 1');

        Supplier::findOrFail($supplier->id);
    }

    public function testDeleteNotFound()
    {
        $response = $this->deleteJson('/api/v1/suppliers/1');

        $response->assertStatus(404);
    }

    public function testTotalSuccess()
    {
        $supplier = factory(\App\Supplier::class, 4)->state('active')->create();

        $response = $this->getJson('/api/v1/suppliers/total');

        $total = Supplier::total();

        $response->assertStatus(200);
        $response->assertJson($total->toArray());
    }
}
