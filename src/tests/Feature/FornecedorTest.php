<?php

namespace Tests\Feature;

use App\Fornecedor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FornecedorTest extends TestCase
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
            'total_mensalidades' => 1000,
            'qtd_fornecedores' => 1
        ]);

        //ATIVAR
        $this->ativarFornecedor($fornecedor2);

        //MEDIA
        $this->checkTotal([
            'total_mensalidades' => 1900,
            'qtd_fornecedores' => 2
        ]);

        //DELETE
        $this->deleteFornecedor($fornecedor1);
        $this->deleteFornecedor($fornecedor2);
    }

    private function inserirFornecedor1()
    {
        $response = $this->postJson('/api/fornecedores',[
            'nome' => 'Convenia',
            'email' => 'contato@convenia.com.br',
            'mensalidade' => 980
        ]);
        $response->assertJson([
            'nome' => 'Convenia',
            'email' => 'contato@convenia.com.br',
            'mensalidade' => 980
        ]);

        return $response->json();
    }

    private function inserirFornecedor2()
    {
        $response = $this->postJson('/api/fornecedores',[
            'nome' => 'Room21',
            'email' => 'contato@room21.dev',
            'mensalidade' => 835
        ]);
        $response->assertJson([
            'nome' => 'Room21',
            'email' => 'contato@room21.dev',
            'mensalidade' => 835
        ]);

        return $response->json();
    }

    private function verificarFornecedor($fornecedor)
    {
        $response = $this->getJson('/api/fornecedores/'.$fornecedor['id']);
        $response->assertJson($fornecedor);
    }

    private function putFornecedor1($fornecedor)
    {
        $response = $this->putJson('/api/fornecedores/'.$fornecedor['id'],[
            'nome' => 'Convenia',
            'email' => 'contato@convenia.com.br',
            'mensalidade' => 1000
        ]);
        $response->assertJson([
            'nome' => 'Convenia',
            'email' => 'contato@convenia.com.br',
            'mensalidade' => 1000
        ]);
    }

    private function patchFornecedor2($fornecedor)
    {
        $response = $this->patchJson('/api/fornecedores/'.$fornecedor['id'],[
            'mensalidade' => 900
        ]);
        $response->assertJson([
            'nome' => 'Room21',
            'email' => 'contato@room21.dev',
            'mensalidade' => 900
        ]);
    }

    private function ativarFornecedor($fornecedor)
    {
        /** @var Fornecedor $obj */
        $obj = Fornecedor::find($fornecedor['id']);
        $response = $this->get('/fornecedores/ativar/'.$obj->ativacao->token);
        $response->assertStatus(200);
    }

    private function checkTotal($arr)
    {
        $response = $this->get('/api/fornecedores/total');
        $response->assertJson($arr);
    }

    private function deleteFornecedor($fornecedor)
    {
        $obj = Fornecedor::find($fornecedor['id']);
        $response = $this->deleteJson('/api/fornecedores/'.$fornecedor['id']);
        $response->assertJson([
            'nome' => $obj->nome,
            'email' => $obj->email,
            'mensalidade' => $obj->mensalidade
        ]);
    }
}
