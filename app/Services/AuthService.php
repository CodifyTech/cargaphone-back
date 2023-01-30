<?php

namespace App\Services;

use App\Events\ForgotPassword;
use App\Events\UserRegistered;
use App\Exceptions\InternalServerErrorException;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function login(array $credentials)
    {
        try {
            $user = User::where('email', $credentials['email'])->first();
            if ($user) {
                $token = auth()->claims([
                    'name' => $user->name,
                    'role_id' => $user->perfil,
                    'tenant_id' => $user->tenant_id
                ])->attempt($credentials);

                if (!$token) return 'LoginInvalidException';
                return [
                    'token' => $token,
                ];
            }
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }

    public function verifyEmail(string $token)
    {
        try {
            $user = User::where('confirmation_token', $token)->first();
            if (empty($user)) {
                return 'VerifyEmailTokenInvalidException';
            }
            $user->confirmation_token = null;
            $user->email_verified_at = now();
            $user->save();

            return $user;
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }

    public function forgotPassword(string $email)
    {
        try {
            $user = User::where('email', $email)->first();
            if (!$user) {
                return 'DoesNotExistsWithThisEmailException';
            }
            $token = Str::random(60);
            PasswordReset::create([
                'email' => $user->email,
                'token' => $token,
            ]);

            event(new ForgotPassword($user, $token));

            return '';
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }

    public function resetPassword(string $email, string $password, string $token)
    {
        try {
            $passReset = PasswordReset::where('email', $email)->where('token', $token)->first();
            if (empty($passReset)) {
                return 'ResetPasswordTokenInvalidException';
            }

            $user = User::where('email', $email)->firstOrFail();
            $user->password = bcrypt($password);
            $user->save();

            PasswordReset::where('email', $email)->delete();

            return '';
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }
}
