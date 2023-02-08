<?php

namespace Database\Factories;

use App\Models\Totem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Anuncio>
 */
class AnuncioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nome' => 'Anúncio Fictício',
            'arquivo' => '1eda598c-783f-6b9a-aa8a-b4450628f605.mp4',
            'nome_anunciante' => 'Felipe Aires',
            'valor_anuncio_mensal' => 200,
            'data_comeco_campanha' => '2023-02-05',
            'tenant_id' => 1,
            'data_fim_campanha' => '2023-12-31',
            'tipo_campanha' => 1,
            'tel_contato_anunciante' => '(99) 99999-9999',
            'email_contato' => 'felipe@cargaphone.com.br',
        ];
    }
}
