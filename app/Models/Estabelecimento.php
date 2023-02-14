<?php

namespace App\Models;

use App\Enums\Segmentacao;
use App\Traits\BelongsTenantScope;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class Estabelecimento extends Model
{
    use HasFactory, BelongsTenantScope, Uuid, SoftDeletes;

    protected $fillable = [
        'nome',
        'razao_social',
        'cnpj',
        'responsavel',
        'contato_responsavel',
        'cep',
        'endereco',
        'cidade',
        'complemento',
        'estado',
        'segmentacao',
        'tenant_id'
    ];

    protected $casts = [
        'segmentacao' => Segmentacao::class
    ];

    public $incrementing = false;

    protected $keyType = 'uuid';

    public function unidade() :BelongsTo
    {
        return $this->belongsTo(Unidade::class);
    }

    public function totens(): HasMany
    {
        return $this->hasMany(Totem::class);
    }


}
