<?php

use App\SupplierActivation;
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
        Schema::table('suppliers', function (Blueprint $table) {
            $table->unsignedBigInteger('activation_supplier_id')->nullable();

            $table->foreign('activation_supplier_id')
                ->references('id')
                ->on('suppliers_activations')
                ->onDelete('cascade')
            ;
        });

        Schema::table('suppliers_activations', function (Blueprint $table) {
            $table->unsignedBigInteger('supplier_id')->nullable();

            $table->foreign('supplier_id')
                ->references('id')
                ->on('suppliers')
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
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropForeign(['activation_supplier_id']);
            $table->dropColumn('activation_supplier_id');
        });

        Schema::table('suppliers_activations', function (Blueprint $table) {
            $table->dropForeign(['supplier_id']);
            $table->dropColumn('supplier_id');
        });
    }
}
