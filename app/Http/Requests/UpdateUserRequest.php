<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email',
            'perfil' => 'required',
            'cpf_usuario' => 'sometimes',
            'rg_usuario' => 'sometimes',
            'sexo' => 'sometimes',
            'dt_nascimento' => 'sometimes',
            'tel_contato' => 'sometimes',
            'is_whatsapp' => 'sometimes',
            'foto_perfil' => 'sometimes|max:2048',
            'nome_rua' => 'sometimes',
            'numero_residencia' => 'sometimes',
            'cep' => 'sometimes',
            'cidade' => 'sometimes',
            'bairro' => 'sometimes',
            'estado' => 'sometimes',
        ];
    }
}
