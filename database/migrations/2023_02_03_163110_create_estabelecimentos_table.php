<?php

use Carbon\Carbon;
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
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->string('razao_social', 40)->nullable();
            $table->string('documento_legal', 50)->nullable();
            $table->string('cnpj', 25)->unique()->nullable();
            $table->tinyInteger('segmentacao')->nullable();
            $table->string('responsavel', 60);
            $table->string('email_responsavel', 35);
            $table->string('telefone_responsavel', 15)->nullable();

            $table->string('cep', 10);
            $table->string('endereco', 50);
            $table->integer('numero')->nullable();
            $table->string('cidade', 30);
            $table->string('complemento', 30)->nullable();
            $table->string('estado', 2);
            $table->dateTime('data_ativacao')->default(Carbon::now());

            $table->integer('id_old')->nullable();
            $table->integer('tenant_id_old')->nullable();

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
