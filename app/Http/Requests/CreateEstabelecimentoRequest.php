<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEstabelecimentoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nome' => 'required',
            'razao_social' => 'required',
            'cnpj' => 'required',
            'responsavel' => 'required',
            'contato_responsavel' => 'required',
            'cep' => 'required',
            'endereco' => 'required',
            'cidade' => 'required',
            'complemento' => 'sometimes',
            'estado' => 'required',
            'tenant_id' => 'required'
        ];
    }
}
