<?php

use Illuminate\Database\Seeder;

class SuppliersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //\App\Supplier::flushEventListeners();
        //factory(\App\Supplier::class, 0)->state('active')->create();
        factory(\App\Supplier::class, 1)->create();
    }
}
