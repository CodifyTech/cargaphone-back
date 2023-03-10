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
            'name' => 'Felipe Aires',
            'email' => 'admin@admin.com.br',
            'password' => bcrypt('123456'),
            //'password' => '123456',
            'perfil' => 1,
            'cpf_usuario' => '000.000.000-00',
            'rg_usuario' => '0.000.000-00',
            'sexo' => 'M',
            'dt_nascimento' => '1990/10/10',
            'tel_contato' => '(99) 99999-9999',
            'is_whatsapp' => true,
            'foto_perfil' => 'perfil.jpg',
            'nome_rua' => 'Rua X',
            'numero_residencia' => 123,
            'cep' => '12123-123',
            'cidade' => 'Cidade X',
            'bairro' => 'Bairro X',
            'estado' => 'SP',
            'tenant_id' => 1,
            'tenant_id_old' => 0
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
