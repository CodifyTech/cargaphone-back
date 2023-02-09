<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\{
    ForgotPasswordRequest,
    ResetPasswordRequest,
    VerifyEmailRequest,
    LoginRequest,
    RegisterUserRequest
};
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $token = $this->authService->login($credentials);
        if ($token == 'LoginInvalidException' || $token == null) {
            return response()->json([
                'exception' => 'LoginInvalidException',
                'message' => 'E-mail e/ou senha incorretos.'
            ], 401);
        }
        return (new UserResource(auth()->user()))->additional([
            'sal' => '123',
           'token' => $token
        ]);
    }

    public function verifyEmail(VerifyEmailRequest $request)
    {
        $creds = $request->validated();
        $emailVerified =  $this->authService->verifyEmail($creds['token']);
        if ($emailVerified == 'VerifyEmailTokenInvalidException') {
            return response()->json([
                'exception' => 'VerifyEmailTokenInvalidException',
                'message' => 'Este token é inválido'
            ], 401);
        }
        return new UserResource($emailVerified);
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $credentials = $request->validated();
        $token =  $this->authService->forgotPassword($credentials['email']);
        if ($token == 'DoesNotExistsWithThisEmailException') {
            return response()->json([
                'exception' => 'EmailDoesNotExistsException',
                'message' => 'Não existe uma pessoa com este e-mail.'
            ], 404);
        }
        return response()->json([
            'message' => 'Email enviado com sucesso.'
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $credentials = $request->validated();
        $message = $this->authService->resetPassword($credentials['email'], $credentials['password'], $credentials['token']);
        return response()->json([
            'message' => 'Senha alterada com sucesso!'
        ]);
    }

    public function refreshToken()
    {
        $newToken = auth()->refresh();
        return response()->json([
            'token' => $newToken
        ]);
    }
}
