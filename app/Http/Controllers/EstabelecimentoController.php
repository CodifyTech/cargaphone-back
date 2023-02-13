<?php

namespace App\Http\Controllers;

use App\Exceptions\InternalServerErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEstabelecimentoRequest;
use App\Http\Requests\UpdateEstabelecimentoRequest;
use App\Http\Resources\EstabelecimentoResource;
use App\Models\Estabelecimento;
use App\Models\User;
use App\Services\EstabelecimentoService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class EstabelecimentoController extends Controller
{
    /**
     *  Injection of dependency with construct
     * @param mixed
     */
    public function __construct(private Estabelecimento $estabelecimento, private EstabelecimentoService $estabelecimentoService)
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
            $this->authorize('viewAny', $this->estabelecimento);
            $estabelecimentos = $this->estabelecimento->select()->paginate();
            return response()->json($estabelecimentos);
        } catch (\Exception $e) {
            if ($e instanceof AuthorizationException) {
                return response()->json([
                    'exception' => 'Unauthorized',
                    'message' => $e->getMessage(),
                ], 401);
            }
            throw new InternalServerErrorException();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEstabelecimentoRequest $request)
    {
        try {
            $this->authorize('create', $this->estabelecimento);
            $estabelecimento = $this->estabelecimentoService->create($request->validated());
            if ($estabelecimento == 'DuplicateCNPJEntry') {
                return response()->json([
                    'Exception' => 'DuplicateCNPJException',
                    'message' => 'Já existe um estabelecimento com este CNPJ.'
                ], 403);
            }

            return new EstabelecimentoResource($estabelecimento);
        } catch (\Exception $e) {
            if ($e instanceof AuthorizationException) {
                return response()->json([
                    'exception' => 'Unauthorized',
                    'message' => $e->getMessage(),
                ], 401);
            }
            throw new InternalServerErrorException();
        }
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
            $this->authorize('view', $this->estabelecimento);
            $estabelecimento = $this->estabelecimento->find($id);
            if (!$estabelecimento) {
                return response()->json([
                    'exception' => 'NotFoundException',
                    'message' => 'Não foi encontrado nenhum estabelecimento com este ID.'
                ], 404);
            }

            return new EstabelecimentoResource($estabelecimento);
        } catch (\Exception $e) {
            if ($e instanceof AuthorizationException) {
                return response()->json([
                    'exception' => 'Unauthorized',
                    'message' => $e->getMessage(),
                ], 401);
            }
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
    public function update(UpdateEstabelecimentoRequest $request, $id)
    {
        try {
            $this->authorize('update', $this->estabelecimento->find($id));
            $estabelecimento = $this->estabelecimentoService->update($request->validated(), $id);
            if ($estabelecimento === 'DuplicateCNPJException') {
                return response()->json([
                    'exception' => 'DuplicateCNPJException',
                    'message' => 'Já existe um estabelecimento com este CNPJ.'
                ], 403);
            }
            if ($estabelecimento === 404) {
                return response()->json([
                    'exception' => 'NotFoundException',
                    'message' => 'Não foi encontrado nenhum estabelecimento com este ID.'
                ], 404);
            }
            return new EstabelecimentoResource($estabelecimento);
        } catch (\Exception $e) {
            if ($e instanceof AuthorizationException) {
                return response()->json([
                    'exception' => 'Unauthorized',
                    'message' => $e->getMessage(),
                ], 401);
            }

            if ($e instanceof QueryException) {
                $cnpj = $request['cnpj'];
                if ($e->errorInfo[2] == "Duplicate entry '$cnpj' for key 'estabelecimentos.estabelecimentos_cnpj_unique'"); {
                    return response()->json([
                        'exception' => 'DuplicateCNPJException',
                        'message' => 'Já existe um estabelecimento com este CNPJ.'
                    ], 403);
                }
            }
            throw new InternalServerErrorException();
        }
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
            $this->authorize('delete', $this->estabelecimento);
            $estabelecimento = $this->estabelecimento->find($id);
            if ($estabelecimento == null)
                return response()->json([
                    'exception' => 'NotFoundException',
                    'message' => 'Não foi encontrado nenhum estabelecimento com este ID.'
                ], 404);

            $estabelecimento->delete();
            return response()->json([
                'message' => 'Estabelecimento excluído com sucesso.'
            ]);
        } catch (\Exception $e) {
            if ($e instanceof AuthorizationException) {
                return response()->json([
                    'exception' => 'Unauthorized',
                    'message' => $e->getMessage(),
                ], 401);
            }
            throw new InternalServerErrorException();
        }
    }

    public function pesquisarNome($nome)
    {
        try {
            $Estabelecimento = Estabelecimento::where('nome', 'like', '%' .  $nome . '%')->paginate();
            return response()->json($Estabelecimento);
        } catch (\Exception $e) {
            if ($e instanceof AuthorizationException) {
                return response()->json([
                    'exception' => 'Unauthorized',
                    'message' => $e->getMessage(),
                ], 401);
            }
            throw new InternalServerErrorException();
        }
    }

    public function pesquisarCnpj($cnpj)
    {
        try {
            $Estabelecimento = Estabelecimento::where('cnpj', 'like', '%' .  $cnpj . '%')->paginate();
            return response()->json($Estabelecimento);
        } catch (\Exception $e) {
            if ($e instanceof AuthorizationException) {
                return response()->json([
                    'exception' => 'Unauthorized',
                    'message' => $e->getMessage(),
                ], 401);
            }
            throw new InternalServerErrorException();
        }
    }

    public function pesquisarResponsavel($responsavel)
    {
        try {
            $Estabelecimento = Estabelecimento::where('nome_responsavel', 'like', '%' .  $responsavel . '%')->paginate();
            return response()->json($Estabelecimento);
        } catch (\Exception $e) {
            if ($e instanceof AuthorizationException) {
                return response()->json([
                    'exception' => 'Unauthorized',
                    'message' => $e->getMessage(),
                ], 401);
            }
            throw new InternalServerErrorException();
        }
    }

    public function pesquisarCidade($cidade)
    {
        try {
            $Estabelecimento = Estabelecimento::where('cidade', 'like', '%' .  $cidade . '%')->paginate();
            return response()->json($Estabelecimento);
        } catch (\Exception $e) {
            if ($e instanceof AuthorizationException) {
                return response()->json([
                    'exception' => 'Unauthorized',
                    'message' => $e->getMessage(),
                ], 401);
            }
            throw new InternalServerErrorException();
        }
    }

    public function pesquisarContato($contato)
    {
        try {
            $Estabelecimento = Estabelecimento::where('contato_responsavel', 'like', '%' .  $contato . '%')->paginate();
            return response()->json($Estabelecimento);
        } catch (\Exception $e) {
            if ($e instanceof AuthorizationException) {
                return response()->json([
                    'exception' => 'Unauthorized',
                    'message' => $e->getMessage(),
                ], 401);
            }
            throw new InternalServerErrorException();
        }
    }

    public function pesquisarCep($cep)
    {
        try {
            $Estabelecimento = Estabelecimento::where('cep', 'like', '%' .  $cep . '%')->paginate();
            return response()->json($Estabelecimento);
        } catch (\Exception $e) {
            if ($e instanceof AuthorizationException) {
                return response()->json([
                    'exception' => 'Unauthorized',
                    'message' => $e->getMessage(),
                ], 401);
            }
            throw new InternalServerErrorException();
        }
    }
}
