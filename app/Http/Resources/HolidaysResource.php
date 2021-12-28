<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HolidaysResource extends JsonResource
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
            'id' => $this->id,
            'datefrom' => $this->datefrom,
            'dateto' => $this->dateto,
            'days' => $this->days,
            'PVT' => $this->PVT,
            'INV' => $this->INV,
            'OB' => $this->OB,
        ];
    }
}
