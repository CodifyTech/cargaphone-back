<?php

namespace App\Http\Controllers;

use App\Exceptions\InternalServerErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AlocarTotemEstabelecimentoRequest;
use App\Http\Requests\CreateTotemRequest;
use App\Http\Requests\UpdateTotemRequest;
use App\Http\Resources\AnuncioResource;
use App\Http\Resources\TotemResource;
use App\Models\Totem;
use App\Utils\Token;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class TotemController extends Controller
{
    /**
     *  Injection of dependency with construct
     * @param mixed
     */
    public function __construct(private Totem $totem)
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
            $payload = Token::decode();
            if ($payload['role_id'] !== 1) {
                $totens = $this->totem->where('tenant_id', $payload['tenant_id'])->paginate();
                return response()->json($totens);
            }
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
            $totem = $this->totem->create($request->validated());
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
                    'message' => 'N??o foi encontrado nenhum totem com este ID.'
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

    public function totemsComAnuncios($id)
    {
        try {
            $this->authorize('viewOwnTotem', $this->totem->find($id));
            $totem = $this->totem->with('anuncios')->find($id);
            if ($totem == null) {
                return response()->json([
                    'exception' => 'NotFoundException',
                    'message' => 'N??o foi encontrado nenhum totem com este ID.'
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

    public function totemsEAnuncios(Request $request)
    {
        try {
            $identificador = $request->query('totem');
            $totem = $this->totem->where('identificador', $identificador)->first();
            $anuncios = $totem->anuncios()
                ->select('arquivo as url', 'ativo as exclude', 'updated_at as dataAlteracao')
                ->where('ativo', '=', 1)
                ->get()
                ->map(function ($anuncio, $index) {
                    if ($anuncio->exclude) {
                        $anuncio->exclude = false;
                    }
                    $anuncio['index'] = $index + 0;
                    unset($anuncio->pivot);
                    return $anuncio;
                });

            return response()->json([
                'list' => $anuncios
            ]);
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
    public function update(UpdateTotemRequest $request, $id)
    {
        try {
            $this->authorize('update', Totem::class);
            $totem = $this->totem->find($id);
            if ($totem == null) {
                return response()->json([
                    'exception' => 'NotFoundException',
                    'message' => 'N??o foi poss??vel encontrar um totem com este ID'
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

    public function alocarTotemEstabelecimento(AlocarTotemEstabelecimentoRequest $request, $id)
    {
        try {
            $totem = $this->totem->find($id);
            if (!$totem) {
                return response()->json([
                    'exception' => 'NotFoundException',
                    'message' => 'Nenhum totem foi encontrado com este ID'
                ], 404);
            }
            $totem->update($request->validated());
        } catch (\Exception $e) {
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
                    'message' => 'N??o foi encontrado nenhum totem com este ID.'
                ], 404);
            }
            $totem->delete();
            return response()->json([
                'message' => 'Totem exclu??do com sucesso.'
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
            $totens = $this->totem->where('nome', 'like', '%' . $nome . '%')->with('estabelecimento')->with('anuncios')->paginate();
            return response()->json($totens);
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }

    public function pesquisarIdentificador($identificador)
    {
        try {
            $totens = $this->totem->where('identificador', 'like', '%' . $identificador . '%')->with('estabelecimento')->with('anuncios')->paginate();
            return response()->json($totens);
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }

    public function totemComEstabelecimentosEAnucios()
    {
        try {
            $payload = Token::decode();
            if ($payload['role_id'] !== 1) {
                $totems = $this->totem->with('estabelecimento')->with('anuncios')->where('tenant_id', $payload['tenant_id'])->paginate();
                return response()->json($totems);
            }
            $totems = $this->totem->with('estabelecimento')->with('anuncios')->paginate();
            return response()->json($totems);
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }

    public function totensAtivos()
    {
        try {
            $payload = Token::decode();
            if ($payload['role_id'] !== 1) {
                $totens = $this->totem->where('ativo', 1)->where('tenant_id', $payload['tenant_id'])->count('*');
                return response()->json([
                    'totens' => $totens
                ]);
            }
            $totens = $this->totem->where('ativo', 1)->count('*');
            return response()->json([
                'totens' => $totens
            ]);
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }

    public function totensInativos()
    {
        try {
            $payload = Token::decode();
            if ($payload['role_id'] !== 1) {
                $totens = $this->totem->where('ativo', 0)->where('tenant_id', $payload['tenant_id'])->count('*');
                return response()->json([
                    'totens' => $totens
                ]);
            }
            $totens = $this->totem->where('ativo', 0)->count('*');
            return response()->json([
                'totens' => $totens
            ]);
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }
}
