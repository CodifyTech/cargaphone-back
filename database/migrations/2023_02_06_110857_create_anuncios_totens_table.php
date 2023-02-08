<?php

use App\Models\Anuncio;
use App\Models\Totem;
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
        Schema::create('anuncio_totem', function (Blueprint $table) {

            $table->foreignIdFor(Anuncio::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Totem::class)->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anuncios_totens');
    }
};
