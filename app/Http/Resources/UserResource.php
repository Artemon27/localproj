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
            'id' => $this->id,
            'name' => $this->name,
            'pager' => $this->pager,
            'department' => $this->department,
            'mail' => $this->mail,
            'title' => $this->title,
            'physicalDeliveryOfficeName' => $this->physicalDeliveryOfficeName,
            'telephoneNumber' => $this->telephoneNumber,
            'pechat' => $this->pechat,
        ];
    }
}
