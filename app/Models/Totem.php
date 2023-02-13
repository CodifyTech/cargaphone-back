<?php

namespace App\Models;

use App\Traits\BelongsTenantScope;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\BelongsToRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Totem extends Model
{
    use HasFactory, BelongsTenantScope, Uuid, SoftDeletes;

    protected $fillable = [
        'nome',
        'descricao',
        'identificador',
        'ativo',
        'estabelecimento_id',
        'tenant_id'
    ];

    public $incrementing = false;

    protected $keyType = 'uuid';

    public function estabelecimento(): BelongsTo
    {
        return $this->belongsTo(Estabelecimento::class);
    }

    public function anuncios(): BelongsToMany
    {
        return $this->belongsToMany(Anuncio::class);
    }

    public function unidade(): BelongsTo
    {
        return $this->belongsTo(Unidade::class);
    }
}
