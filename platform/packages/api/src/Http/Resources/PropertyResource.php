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
            'country_id' => $this->country_id,
            'state_id' => $this->state_id,
            'currency_id' => $this->currency_id,
            'duration' => $this->duration,
            'price' => $this->price,
            'number_bedroom' => $this->number_bedroom,
            'number_bathroom' => $this->number_bathroom,
            'number_floor' => $this->number_floor,
            'square' => $this->square,
            'square_text' => $this->square_text,
            'type' => $this->type,
            'type_text' => $this->type_html,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'period' => $this->period,
            'status_html' => $this->status_html,
            'status' => $this->status,
            'category_name' => $this->category_name,
            // 'investor_id' => $this->investor_id,
            'map_icon' => $this->map_icon,
            'created_at' => $this->created_at,
            'reviews' => $this->reviews,
            'categories' => $this->categories,
            // 'content' => $this->content,
            'facilities' => $this->facilities,
            'features' => $this->features,
            'author' => $this->author,
        ];
    }
}

