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
            $table->string('descricao', 100);
            $table->boolean('ativo')->default(1);

            $table->string('estabelecimento_id')->nullable();
            $table->foreign('estabelecimento_id')->references('id')->on('estabelecimentos');
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
        Schema::dropIfExists('totems');
    }
};
