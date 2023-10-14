<?php

namespace Botble\Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'content' => strip_tags($this->content),
            'image' => $this->image_small,
            'image_thumb' => $this->image_thumb,
            'image_base_url' => asset('storage/'),
            'images' => $this->images,
            'price_html' => $this->price_html,
            'city_name' => $this->city->name??"",
            // 'state_name' => $this->city->state->name??"",
            'city_id' => $this->city_id,
            'number_floors' => $this->number_floor,
            'number_flats' => $this->number_flat,
            'square' => $this->max_space,
            'year_of_delivery' => $this->year_of_delivery,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'status' => @$this->status,
            'category_name' => $this->category_name,
            'investor_id' => $this->investor_id,
            'views' => $this->views,
            'deposit' => $this->deposit,
            'max_space' => $this->max_space,
            'min_space' => $this->min_space,
            'installment_years' => $this->installment_years,
            'map_icon' => $this->map_icon,
            'created_at' => $this->created_at,
            'categories' => $this->categories,
            'reviews' => $this->reviews,
            'investor' => $this->investor,
            'features' => $this->features,
        ];
    }
}

