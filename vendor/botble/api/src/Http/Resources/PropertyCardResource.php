<?php

namespace Botble\Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PropertyCardResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'image' => $this->image_small,
        ];
    }
}

