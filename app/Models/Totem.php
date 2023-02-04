<?php

namespace App\Models;

use App\Traits\BelongsTenantScope;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Totem extends Model
{
    use HasFactory, BelongsTenantScope, Uuid, SoftDeletes;

    protected $fillable = [
        'nome',
        'descricao',
        'identificador',
        'ativo',
        'estabelecimento_id'
    ];

    public $incrementing = false;

    protected $keyType = 'uuid';

    public function estabelecimento()
    {
        return $this->belongsTo(Estabelecimento::class);
    }
}
