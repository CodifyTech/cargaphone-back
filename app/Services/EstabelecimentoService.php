<?php

namespace App\Services;

use App\Models\Estabelecimento;
use App\Utils\Token;


class EstabelecimentoService
{
    public function create(array $data)
    {
        if ($this->existeCnpj($data['cnpj'])) return '403';

        $payload = Token::decode();
        $data['tenant_id'] = $payload['tenant_id'];
        $estabelecimento = Estabelecimento::create($data);
        return $estabelecimento;
    }

    public function update(array $data, string $id)
    {
        $estabelecimento = Estabelecimento::find($id);

        if (!$estabelecimento) {
            return 404;
        }

        if ($estabelecimento->cnpj !== $data['cnpj']) {
            if ($this->existeCnpj($data['cnpj'])) {
                return 'DuplicateCNPJException';
            }
        }
        $payload = Token::decode();
        $data['tenant_id'] = $payload['tenant_id'];
        $estabelecimento->update($data);
        return $estabelecimento;
    }

    public function existeCnpj($cnpj)
    {
        return Estabelecimento::where('cnpj', $cnpj)->exists();
    }
}
