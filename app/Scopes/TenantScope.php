<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Tymon\JWTAuth\Facades\JWTAuth;

class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $token = $_SERVER['HTTP_AUTHORIZATION'];
            $tokenFree = JWTAuth::parseToken($token)->getPayload();
            $perfil = $tokenFree['role_id'];
            $tenantId = $tokenFree['tenant_id'];
            if ($perfil == 1) {
                return;
            } else {
                $builder->where('tenant_id', $tenantId);
            }
        }
    }
}
