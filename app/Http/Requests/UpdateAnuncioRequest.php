<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnuncioRequest extends FormRequest
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
            'arquivo' => 'required',
            'nome_anunciante' => 'required',
            'valor_anuncio_mensal' => 'required',
            'data_fim_campanha' => 'required',
            'data_comeco_campanha' => 'sometimes',
            'tipo_campanha' => 'required',
            'tel_contato_anunciante' => 'required',
            'email_contato' => 'required|email',
            'totem_id' => 'sometimes'
        ];
    }
}
