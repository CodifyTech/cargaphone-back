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
        Schema::create('unidades', function (Blueprint $table) {
            $table->id();

            $table->string('nome', 60);
            $table->string('cnpj_empresa', 20)->nullable();
            $table->string('email', 30)->nullable()->unique();
            $table->string('nome_responsavel', 60);
            $table->unsignedBigInteger('vindi_costumer_id')->nullable();

            $table->date('dt_abertura')->nullable();
            $table->boolean('ativo')->default(1);

            $table->string('nome_rua', 50)->nullable();
            $table->integer('numero')->nullable();
            $table->string('cep', 10)->nullable();
            $table->string('cidade', 30)->nullable();
            $table->string('estado', 2)->nullable();


            $table->integer('id_old')->nullable();

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
        Schema::dropIfExists('tenants');
    }
};
