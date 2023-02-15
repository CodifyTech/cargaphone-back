<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => (string) $this->id,
            'nome' => (string)$this->name,
            'cargo' => (int) $this->perfil,
            'unidade_id' => (int) $this->tenant_id,
            'foto_perfil' => $this->foto_perfil,
            'email' => (string) $this->email,
        ];
    }
}
