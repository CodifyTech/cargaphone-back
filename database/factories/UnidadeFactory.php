<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unity>
 */
class UnidadeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => 1,
            'nome' => 'Unidade 1',
            'cnpj_empresa' => '23543524153',
            'nome_responsavel' => 'Rachel Menezes',
            'dt_abertura' => '2010-10-10',
            'nome_rua' => 'Rua Teste',
            'numero' => 133,
            'cep' => 12312123,
            'cidade' => 'São Paulo',
            'estado' => 'SP'
        ];
    }
}
