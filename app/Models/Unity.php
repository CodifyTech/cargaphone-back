<?php

namespace App\Models;

use App\Traits\BelongsTenantScope;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unity extends Model
{
    use HasFactory, BelongsTenantScope, Uuid;

    protected $fillable = [
        'endereco',
        'tenant_id',
    ];

    public $incrementing = false;

    protected $keyType = 'uuid';

}
