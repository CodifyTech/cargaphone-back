<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estabelecimento>
 */
class EstabelecimentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => '1d65eefd-a3ff-44c0-b6bf-cf2cbe568c0b',
            'nome' => 'Estabelecimento Teste',
            'tenant_id' => 1,
            'razao_social' => 'Estabelecimento Teste',
            'cnpj' => '66.556.469/8798-72',
            'responsavel' => 'Felipe Aires',
            'contato_responsavel' => 'felipe@cargaphone.com.br',
            'cep' => '04909004',
            'endereco' => 'Rua Fictícia Exemplo',
            'cidade' => 'Cidade Exemplo',
            'segmentacao' => 'Bar',
            'estado' => 'SP'
        ];
    }
}
