<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KeysResource extends JsonResource
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
            'otdel' => $this->otdel,
            'penal' => $this->penal,
            'imp' => $this->imp,
            'id_corp' => $this->id_corp,
            'id_room' => $this->id_room,
        ];
    }
}
