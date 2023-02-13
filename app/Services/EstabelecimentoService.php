<?php

namespace App\Services;

use App\Models\Estabelecimento;
use Tymon\JWTAuth\Facades\JWTAuth;

class EstabelecimentoService
{
    public function create(array $data)
    {
        if (Estabelecimento::whereCnpj($data['cnpj'])->exists()) {
            return 'DuplicateCNPJEntry';
        }

        $token = $_SERVER['HTTP_AUTHORIZATION'];
        $tokenFree = JWTAuth::parseToken($token)->getPayload();
        $tenantId = $tokenFree['tenant_id'];
        $data['tenant_id'] = $tenantId;

        $estabelecimento = Estabelecimento::create($data);
        return $estabelecimento;
    }

    public function update(array $data, string $id)
    {
        $estabelecimento = Estabelecimento::find($id);

        if (!$estabelecimento) {
            return 404;
        }

        if ($data['cnpj']) {
            if ($estabelecimento->cnpj !== $data['cnpj']) {
                if ($this->existeCnpj($data['cnpj'])) {
                    return 'DuplicateCNPJException';
                }
            }
        }

        $token = $_SERVER['HTTP_AUTHORIZATION'];
        $tokenFree = JWTAuth::parseToken($token)->getPayload();
        $tenantId = $tokenFree['tenant_id'];
        $data['tenant_id'] = $tenantId;
        $estabelecimento->update($data);
        return $estabelecimento;
    }

    public function existeCnpj($cnpj)
    {
        return Estabelecimento::where('cnpj', $cnpj)->exists();
    }
}
