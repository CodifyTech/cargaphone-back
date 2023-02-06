<?php

use App\Http\Controllers\{AnuncioController, AuthController, EstabelecimentoController, TotemController, UnidadeController, UserController};
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

    Route::get('user', function () {
        if (auth()->user() == null) {
            return response()->json(['Unauthenticated.'], 401);
        } else {
            return response()->json([
                auth()->user()
            ]);
        }
    });

    Route::prefix('estabelecimento')->group(function () {
        Route::get('', [EstabelecimentoController::class, 'index']);
        Route::post('', [EstabelecimentoController::class, 'store']);
        Route::get('/{id}', [EstabelecimentoController::class, 'show']);
        Route::put('/{id}', [EstabelecimentoController::class, 'update']);
        Route::delete('/{id}', [EstabelecimentoController::class, 'destroy']);
        Route::get('pesquisarpor/nome/{nome}', [EstabelecimentoController::class, 'pesquisarNome']);
        Route::get('pesquisarpor/cnpj/{cnpj}', [EstabelecimentoController::class, 'pesquisarCnpj']);
        Route::get('pesquisarpor/responsavel/{responsavel}', [EstabelecimentoController::class, 'pesquisarResponsavel']);
        Route::get('pesquisarpor/cidade/{cidade}', [EstabelecimentoController::class, 'pesquisarCidade']);
        Route::get('pesquisarpor/contato/{contato}', [EstabelecimentoController::class, 'pesquisarContato']);
        Route::get('pesquisarpor/cep/{cep}', [EstabelecimentoController::class, 'pesquisarCep']);
    });

    Route::prefix('totem')->group(function () {
        Route::get('', [TotemController::class, 'index']);
        Route::post('', [TotemController::class, 'store']);
        Route::get('/{id}', [TotemController::class, 'show']);
        Route::put('/{id}', [TotemController::class, 'update']);
        Route::delete('/{id}', [TotemController::class, 'destroy']);
        Route::get('/pesquisarpor/nome/{nome}', [TotemController::class, 'pesquisarNome']);
        Route::get('/pesquisarpor/identificador/{identificador}', [TotemController::class, 'pesquisarIdentificador']);
    });


    Route::prefix('anuncio')->group(function () {
        Route::get('', [AnuncioController::class, 'index']);
        Route::post('', [AnuncioController::class, 'store']);
        Route::get('/{id}', [AnuncioController::class, 'show']);
        Route::put('/{id}', [AnuncioController::class, 'update']);
        Route::post('/vincular/anuncio/totem', [AnuncioController::class, 'vincularAnuncioTotem']);
        Route::delete('/{id}', [AnuncioController::class, 'destroy']);
        Route::get('/pesquisarpor/nome/{nome}', [AnuncioController::class, 'pesquisarNome']);
        Route::get('/pesquisarpor/telefone/{telefone}', [AnuncioController::class, 'pesquisarTelContato']);
        Route::get('/pesquisarpor/email/{email}', [AnuncioController::class, 'pesquisarEmailContato']);
        Route::get('/pesquisarpor/nome_anunciante/{nomeAnunciante}', [AnuncioController::class, 'pesquisarNomeAnunciante']);
    });


    Route::post('verificar-email', [AuthController::class, 'verifyEmail']);
    // Route::delete('force-exclusao/{id}', [UserController::class, 'forceDeleteUser']);
});
Route::post('esqueceu-senha', [AuthController::class, 'forgotPassword']);
Route::post('recuperar-senha', [AuthController::class, 'resetPassword']);
