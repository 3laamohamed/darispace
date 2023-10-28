<?php

namespace Botble\Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvestorCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request) : array
    {
        return [
            'id' => $this->id,
            'phone' => $this->phone,
            'name' => $this->name,
            'city_name' => $this->name,
            'image' => asset('storage/'.$this->image),
            'created_at' => $this->created_at,
        ];
    }
}

