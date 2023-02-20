<?php

namespace App\Http\Controllers;

use App\Exceptions\InternalServerErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUnidadeRequest;
use App\Http\Requests\UpdateUnidadeRequest;
use App\Models\Unidade;
use App\Services\UnidadeService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class UnidadeController extends Controller
{
    /**
     *  Injection of dependency with construct
     * @param mixed
     */
    public function __construct(private Unidade $unidade, private UnidadeService $unidadeService)
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
            $this->authorize('viewAny', User::class);

            $unidades = $this->unidade->paginate();
            return response()->json($unidades, 200);
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
    public function store(CreateUnidadeRequest $request)
    {
        try {
            $this->authorize('create', User::class);

            $unidade = $this->unidadeService->create($request->validated());
            if($unidade == 'DuplicateCNPJEntry') {
                return response()->json([
                    'Exception' => 'DuplicateCNPJException',
                    'message' => 'Já existe uma unidade franqueada com este CNPJ.'
                ], 403);
            }
            if($unidade == '403') {
                return response()->json([
                    'Exception' => 'DuplicateEmailException',
                    'message' => 'Já existe uma unidade franqueada com este E-MAIL.'
                ], 403);
            }
            return response()->json($unidade, 201);
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
            $this->authorize('view', User::class);

            $unidade = $this->unidade->find($id);
            if ($unidade == null) {
                return response()->json([
                    'message' => 'Não foi encontrado nenhuma unidade.'
                ], 404);
            }
            return response()->json($unidade, 200);
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
    public function update(UpdateUnidadeRequest $request, $id)
    {
        try {
            $this->authorize('update', User::class);

            $unidade = $this->unidadeService->update($request->validated(), $id);
            if($unidade == 'NotFoundException') {
                return response()->json([
                    'exception' => 'NotFoundException',
                    'message' => 'Não foi encontrado nenhuma unidade com este ID.'
                ], 404);
            }
            if ($unidade == 'DuplicateCNPJEntry') {
                return response()->json([
                    'Exception' => 'DuplicateCNPJException',
                    'message' => 'Já existe uma unidade franqueada com este CNPJ.'
                ], 403);
            }
            return response()->json($unidade);
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
     * Faz soft-delete na unidade especificada.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->authorize('delete', User::class);

            $unidade = $this->unidade->find($id);
            if ($unidade == null) {
                return response()->json([
                    'message' => 'Não foi encontrado nenhuma unidade.'
                ], 404);
            }
            $unidade->delete();
            return response()->json([
                'message' => 'Excluido com sucesso'
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
            $this->authorize('viewAny', User::class);
            $unidade = Unidade::where('nome', 'like', '%' .  $nome . '%')->paginate();
            return response()->json($unidade);
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
            $this->authorize('viewAny', User::class);
            $unidade = Unidade::where('cnpj_empresa', 'like', '%' .  $cnpj . '%')->paginate();
            return response()->json($unidade);
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
            $this->authorize('viewAny', User::class);
            $unidade = Unidade::where('nome_responsavel', 'like', '%' .  $responsavel . '%')->paginate();
            return response()->json($unidade);
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
            $this->authorize('viewAny', User::class);
            $unidade = Unidade::where('cidade', 'like', '%' .  $cidade . '%')->paginate();
            return response()->json($unidade);
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

    public function pesquisarEstado($estado)
    {
        try {
            $this->authorize('viewAny', User::class);
            $unidade = Unidade::where('estado', 'like', '%' .  $estado . '%')->paginate();
            return response()->json($unidade);
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
