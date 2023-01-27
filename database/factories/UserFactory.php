<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => 'Rachel Menezes',
            'email' => 'rachel@ciacuidadores.com.br',
            'password' => bcrypt('123456'),
            'perfil' => 1,
            'cpf_usuario' => '123-123-123-12',
            'rg_usuario' => '12-123-123-1',
            'sexo' => 'F',
            'dt_nascimento' => '1995/10/10',
            'tel_contato' => '(12) 12345-1234',
            'is_whatsapp' => true,
            'foto_perfil' => 'perfil.jpg',
            'nome_rua' => 'Rua xxx xx xxxx',
            'numero_residencia' => 123,
            'cep' => '12123-123',
            'cidade' => 'Cidade Exemplo',
            'bairro' => 'Bairro Exemplo',
            'estado' => 'SP',
            'tenant_id' => 1
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
