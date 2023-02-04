<?php

namespace App\Models;

use App\Traits\BelongsTenantScope;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'tenant_id'
    ];

    public $incrementing = false;

    protected $keyType = 'uuid';

    public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }
}
