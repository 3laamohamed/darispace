<?php

namespace Botble\Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'type' => $this->type,            
            'verified' => $this->phone_verified_at ? true : false,            
            'description' => $this->description,
            'state_id' => $this->state_id,
            'city_id' => $this->city_id,
            'website' => $this->website,
            'credits' => $this->credits,
            'packages' => $this->packages,
            'avatar' => $this->avatar_url,
            'dob' => $this->dob,
            'gender' => $this->gender,
        ];
    }
}
