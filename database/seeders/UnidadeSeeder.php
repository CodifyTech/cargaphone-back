<?php

namespace Database\Seeders;

use App\Models\Unidade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unidade::factory()->create();
        Unidade::factory()->create([
            'id' => 2,
            'nome' => 'Unidade Padrão',
            'cnpj_empresa' => '',
            'nome_responsavel' => 'Felipe Aires',
        ]);
    }
}
