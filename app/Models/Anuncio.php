<?php

namespace App\Models;

use App\Traits\BelongsTenantScope;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anuncio extends Model
{
    use HasFactory, BelongsTenantScope, Uuid, SoftDeletes;

    protected $fillable = [
        'nome',
        'arquivo',
        'nome_anunciante',
        'valor_anuncio_mensal',
        'data_comeco_campanha',
        'data_fim_campanha',
        'tipo_campanha',
        'ativo',
        'tel_contato_anunciante',
        'email_contato',
        'totem_id',
        'tenant_id'
    ];

    protected function arquivo(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => 'http://' . $_SERVER['HTTP_HOST'] . "/storage/anuncios/" . $value,
        );
    }

    public function totems()
    {
        return $this->belongsToMany(Totem::class);
    }

    public function unidade()
    {
        return $this->BelongsTo(Unidade::class);
    }

    public $incrementing = false;

    protected $keyType = 'uuid';
}
