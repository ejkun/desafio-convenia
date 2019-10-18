<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAtivoAtivacaoFornecedores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ativacao_fornecedores', function (Blueprint $table) {
            $table->boolean('ativo')->default(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ativacao_fornecedores', function (Blueprint $table) {
            $table->boolean('ativo')->default(false)->change();
        });
    }
}
