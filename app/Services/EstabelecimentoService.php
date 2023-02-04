<?php

namespace App\Services;

use App\Models\Estabelecimento;

class EstabelecimentoService
{
    public function create(array $data)
    {
        if ($existeCnpj = Estabelecimento::whereCnpj($data['cnpj'])->exists()) {
            return 'DuplicateCNPJEntry';
        }

        $estabelecimento = Estabelecimento::create($data);
        return $estabelecimento;
    }

    public function updateEstablishment(array $data, string $id)
    {
        $estabelecimento = Estabelecimento::find($id);

        if (!$estabelecimento) {
            return 403;
        }

        if (isset($data['cnpj'])) {
            if ($estabelecimento->cnpj !== $data['cnpj']) {
                if ($this->existeCnpj($data['cnpj'])) {
                    return 'DuplicateCNPJException';
                }
            }
        }
        $estabelecimento->update($data);
        return $estabelecimento;
    }

    public function existeCnpj($cnpj)
    {
        return Estabelecimento::whereCnpj($cnpj)->exists();
    }
}
