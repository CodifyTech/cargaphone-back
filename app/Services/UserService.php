<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class UserService
{
    public function registerUser($request)
    {
        $existeEmail = User::where('email', $request['email'])->withTrashed()->exists();
        if ($existeEmail) {
            return 403;
        }
        if (isset($request['cpf_usuario'])) {
            if ($this->existeCpf($request['cpf_usuario'])) {
                return 'CpfHasBeenTaken';
            }
        }

        $userPassword = bcrypt($request['password'] ?? Str::random(10));
        if (isset($request['foto_perfil'])) {
            $extensaoArquivo = $request['foto_perfil']->getClientOriginalExtension();
            $nome = Uuid::uuid6() . '.' . $extensaoArquivo;
            $request['foto_perfil']->storePubliclyAs('fotos_perfil/', $nome, 's3');
            $request['foto_perfil'] = $nome;
        }
        $request['password'] = $userPassword;
        $user = User::create($request);

        //event(new UserRegistered($user));

        return $user;
    }

    public function updateUser($request, $id)
    {

        $user = User::find($id);

        if (empty($user)) {
            return '404';
        }
        $urlFoto = parse_url($user->foto_perfil, PHP_URL_PATH);
        $arquivoAtual = basename($urlFoto);
        $caminhoS3 = 'fotos_perfil/';
        if (isset($request['cpf_usuario'])) {
            if ($user->cpf_usuario != $request['cpf_usuario']) {
                if ($this->existeCpf($request['cpf_usuario'])) {
                    return 'CpfHasBeenTaken';
                }
            }
        }

        if ($user->email != $request['email']) {
            if ($this->existeEmail($request['email'])) {
                return 'EmailHasBeenTaken';
            }
        }

        $user->fill($request->except('foto_perfil'));
        if ($request->hasFile('foto_perfil')) {
            if (Storage::disk('s3')->get($caminhoS3 . $arquivoAtual) !== null) {
                Storage::disk('s3')->delete($caminhoS3 . $arquivoAtual);
            }
            $foto = $request->file('foto_perfil');
            $extensaoArquivo = $foto->getClientOriginalExtension();
            $nomeArquivo = Uuid::uuid6() . '.' . $extensaoArquivo;
            $request['foto_perfil']->storePubliclyAs($caminhoS3, $nomeArquivo, 's3');
            $user->foto_perfil = $nomeArquivo;
        }
        $user->save();

        return $user;
    }

    public function existeCpf($cpf)
    {
        return User::where('cpf_usuario', $cpf)->withTrashed()->exists();
    }

    public function existeEmail($email)
    {
        return User::where('email', $email)->withTrashed()->exists();
    }
}
