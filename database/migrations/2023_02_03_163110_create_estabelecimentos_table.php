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
        Schema::create('estabelecimentos', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('nome', 40);
            $table->unsignedBigInteger('tenant_id');
            $table->string('razao_social', 40);
            $table->string('cnpj', 25)->unique();
            $table->tinyInteger('segmentacao', 1);
            $table->string('responsavel', 60);
            $table->string('contato_responsavel', 35);

            $table->string('cep', 10);
            $table->string('endereco', 50);
            $table->string('cidade', 30);
            $table->string('complemento', 30)->nullable();
            $table->string('estado', 2);
            $table->softDeletes();


            $table->foreign('tenant_id')->references('id')->on('unidades');
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
        Schema::dropIfExists('estabelecimentos');
    }
};
