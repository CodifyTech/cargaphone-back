<?php

namespace App\Http\Controllers;

use App\Exceptions\InternalServerErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTotemRequest;
use App\Http\Requests\UpdateTotemRequest;
use App\Models\Totem;
use App\Services\TotemService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class TotemController extends Controller
{
    /**
     *  Injection of dependency with construct
     * @param mixed
     */
    public function __construct(private Totem $totem, private TotemService $totemService)
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
            $this->authorize('viewAny', Totem::class);

            $totens = $this->totem->paginate();
            return response()->json($totens);
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
    public function store(CreateTotemRequest $request)
    {
        try {
            $this->authorize('create', Totem::class);

            $totem = $this->totemService->create($request->validated());
            return response()->json($totem);
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
            $this->authorize('view', Totem::class);

            $totem = $this->totem->find($id);
            if ($totem == null) {
                return response()->json([
                    'exception' => 'NotFoundException',
                    'message' => 'Não foi encontrado nenhum totem com este ID.'
                ], 404);
            }
            return response()->json($totem);
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
    public function update(UpdateTotemRequest $request, $id)
    {
        try {
            $this->authorize('update', Totem::class);

            $totem = $this->totem->find($id);
            if ($totem == null) {
                return response()->json([
                    'exception' => 'NotFoundException',
                    'message' => 'Não foi possível encontrar um totem com este ID'
                ], 404);
            }
            $totem->update($request->validated());
            return response()->json([
                'message' => 'Totem atualizado com sucesso. '
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->authorize('delete', Totem::class);
            $totem = $this->totem->find($id);
            if ($totem == null) {
                return response()->json([
                    'exception' => 'NotFoundException',
                    'message' => 'Não foi encontrado nenhum totem com este ID.'
                ], 404);
            }
            $totem->delete();
            return response()->json([
                'message' => 'Totem excluído com sucesso.'
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
            $totens = $this->totem->where('nome', 'like', '%' . $nome . '%')->with('estabelecimento')->paginate();
            return response()->json($totens);
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }

    public function pesquisarIdentificador($identificador)
    {
        try {
            $totens = $this->totem->where('identificador', 'like', '%' . $identificador . '%')->with('estabelecimento')->paginate();
            return response()->json($totens);
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }

    public function totemComEstabelecimentos()
    {
        try {
            $totems = $this->totem->with('estabelecimento')->get();
            return response()->json($totems);
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }
}
