<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unidade extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'cnpj_empresa',
        'nome_responsavel',
        'dt_abertura',
        'email',
        'nome_rua',
        'numero',
        'cep',
        'cidade',
        'estado',
    ];


    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    function estabelecimentos(): HasMany
    {
        return $this->hasMany(Estabelecimento::class);
    }

    public function totens(): HasMany
    {
        return $this->hasMany(Totem::class);
    }

    public function anuncios(): HasMany
    {
        return $this->hasMany(Anuncio::class);
    }
}
