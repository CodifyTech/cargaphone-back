<?php

namespace App\Services;

use App\Models\Anuncio;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class AnuncioService
{
    public function create($data, $totemId)
    {
        $existeEmail = Anuncio::where('email_contato', $data['email_contato'])->withTrashed()->exists();
        if ($existeEmail)
            return 403;

        $extensaoArquivo = $data['arquivo']->getClientOriginalExtension();
        $nome = Uuid::uuid6() . '.' . $extensaoArquivo;
        $data['arquivo']->storeAs('public/anuncios', $nome);
        $data['arquivo'] = $nome;
        $dataHoje = Carbon::now();
        $data['data_comeco_campanha'] = $dataHoje;
        $anuncio = Anuncio::create($data);
        if ($totemId)
            $anuncio->totems()->sync($totemId);

        return $anuncio;
    }

    public function update($data, $id)
    {
        $anuncio = Anuncio::find($id);
        if ($anuncio->email_contato != $data['email_contato']) {
            if ($this->existeEmail($data['email_contato'])) {
                return 'EmailHasBeenTaken';
            }
        }
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
        return Anuncio::where('email_contato', $email)->exists();
    }

    public function syncAnuncioTotem($data)
    {
        $anuncio = Anuncio::find($data['anuncio_id']);
        if (!$anuncio)
            return 403;

        $anuncio->totems()->sync($data['totem_id']);
        return $anuncio;
    }
}
