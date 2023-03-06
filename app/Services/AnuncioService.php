<?php

namespace App\Services;

use App\Models\Anuncio;
use App\Utils\Token;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
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

        $urlAnuncio = parse_url($anuncio->arquivo, PHP_URL_PATH);
        $arquivoAtual = basename($urlAnuncio);
    
        $anuncio->fill($data->except('arquivo'));
        if ($arquivo = $data->hasFile('arquivo')) {
            if(Storage::disk('s3')->get('anuncios/'. $arquivoAtual) !== null) {
                Storage::disk('s3')->delete('anuncios/' . $arquivoAtual);
            }
            $arquivo = $data->file('arquivo');
            $extensaoArquivo = $arquivo->getClientOriginalExtension();
            $nomeArquivo = Uuid::uuid6() . '.' . $extensaoArquivo;
            $data['arquivo']->storePubliclyAs('anuncios/', $nomeArquivo, 's3');
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
