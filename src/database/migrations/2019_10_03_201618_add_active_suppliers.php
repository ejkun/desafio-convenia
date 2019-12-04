<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActiveSuppliers extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->boolean('active')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->removeColumn('active');
        });
    }
}
