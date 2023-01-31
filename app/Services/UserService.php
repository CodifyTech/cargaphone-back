<?php

namespace App\Services;

use App\Exceptions\CpfHasBeenTaken;
use App\Exceptions\InternalServerErrorException;
use Illuminate\Support\Str;
use App\Exceptions\UserHasBeenTakenException;
use App\Exceptions\WrongCpf;
use App\Models\User;
use Illuminate\Database\QueryException;
use Ramsey\Uuid\Uuid;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService
{
    public function registerUser($request)
    {
        try {
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
                $arquivo = $request['foto_perfil']->storeAs('public/foto_perfil', $nome);
                $request['foto_perfil'] = $nome;
            }

            $request['password'] = $userPassword;

            $token = $_SERVER['HTTP_AUTHORIZATION'];
            $tokenFree = JWTAuth::parseToken($token)->getPayload();
            $tenantId = $tokenFree['tenant_id'];
            $request['tenant_id'] = $tenantId;

            $user = User::create($request);
            //event(new UserRegistered($user));

            return $user;
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }

    public function updateUser($request, $id)
    {
        try {
            $user = User::find($id);

            if (empty($user)) {
                return '403';
            }

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
            if ($foto = $request->hasFile('foto_perfil')) {
                $foto = $request->file('foto_perfil');
                $extensaoArquivo = $foto->getClientOriginalExtension();
                $nomeArquivo = Uuid::uuid6() . '.' . $extensaoArquivo;
                $caminhoArquivo = public_path() . '/storage/foto_perfil/';
                $foto->move($caminhoArquivo, $nomeArquivo);
                $user->foto_perfil = $nomeArquivo;
            }
            $user->save();

            return $user;
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }

    public function existeCpf($cpf)
    {
        return User::where('cpf_usuario', $cpf)->exists();
    }

    public function existeEmail($email)
    {
        return User::where('email', $email)->exists();
    }
}
