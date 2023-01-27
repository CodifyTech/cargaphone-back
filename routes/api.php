<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::post('auth/login', [AuthController::class, 'login']);

Route::get('ping', function () {
    return response()->json([
        'message' => 'pong'
    ]);
});

Route::middleware('auth:api')->group(function () {

    Route::prefix('usuario')->group(function () {
        Route::get('pesquisarpor/nome/{nome}', [UserController::class, 'pesquisarNome']);
        Route::get('pesquisarpor/email/{email}', [UserController::class, 'pesquisarEmail']);
        Route::get('pesquisarpor/cpf/{cpf}', [UserController::class, 'pesquisarCpf']);
        Route::get('pesquisarpor/rg/{rg}', [UserController::class, 'pesquisarRg']);
        Route::get('pesquisarpor/cidade/{cidade}', [UserController::class, 'pesquisarCidade']);
        Route::get('', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::get('/token', [AuthController::class, 'refreshToken']);
        Route::post('', [UserController::class, 'registerUser']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });

    Route::prefix('unidade')->group(function () {        

        Route::get('pesquisarpor/nome/{nome}', [UnidadeController::class, 'pesquisarNome']);
        Route::get('pesquisarpor/cnpj/{cnpj}', [UnidadeController::class, 'pesquisarCnpj']);
        Route::get('pesquisarpor/responsavel/{responsavel}', [UnidadeController::class, 'pesquisarResponsavel']);
        Route::get('pesquisarpor/cidade/{cidade}', [UnidadeController::class, 'pesquisarCidade']);
        Route::get('pesquisarpor/estado/{estado}', [UnidadeController::class, 'pesquisarEstado']);

        Route::get('', [UnidadeController::class, 'index']);
        Route::get('/{id}', [UnidadeController::class, 'show']);
        Route::put('/{id}', [UnidadeController::class, 'update']);
        Route::delete('/{id}', [UnidadeController::class, 'destroy']);
        Route::post('', [UnidadeController::class, 'store']);
    });

    // Route::delete('force-exclusao/{id}', [UserController::class, 'forceDeleteUser']);

    Route::post('verificar-email', [AuthController::class, 'verifyEmail']);
});
Route::post('esqueceu-senha', [AuthController::class, 'forgotPassword']);
Route::post('recuperar-senha', [AuthController::class, 'resetPassword']);
