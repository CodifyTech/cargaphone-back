<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Frase>
 */
class FraseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'frase' => 'Tudo que é bom dura o tempo que é necessário para ser inesquecível. - Fernando Pessoa'
        ];
    }
}
