<?php

namespace App\Http\Controllers;

use App\Exceptions\InternalServerErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUnidadeRequest;
use App\Http\Requests\UpdateUnidadeRequest;
use App\Models\Unidade;
use Illuminate\Http\Request;

class UnidadeController extends Controller
{
    /**
     *  Injection of dependency with construct
     * @param mixed
     */
    public function __construct(private Unidade $unidade)
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
            $unidades = $this->unidade->paginate();
            return response()->json($unidades, 200);
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
    public function store(CreateUnidadeRequest $request)
    {
        try {
            $input = $request->validated();
            $unidade = $this->unidade->create($input);
            return response()->json($unidade, 201);
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
            $unidade = $this->unidade->find($id);
            if ($unidade == null) {
                return response()->json([
                    'message' => 'Não foi encontrado nenhuma unidade.'
                ], 404);
            }
            return response()->json($unidade, 200);
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
    public function update(UpdateUnidadeRequest $request, $id)
    {
        try {
            $input = $request->validated();
            $unidade = $this->unidade->find($id);
            if ($unidade == null) {
                return response()->json([
                    'message' => 'Não foi encontrado nenhuma unidade.'
                ], 404);
            }
            $unidade->update($input);
            return response()->json($unidade);
        } catch (\Exception) {
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
        } catch (\Exception) {
            throw new InternalServerErrorException();
        }
    }  

    public function pesquisarNome($nome)
    {
        try {
            $unidade = Unidade::where('nome', 'like', '%' .  $nome . '%')->paginate();
            return response()->json($unidade);
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }

    public function pesquisarCnpj($cnpj)
    {
        try {
            $unidade = Unidade::where('cnpj_empresa', 'like', '%' .  $cnpj . '%')->paginate();
            return response()->json($unidade);
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }

    public function pesquisarResponsavel($responsavel)
    {
        try {
            $unidade = Unidade::where('nome_responsavel', 'like', '%' .  $responsavel . '%')->paginate();
            return response()->json($unidade);
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }

    public function pesquisarCidade($cidade)
    {
        try {
            $unidade = Unidade::where('cidade', 'like', '%' .  $cidade . '%')->paginate();
            return response()->json($unidade);
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }

    public function pesquisarEstado($estado)
    {
        try {
            $unidade = Unidade::where('estado', 'like', '%' .  $estado . '%')->paginate();
            return response()->json($unidade);
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }
}
