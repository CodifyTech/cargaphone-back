<?php

namespace App\Services;

use App\Models\Anuncio;
use App\Utils\Token;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class AnuncioService
{
    public function create($data, $totemId)
    {
        $extensaoArquivo = $data['arquivo']->getClientOriginalExtension();
        $nome = Uuid::uuid6() . '.' . $extensaoArquivo;
        $data['arquivo']->storePubliclyAs('anuncios/', $nome, 's3');
        $data['arquivo'] = $nome;
        if (strlen($data['data_comeco_campanha']) === 0) {
            $dataHoje = Carbon::now();
            $data['data_comeco_campanha'] = $dataHoje;
        }
        $payload = Token::decode();
        $data['tenant_id'] = $payload['tenant_id'];
        $anuncio = Anuncio::create($data);

        if (isset($totemId)) {
            $anuncio->totems()->sync($totemId);
        }

        return $anuncio;
    }

    public function update($data, $id)
    {
        $anuncio = Anuncio::find($id);
        if ($anuncio == null)
            return '404';

        $anuncio->fill($data->except('arquivo'));
        if ($arquivo = $data->hasFile('arquivo')) {
            $arquivo = $data->file('arquivo');
            $extensaoArquivo = $arquivo->getClientOriginalExtension();
            $nomeArquivo = Uuid::uuid6() . '.' . $extensaoArquivo;
            $caminhoArquivo = public_path() . '/storage/anuncios/';
            $arquivo->move($caminhoArquivo, $nomeArquivo);
            $anuncio->arquivo = $nomeArquivo;
        }
        $anuncio->save();
        return $anuncio;
    }

    public function existeEmail($email)
    {
        return Anuncio::where('email_contato', $email)->withTrashed()->exists();
    }

    public function syncAnuncioTotem($data)
    {
        $anuncio = Anuncio::find($data['anuncio_id']);
        if (!$anuncio)
            return 404;

        $anuncio->totems()->sync($data['totem_id']);
        return $anuncio;
    }

    public function faturamento()
    {
        $payload = Token::decode();
        if ($payload['role_id'] == 1) {
            $total = Anuncio::sum('anuncios.valor_anuncio_mensal');
        }
        if ($payload['role_id'] == 2) {
            $total = Anuncio::where('tenant_id', $payload['tenant_id'])->sum('anuncios.valor_anuncio_mensal');
        }
        return $total;
    }
}
