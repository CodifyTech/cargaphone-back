<?php

namespace Database\Factories;

use App\Models\Estabelecimento;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Totem>
 */
class TotemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nome' => 'Totem 1',
            'identificador' => 'T001',
            'descricao' => 'Totem escritório',
            'ativo' => 1,
            'tenant_id' => 1,
            'estabelecimento_id' => function() {
                return Estabelecimento::factory()->create()->id;
            }
        ];
    }
}
