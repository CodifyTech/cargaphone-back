<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'email' =>'required|email',
            'password' => 'required|string|min:8|max:30|regex:(^[a-zA-Z0-9 _-]+[a-zA-Z0-9-14\-[a-zA-Z0-9-.]+$)',
            'token' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'este campo é obrigatório.',
            'email.email' => 'Este email inválido.',
            'password.required' => 'Este campo é obrigatório.',
            'password.min' => 'A senha precisa de no minimo 8 caracteres.',
            'password.max' => 'A senha excedeu o numero maximo de caracteres.',
            'token.required' => 'Este campo é obrigatório.',
        ];
    }
}
