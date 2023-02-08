<?php

namespace App\Services;


use App\Models\Totem;
use Tymon\JWTAuth\Facades\JWTAuth;

class TotemService
{
    public function create(array $data)
    {

        $token = $_SERVER['HTTP_AUTHORIZATION'];
        $tokenFree = JWTAuth::parseToken($token)->getPayload();
        $tenantId = $tokenFree['tenant_id'];
        $data['tenant_id'] = $tenantId;

        $estabelecimento = Totem::create($data);
        return $estabelecimento;
    }

}
