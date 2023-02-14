<?php

namespace App\Utils;

use Tymon\JWTAuth\Facades\JWTAuth;

class Token
{
    public static function decode()
    {
        $token = $_SERVER['HTTP_AUTHORIZATION'];
        $payloadToken = JWTAuth::parseToken($token)->getPayload();
        return $payloadToken;
    }
}
