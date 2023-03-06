<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TotemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        // dd($this->anuncios());
        // dd($this->resource[0]);
        return [
            'url' => $this
        ];
        // return parent::toArray($request);
    }
}
