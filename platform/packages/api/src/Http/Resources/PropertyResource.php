<?php

namespace Botble\Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
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
            'url' => $this->url,
            'description' => $this->description,
            'image' => $this->image_small,
            'image_thumb' => $this->image_thumb,
            'images' => $this->images,
            'price_html' => $this->price_html,
            'city_name' => $this->city_name,
            'city_id' => $this->city_id,
            'number_bedroom' => $this->number_bedroom,
            'number_bathroom' => $this->number_bathroom,
            'square' => $this->square,
            'square_text' => $this->square_text,
            'type' => $this->type,
            'type_text' => $this->type_html,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'period' => $this->period,
            'status_html' => $this->status_html,
            'category_name' => $this->category_name,
            'investor_id' => $this->investor_id,
            'map_icon' => $this->map_icon,
            'reviews' => $this->reviews,
        ];
    }
}

