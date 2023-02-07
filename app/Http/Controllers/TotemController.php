<?php

namespace App\Http\Controllers;

use App\Exceptions\InternalServerErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTotemRequest;
use App\Http\Requests\UpdateTotemRequest;
use App\Models\Totem;
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
            $totens = $this->totem->paginate();
            return response()->json($totens);
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
    public function store(CreateTotemRequest $request)
    {
        try {
            $totem = $this->totem->create($request->validated());
            return response()->json($totem);
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
            $totem = $this->totem->find($id);
            if ($totem == null) {
                return response()->json([
                    'exception' => 'NotFoundException',
                    'message' => 'Não foi encontrado nenhum totem com este ID.'
                ]);
            }
            return response()->json($totem);
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
    public function update(UpdateTotemRequest $request, $id)
    {
        try {
            $totem = $this->totem->find($id);
            if ($totem == null) {
                return response()->json([
                    'exception' => 'NotFoundException',
                    'message' => 'Não foi possível encontrar um totem com este ID'
                ]);
            }
            $totem->update($request->validated());
            return response()->json([
                'message' => 'Totem atualizado com sucesso. '
            ]);
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
            $totem = $this->totem->find($id);
            if ($totem == null) {
                return response()->json([
                    'exception' => 'NotFoundException',
                    'message' => 'Não foi encontrado nenhum totem com este ID.'
                ]);
            }
            $totem->delete();
            return response()->json([
                'message' => 'Totem excluído com sucesso.'
            ]);
        } catch (\Exception) {
            throw new InternalServerErrorException();
        }
    }

    public function pesquisarNome($nome)
    {
        $totens = $this->totem->where('nome', 'like', '%' . $nome . '%')->paginate();
        return response()->json($totens);
    }

    public function pesquisarIdentificador($identificador)
    {
        $totens = $this->totem->where('identificador', 'like', '%' . $identificador . '%')->paginate();
        return response()->json($totens);
    }
}
