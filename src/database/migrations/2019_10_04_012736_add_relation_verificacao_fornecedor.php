<?php

use App\AtivacaoFornecedor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationVerificacaoFornecedor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fornecedores', function (Blueprint $table) {
            $table->unsignedBigInteger('ativacao_fornecedor_id')->nullable();

            $table->foreign('ativacao_fornecedor_id')
                ->references('id')
                ->on('ativacao_fornecedores')
                ->onDelete('cascade')
            ;
        });

        Schema::table('ativacao_fornecedores', function (Blueprint $table) {
            $table->unsignedBigInteger('fornecedor_id')->nullable();

            $table->foreign('fornecedor_id')
                ->references('id')
                ->on('fornecedores')
            ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fornecedor', function (Blueprint $table) {
            //
        });
    }
}
