<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeActiveSuppliersActivation extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('suppliers_activations', function (Blueprint $table) {
            $table->boolean('active')->default(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('suppliers_activations', function (Blueprint $table) {
            $table->boolean('active')->default(false)->change();
        });
    }
}
