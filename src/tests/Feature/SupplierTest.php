<?php

namespace Tests\Feature;

use App\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SupplierTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testFornecedor()
    {
        $fornecedor1 = $this->inserirFornecedor1();
        $this->verificarFornecedor($fornecedor1);

        //POST 2
        $fornecedor2 = $this->inserirFornecedor2();
        $this->verificarFornecedor($fornecedor2);

        //GET ALL

        //PUT
        $this->putFornecedor1($fornecedor1);

        //PATCH
        $this->patchFornecedor2($fornecedor2);

        //ATIVAR
        $this->ativarFornecedor($fornecedor1);

        //MEDIA
        $this->checkTotal([
            'total_payments' => 1000,
            'suppliers_qtt' => 1
        ]);

        //ATIVAR
        $this->ativarFornecedor($fornecedor2);

        //MEDIA
        $this->checkTotal([
            'total_payments' => 1900,
            'suppliers_qtt' => 2
        ]);

        //DELETE
        $this->deleteFornecedor($fornecedor1);
        $this->deleteFornecedor($fornecedor2);
    }

    private function inserirFornecedor1()
    {
        $response = $this->postJson('/api/v1/suppliers',[
            'name' => 'Convenia',
            'email' => 'contato@convenia.com.br',
            'monthlyPayment' => 980
        ]);
        $response->assertJson([
            'name' => 'Convenia',
            'email' => 'contato@convenia.com.br',
            'monthlyPayment' => 980
        ]);

        return $response->json();
    }

    private function inserirFornecedor2()
    {
        $response = $this->postJson('/api/v1/suppliers',[
            'name' => 'Room21',
            'email' => 'contato@room21.dev',
            'monthlyPayment' => 835
        ]);
        $response->assertJson([
            'name' => 'Room21',
            'email' => 'contato@room21.dev',
            'monthlyPayment' => 835
        ]);

        return $response->json();
    }

    private function verificarFornecedor($fornecedor)
    {
        $response = $this->getJson('/api/v1/suppliers/'.$fornecedor['id']);
        $response->assertJson($fornecedor);
    }

    private function putFornecedor1($fornecedor)
    {
        $response = $this->putJson('/api/v1/suppliers/'.$fornecedor['id'],[
            'name' => 'Convenia',
            'email' => 'contato@convenia.com.br',
            'monthlyPayment' => 1000
        ]);
        $response->assertJson([
            'name' => 'Convenia',
            'email' => 'contato@convenia.com.br',
            'monthlyPayment' => 1000
        ]);
    }

    private function patchFornecedor2($fornecedor)
    {
        $response = $this->patchJson('/api/v1/suppliers/'.$fornecedor['id'],[
            'monthlyPayment' => 900
        ]);
        $response->assertJson([
            'name' => 'Room21',
            'email' => 'contato@room21.dev',
            'monthlyPayment' => 900
        ]);
    }

    private function ativarFornecedor($fornecedor)
    {
        /** @var Supplier $obj */
        $obj = Supplier::find($fornecedor['id']);
        $response = $this->get('/suppliers/activate/'.$obj->activation->token);
        $response->assertStatus(200);
    }

    private function checkTotal($arr)
    {
        $response = $this->get('/api/v1/suppliers/total');
        $response->assertJson($arr);
    }

    private function deleteFornecedor($fornecedor)
    {
        $obj = Supplier::find($fornecedor['id']);
        $response = $this->deleteJson('/api/v1/suppliers/'.$fornecedor['id']);
        $response->assertJson([
            'name' => $obj->name,
            'email' => $obj->email,
            'monthlyPayment' => $obj->monthlyPayment
        ]);
    }
}
