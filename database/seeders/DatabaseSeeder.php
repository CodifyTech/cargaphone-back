<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Anuncio;
use App\Models\Estabelecimento;
use App\Models\Frase;
use App\Models\Totem;
use App\Models\Unidade;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            FraseSeeder::class,
            UnidadeSeeder::class,
        ]);
        User::factory()->create();
        // Anuncio::factory()->has(Totem::factory())->create();
    }
}
