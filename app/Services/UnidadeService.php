<?php

namespace App\Services;

use App\Models\Unidade;

class UnidadeService
{
    public function create(array $data)
    {
        if ($this->existeCnpj($data['cnpj_empresa'])) {
            return 'DuplicateCNPJEntry';
        }
        $unidade = Unidade::create($data);
        return $unidade;
    }

    public function update(array $data, $id)
    {
        $unidade = Unidade::find($id);
        if($unidade->cnpj_empresa != $data['cnpj_empresa']) {
            if ($this->existeCnpj($data['cnpj_empresa'])) {
                return 'DuplicateCNPJEntry';
            }
        }
        if ($unidade == null) {
            return 'NotFoundException';
        }
        $unidade->update($data);
        return $unidade;
    }

    public function existeCnpj($cnpj)
    {
        return Unidade::where('cnpj_empresa', $cnpj)->exists();
    }
}
