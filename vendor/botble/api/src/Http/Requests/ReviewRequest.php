<?php

namespace Botble\Api\Http\Requests;

use Botble\RealEstate\Models\Project;
use Botble\RealEstate\Models\Property;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class ReviewRequest extends Request
{
    public function rules(): array
    {
        return [
            'reviewable_type' =>['required', Rule::in([Property::class, Project::class])],
            'star' => 'required|int|min:1|max:5',
            'content' => 'required|string|min:4|max:500',
        ];
    }
}
