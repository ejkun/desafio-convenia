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
        Schema::table('fornecedor', function (Blueprint $table) {
            $table->integer('ativacao_fornecedor_id')->unsigned();

            $table->foreign('ativacao_fornecedor_id')
                ->references('id')
                ->on(AtivacaoFornecedor::class)
                ->onDelete('cascade')
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
