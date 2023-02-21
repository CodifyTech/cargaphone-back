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
        Unidade::factory()->create();
        User::factory()->create();
        // Anuncio::factory()->has(Totem::factory())->create();

        Unidade::factory()->create([
            'id' => 2,
            'nome' => 'Unidade Padrão',
            'cnpj_empresa' => '',
            'nome_responsavel' => 'Felipe Aires',
        ]);
        
        Frase::factory()->create([
            'frase' => 'Acredite em si mesmo e tudo será possível." - Paulo Coelho'
        ]);
        Frase::factory()->create([
            'frase' => 'A única forma de fazer um bom trabalho é amando o que você faz. - Steve Jobs'
        ]);
        Frase::factory()->create([
            'frase' => 'O sucesso é a soma de pequenos esforços repetidos dia após dia. - Robert Collier'
        ]);
        Frase::factory()->create([
            'frase' => 'O sucesso é ir de fracasso em fracasso sem perder entusiasmo. - Winston Churchill'
        ]);
        Frase::factory()->create([
            'frase' => 'A vida é 10% do que acontece comigo e 90% de como eu reajo a isso. - Charles Swindoll'
        ]);
        Frase::factory()->create([
            'frase' => 'O sucesso é a habilidade de ir de um fracasso para outro sem perder o entusiasmo. - Winston Churchill'
        ]);
        Frase::factory()->create([
            'frase' => 'Tudo o que você sempre quis está do outro lado do seu medo. - George Addair'
        ]);
        Frase::factory()->create([
            'frase' => 'Você é capaz de muito mais do que imagina. - Zig Ziglar'
        ]);
        Frase::factory()->create([
            'frase' => 'Não existem limites para o que você pode conquistar, exceto os limites que você mesmo coloca. - Brian Tracy'
        ]);
        Frase::factory()->create([
            'frase' => 'Não deixe que o medo de falhar impeça você de tentar. - J.K. Rowling'
        ]);
        Frase::factory()->create([
            'frase' => "Nada é impossível, a palavra mesma diz 'eu sou possível'. - Audrey Hepburn"
        ]);
        Frase::factory()->create([
            'frase' => 'O sucesso é a capacidade de ir de fracasso em fracasso sem perder o entusiasmo. - Winston Churchill'
        ]);
        Frase::factory()->create([
            'frase' => 'A única forma de fazer um excelente trabalho é amando o que você faz.  - Steve Jobs'
        ]);
        Frase::factory()->create([
            'frase' => 'Não importa quantas vezes você falhe, você sempre pode começar de novo. - Buddha'
        ]);
        Frase::factory()->create([
            'frase' => 'Não é sobre ter tempo, é sobre fazer tempo. - Autor Desconhecido'
        ]);
        Frase::factory()->create([
            'frase' => 'O futuro pertence àqueles que acreditam na beleza de seus sonhos. - Eleanor Roosevelt'
        ]);
        Frase::factory()->create([
            'frase' => 'Se você quer fazer algo que nunca fez, precisa estar disposto a fazer algo que nunca fez antes. - Thomas Jefferson'
        ]);
        Frase::factory()->create([
            'frase' => 'Não deixe que o que você não pode fazer atrapalhe o que você pode fazer. - John Wooden'
        ]);
        Frase::factory()->create([
            'frase' => 'O sucesso é a soma de pequenos esforços repetidos diariamente. - Robert Collier'
        ]);
        Frase::factory()->create([
            'frase' => 'Se você quer alcançar a grandeza, pare de pedir permissão. - Autor Desconhecido'
        ]);
        Frase::factory()->create([
            'frase' => 'Tente ser um arco-íris na nuvem de alguém. - Maya Angelou'
        ]);
        Frase::factory()->create([
            'frase' => 'A motivação é o que te faz começar. O hábito é o que te faz continuar. - Jim Ryun'
        ]);
        Frase::factory()->create([
            'frase' => 'Nunca se compare com os outros. Compare-se apenas com a pessoa que você foi ontem. - Autor Desconhecido'
        ]);
        Frase::factory()->create([
            'frase' => 'Você não pode mudar o vento, mas pode ajustar as velas. - Confúcio'
        ]);
        Frase::factory()->create([
            'frase' => 'Você nunca falhará até que pare de tentar. - Albert Einstein'
        ]);
        Frase::factory()->create([
            'frase' => 'Tudo o que você precisa é a coragem de seguir seu coração e intuição. - Steve Jobs'
        ]);
        Frase::factory()->create([
            'frase' => 'O sucesso é a soma de pequenos esforços repetidos diariamente. - Robert Collier'
        ]);
        Frase::factory()->create([
            'frase' => 'A vida é uma viagem, não um destino. - Ralph Waldo Emerson'
        ]);
        Frase::factory()->create([
            'frase' => 'A vida é 10% do que acontece comigo e 90% de como eu. - Autor Desconhecido'
        ]);
    }
}
