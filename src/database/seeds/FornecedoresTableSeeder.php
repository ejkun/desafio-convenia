<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FornecedoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numFornecedores = 3;
        while ($numFornecedores) {
            DB::table('fornecedores')->insert([
                'nome' => Str::random(10),
                'email' => Str::random(10).'@gmail.com',
                'mensalidade' => rand(100,1000),
                'ativo' => true,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]);

            $numFornecedores--;
        }
    }
}
