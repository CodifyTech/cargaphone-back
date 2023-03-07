<?php

namespace App\Models;

use App\Enums\CategoriaAnuncio;
use App\Traits\BelongsTenantScope;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

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

    protected $casts = [
        'tipo_campanha' => CategoriaAnuncio::class,
        'exclude' => 'boolean',
        'dataAlteracao' => 'datetime:d/m/Y'
    ];

    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Storage::disk('s3')->url('anuncios/' . $value),
        );
    }

    protected function arquivo(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Storage::disk('s3')->url('anuncios/' . $value),
        );
    }

    public function totems(): BelongsToMany
    {
        return $this->belongsToMany(Totem::class);
    }

    public function unidade(): BelongsTo
    {
        return $this->BelongsTo(Unidade::class);
    }

    public $incrementing = false;

    protected $keyType = 'uuid';
}
