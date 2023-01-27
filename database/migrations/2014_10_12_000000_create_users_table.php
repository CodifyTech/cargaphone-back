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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 60);
            $table->string('email', 60)->unique();
            $table->string('password');
            $table->tinyInteger('perfil');

            $table->string('cpf_usuario', 14)->unique()->nullable();
            $table->string('rg_usuario', 20)->nullable();
            $table->string('sexo', 1)->nullable();
            $table->date('dt_nascimento')->nullable();
            $table->string('tel_contato', 15)->nullable();
            $table->boolean('is_whatsapp')->nullable();
            $table->string('foto_perfil')->nullable();

            $table->string('nome_rua', 50)->nullable();
            $table->integer('numero_residencia')->nullable();
            $table->string('cep', 10)->nullable();
            $table->string('cidade', 30)->nullable();
            $table->string('bairro', 30)->nullable();
            $table->string('estado', 2)->nullable();

            $table->string('confirmation_token')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
