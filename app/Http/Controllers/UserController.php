<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorDeletingException;
use App\Exceptions\InternalServerErrorException;
use App\Exceptions\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    /**
     *  Injection of dependency with construct
     * @param mixed
     */
    public function __construct(private UserService $userService)
    {
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $users = User::select()->paginate();
            return response()->json($users, 200);
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registerUser(RegisterUserRequest $request)
    {
        $user = $this->userService->registerUser($request->validated());
        if ($user == '403') {
            return response()->json([
                'exception' => 'EmailHasBeenTaken',
                'message' => 'Este e-mail já existe. Você não está autorizado a criar um usuário.',
            ], 403);
        }
        if ($user == 'CpfHasBeenTaken') {
            return response()->json([
                'exception' => 'CpfHasBeenTaken',
                'message' => 'Já existe uma pessoa com este CPF.',
            ], 403);
        }
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = User::find($id);
            return response()->json($user);
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->userService->updateUser($request, $id);
        if ($user == '403') {
            return response()->json([
                'exception' => 'EmailHasBeenTaken',
                'message' => 'Este e-mail já existe. Você não está autorizado a criar um usuário.',
            ], 403);
        }
        if ($user == 'CpfHasBeenTaken') {
            return response()->json([
                'exception' => 'CpfHasBeenTaken',
                'message' => 'Já existe uma pessoa com este CPF.',
            ], 403);
        }
        if ($user == 'EmailHasBeenTaken') {
            return response()->json([
                'exception' => 'EmailHasBeenTaken',
                'message' => 'Já existe uma pessoa com este e-mail.',
            ], 403);
        }
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);
            $user->delete();
        } catch (\Exception $e) {
            throw new ErrorDeletingException();
        }
    }

    public function forceDeleteUser(User $user, $id)
    {
        try {
            $user = $user->find($id)->forceDelete();
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }

    public function pesquisarNome($nome)
    {
        try {
            $users = User::where('name', 'like', '%' .  $nome . '%')->paginate();
            return response()->json($users);
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }

    public function pesquisarCpf($cpf)
    {
        try {
            $users = User::where('cpf_usuario', 'like', '%' .  $cpf . '%')->paginate();
            return response()->json($users);
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }

    public function pesquisarRg($rg)
    {
        try {
            $users = User::where('rg_usuario', 'like', '%' .  $rg . '%')->paginate();
            return response()->json($users);
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }

    public function pesquisarEmail($email)
    {
        try {
            $users = User::where('email', 'like', '%' .  $email . '%')->paginate();
            return response()->json($users);
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }

    public function pesquisarCidade($cidade)
    {
        try {
            $users = User::where('cidade', 'like', '%' .  $cidade . '%')->paginate();
            return response()->json($users);
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }
}
