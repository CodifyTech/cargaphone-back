<?php

namespace App\Models;

use App\Traits\BelongsTenantScope;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frase extends Model
{
    use HasFactory;

    protected $fillable = [
        'frase',
    ];

}
