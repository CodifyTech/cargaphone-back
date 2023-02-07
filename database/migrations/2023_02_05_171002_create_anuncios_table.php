<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anuncios', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('nome', 60);
            $table->string('arquivo');
            $table->string('nome_anunciante', 60);
            $table->double('valor_anuncio_mensal');
            $table->boolean('ativo')->default(1);
            $table->date('data_comeco_campanha')->nullable();
            $table->date('data_fim_campanha');
            $table->tinyInteger('tipo_campanha');
            $table->string('tel_contato_anunciante', 20);
            $table->string('email_contato', 40);
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anuncios');
    }
};
