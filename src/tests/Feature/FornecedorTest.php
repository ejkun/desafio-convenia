<?php

namespace Tests\Feature;

use App\Fornecedor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FornecedorTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testFornecedor()
    {
        //POST 1
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
        $fornecedor1 = $response->json();

        //GET 1
        $response = $this->getJson('/api/fornecedores/'.$fornecedor1['id']);
        $response->assertJson($fornecedor1);

        //POST 2
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

        $fornecedor2 = $response->json();

        //GET 2
        $response = $this->getJson('/api/fornecedores/'.$fornecedor2['id']);
        $response->assertJson($fornecedor2);

        //GET ALL

        //PUT
        $response = $this->putJson('/api/fornecedores/'.$fornecedor1['id'],[
            'nome' => 'Convenia',
            'email' => 'contato@convenia.com.br',
            'mensalidade' => 1000
        ]);
        $response->assertJson([
            'nome' => 'Convenia',
            'email' => 'contato@convenia.com.br',
            'mensalidade' => 1000
        ]);

        //PATCH
        $response = $this->patchJson('/api/fornecedores/'.$fornecedor2['id'],[
            'mensalidade' => 900
        ]);
        $response->assertJson([
            'nome' => 'Room21',
            'email' => 'contato@room21.dev',
            'mensalidade' => 900
        ]);

        //ATIVAR
        /** @var Fornecedor $f1Obj */
        $f1Obj = Fornecedor::find($fornecedor1['id']);
        $response = $this->get('/fornecedores/ativar/'.$f1Obj->ativacao->token);
        $response->assertStatus(200);

        //TODO: MEDIA

        //ATIVAR
        /** @var Fornecedor $f2Obj */
        $f2Obj = Fornecedor::find($fornecedor2['id']);
        $response = $this->get('/fornecedores/ativar/'.$f2Obj->ativacao->token);
        $response->assertStatus(200);

        //TODO: MEDIA

        //DELETE
        $response = $this->deleteJson('/api/fornecedores/'.$fornecedor1['id']);
        $response->assertJson([
            'nome' => 'Convenia',
            'email' => 'contato@convenia.com.br',
            'mensalidade' => 1000
        ]);

        $response = $this->deleteJson('/api/fornecedores/'.$fornecedor2['id']);
        $response->assertJson([
            'nome' => 'Room21',
            'email' => 'contato@room21.dev',
            'mensalidade' => 900
        ]);
    }
}
