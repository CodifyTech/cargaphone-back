<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEstabelecimentoRequest extends FormRequest
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
            'nome' => 'sometimes',
            'razao_social' => 'sometimes',
            'cnpj' => 'sometimes',
            'responsavel' => 'sometimes',
            'contato_responsavel' => 'sometimes',
            'cep' => 'sometimes',
            'endereco' => 'sometimes',
            'cidade' => 'sometimes',
            'complemento' => 'sometimes',
            'estado' => 'sometimes',
            'tenant_id' => 'sometimes'
        ];
    }
}
