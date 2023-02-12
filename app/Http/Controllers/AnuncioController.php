<?php

namespace App\Http\Controllers;

use App\Exceptions\InternalServerErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAnuncioRequest;
use App\Http\Requests\SyncAnuncioTotemRequest;
use App\Http\Requests\UpdateAnuncioRequest;
use App\Models\Anuncio;
use App\Services\AnuncioService;
use Illuminate\Http\Request;


class AnuncioController extends Controller
{
    /**
     *  Injection of dependency with construct
     * @param mixed
     */
    public function __construct(private Anuncio $anuncio, private AnuncioService $anuncioService)
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
            $anuncios = $this->anuncio->paginate();
            return response()->json($anuncios);
        } catch (\Exception) {
            throw new InternalServerErrorException();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAnuncioRequest $request)
    {
        try {
            $anuncio = $this->anuncioService->create($request->except('totem_id'), $request['totem_id']);
            return response()->json($anuncio, 201);
        } catch (\Exception) {
            throw new InternalServerErrorException();
        }
    }

    /**
     * Sync ad to totem.
     *
     * @param  \Illuminate\Http\SyncAnuncioTotemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function vincularAnuncioTotem(SyncAnuncioTotemRequest $request)
    {
        try {
            $syncSuccess = $this->anuncioService->syncAnuncioTotem($request->validated());
            if ($syncSuccess === 404) {
                return response()->json([
                    'exception' => 'NotFoundException',
                    'message' => 'Não foi possível encontrar nenhum anúncio com este ID.'
                ], 404);
            }
            if ($syncSuccess) {
                return response()->json([
                    'message' => 'O anúncio foi vinculado ao totem com sucesso.'
                ], 201);
            }
        } catch (\Exception $e) {
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
            $anuncio = $this->anuncio->find($id);
            if ($anuncio == null) {
                return response()->json([
                    'except' => 'NotFoundException',
                    'message' => 'Não foi encontrado nenhum anúncio com este ID',
                ], 404);
            }

            return response()->json($anuncio);
        } catch (\Exception) {
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
    public function update(UpdateAnuncioRequest $request, $id)
    {
        try {
            $anuncio = $this->anuncioService->update($request, $id);
            if ($anuncio == '404') {
                return response()->json([
                    'except' => 'NotFoundException',
                    'message' => 'Não foi encontrado nenhum anúncio com este ID',
                ], 404);
            }
            return response()->json($anuncio);
        } catch (\Exception) {
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
            $anuncio = $this->anuncio->find($id);
            if ($anuncio == null) {
                return response()->json([
                    'except' => 'NotFoundException',
                    'message' => 'Não foi encontrado nenhum anúncio',
                ], 404);
            }
            $anuncio->delete();
            return response()->json([
                'message' => 'Anúncio Excluído com sucesso'
            ], 200);
        } catch (\Exception) {
            throw new InternalServerErrorException();
        }
    }

    public function pesquisarNome($nome)
    {
        try {
            $anuncios = Anuncio::where('nome', 'like', '%' .  $nome . '%')->paginate();
            return response()->json($anuncios);
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }

    public function pesquisarTelContato($telefone)
    {
        try {
            $anuncios = Anuncio::where('tel_contato_anunciante', 'like', '%' .  $telefone . '%')->paginate();
            return response()->json($anuncios);
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }

    public function pesquisarEmailContato($email)
    {
        try {
            $anuncios = Anuncio::where('email_contato', 'like', '%' .  $email . '%')->paginate();
            return response()->json($anuncios);
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }

    public function pesquisarNomeAnunciante($nomeAnunciante)
    {
        try {
            $anuncios = Anuncio::where('nome_anunciante', 'like', '%' .  $nomeAnunciante . '%')->paginate();
            return response()->json($anuncios);
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }

    public function anunciosAtivos(){
        try{
            $anuncios = $this->anuncio->where('ativo',1)->get();        
            return response()->json(count($anuncios));
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }

    }

    public function anunciosFaturamento(){
        try{
            $faturamento = $this->anuncio->select('valor_anuncio_mensal')->sum('valor_anuncio_mensal');   
            $faturamentoFormatado = number_format($faturamento,2,',','.');        
            return response()->json($faturamentoFormatado);            
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }
}
