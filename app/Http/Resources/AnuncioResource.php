<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnuncioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        dd($this);
        // dd($this->relations);

        return [
            'url' => $this->arquivo,
            'exclude' => $this->ativo,
            'dataAlteracao' => $this->updated_at
        ];
        // return parent::toArray($request);
    }
}
