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
        Schema::create('totems', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nome', 40);
            $table->string('identificador', 40);
            $table->string('descricao', 100)->nullable();
            $table->string('ip', 100)->nullable();
            $table->string('latitude', 50)->nullable();
            $table->string('longitude', 50)->nullable();
            $table->dateTime('ultima_conexao')->nullable();
            $table->string('conexao_id', 100)->nullable();




            $table->boolean('ativo')->default(1);
            $table->unsignedBigInteger('tenant_id')->nullable();

            $table->string('estabelecimento_id')->nullable();
            $table->foreign('estabelecimento_id')->references('id')->on('estabelecimentos');

            $table->integer('id_old')->nullable();
            $table->integer('tenant_id_old')->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->foreign('tenant_id')->references('id')->on('unidades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('totems');
    }
};
