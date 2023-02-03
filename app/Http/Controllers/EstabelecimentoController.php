<?php

namespace App\Http\Controllers;

use App\Exceptions\InternalServerErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEstabelecimentoRequest;
use App\Http\Requests\UpdateEstabelecimentoRequest;
use App\Http\Resources\EstabelecimentoResource;
use App\Models\Estabelecimento;
use App\Services\EstabelecimentoService;
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
            $estabelecimentos = $this->estabelecimento->select()->paginate();
            return response()->json($estabelecimentos);
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
    public function store(CreateEstabelecimentoRequest $request)
    {
        try {
            $estabelecimento = $this->estabelecimentoService->create($request->validated());
            if ($estabelecimento == 'DuplicateCNPJEntry') {
                return response()->json([
                    'Exception' => 'DuplicateCNPJException',
                    'message' => 'Já existe um estabelecimento com este CNPJ.'
                ]);
            }

            return new EstabelecimentoResource($estabelecimento);
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
            $estabelecimento = $this->estabelecimento->find($id);
            if (!$estabelecimento) {
                return response()->json([
                    'exception' => 'NotFoundException',
                    'message' => 'Não foi encontrado nenhum estabelecimento com este ID.'
                ]);
            }

            return new EstabelecimentoResource($estabelecimento);
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
    public function update(UpdateEstabelecimentoRequest $request, $id)
    {
        try {
            $estabelecimento = $this->estabelecimentoService->updateEstablishment($request->validated(), $id);
            if ($estabelecimento === 'DuplicateCNPJException') {
                return response()->json([
                    'exception' => 'DuplicateCNPJException',
                    'message' => 'Já existe um estabelecimento com este CNPJ.'
                ]);
            }
            if ($estabelecimento === 403) {
                return response()->json([
                    'exception' => 'NotFoundException',
                    'message' => 'Não foi encontrado nenhum estabelecimento com este ID.'
                ]);
            }
            return new EstabelecimentoResource($estabelecimento);
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
            $estabelecimento = $this->estabelecimento->find($id);
            if (!$estabelecimento)
                return response()->json([
                    'exception' => 'NotFoundException',
                    'message' => 'Não foi encontrado nenhum estabelecimento com este ID.'
                ]);

            $estabelecimento->delete();
            return response()->json([
                'message' => 'Estabelecimento excluído com sucesso.'
            ]);
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }
}
