<?php

use Illuminate\Database\Seeder;

class SuppliersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \App\SupplierActivation::flushEventListeners();
        factory(\App\Supplier::class, 15)->state('active')->create();
        factory(\App\Supplier::class, 5)->create();
    }
}
